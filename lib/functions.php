<?php
function truncate_text($str) {
    $truncate_length = 108;
    if (strlen($str) > $truncate_length) { 
        $str = substr($str, 0, strrpos(substr($str, 0, $truncate_length), ' '));
        $str = $str.' [...]';
    }
    return $str;
}

function upload_image($folder, $file_selector, $file_name) {    // upload_image('/news', $_FILES["uploaded_article_image"])
    $target_dir = $GLOBALS['CONFIG_FULLPATH'].$folder.'/'; // $folder = '/news';

    $temp = explode(".", $file_selector["name"]);
    $target_file = $file_name . '.' . end($temp);

	$uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($file_selector['tmp_name']);
		if($check !== false) {
			echo "File is an image - " . $check['mime'] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	// Check file size
	if ($file_selector["size"] > 500000) {
		$error_case = "Your image must be less than 5MB.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		$error_case = "Your image must be a JPG, JPEG, PNG, or GIF file.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
        $error['1']['message'] = $error_case;
        return $error;
	// if everything is ok, try to upload file
	} else {
		if ( move_uploaded_file($file_selector["tmp_name"], $target_dir . $target_file) ) {
            $error['0'];
            $error['0']['loc'] = $target_dir . $target_file;
            return $error;
		} else {
            $error['1']['message'] = "Sorry, there was an error uploading your file. Please try again.";
            echo $_FILES["file"]["error"];
            return $error;
		}
	}
}