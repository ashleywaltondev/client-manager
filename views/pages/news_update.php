<?php
//Process the updated article if the form has been submitted
if( isset($_POST['update_article']) ) {
    //See what's happening with the images  
    if($_POST['article_image'] == 'new') {
        $error = upload_image('/news', $_FILES['uploaded_article_image'], $_POST['article_id']);
        //$error $upload_result
        if( isset($error['0']) ) {
            $del_path = str_replace("/var/www/manager/public","",$error['0']['loc']);
            $article_image = $del_path;
        }
    }
    if($_POST['article_image'] == 'delete') {
        $article_image = '';
    }
    if($_POST['article_image'] == 'current') {
        $article_image = $_POST['current_article_image'];
    }
    //Need edge cases for delete unsuccesful 

    //Validate the title
    if($_POST['article_title'] !== '') {
        $title_entry_valid = 1;
    }
    if($_POST['article_title'] == '') {
        $e['title'] = 1;
        $e['title_error'] = 'Your article must have a title.';
    }

    //Validate content
    if($_POST['article_content'] !== null) {
        $content_entry_valid = 1;
    }
    if($_POST['article_content'] == null) {
        $e['content'] = 1;
        $e['content_error'] = 'Your article must have some text.';
    }

    if($title_entry_valid == 1 AND $content_entry_valid == 1) {
        execute_query("UPDATE `webmanager`.`articles` SET `image`='".$article_image."' WHERE `id`='".$_POST['article_id']."';");
        $success_modal = 1;
        echo '
            
        ';
    }
    else {
        $error_modal = 1;
        $gen_error = '
            <div class="modal modal-sm">
                <a href="#close" class="modal-overlay" aria-label="Close"></a>
                <div class="modal-container">
                    <p>There was an error trying to update your article. Please review your submission and try again.</p>
                </div>
            </div>
        ';
    }
}


$results = query_db('SELECT * FROM articles WHERE id="'.$_GET['id'].'"');
if($results) {
    foreach($results as $result) {
?>

<div class="card">
    <div class="card-header">
        <div class="card-title h2">Update Article</div>
    </div>

    <form method="post" action="" enctype="multipart/form-data">
        <div class="card-body">
            <?php if($gen_error !== null) { echo '<p>'.$gen_error.'<p>'; } ?>
            <input type="hidden" name="update_article" value="1">
            <input type="hidden" name="article_id" value="<?=$result['id'];?>">
            <input type="hidden" name="current_article_image" value="<?=$result['image'];?>">

            <div class="form-group <?php if( $e['title'] == 1 ) { echo 'has-error'; } ?>">
                <label class="form-label" for="article_title">Title</label>
                <?php if( $e['title'] == 1 ) { echo '<p class="form-input-hint form-input-hint-top">'.$e['title_error'].'</p>'; } ?>
                <input class="form-input" type="text" id="article_title" name="article_title" placeholder="Title" value="<?=$result['title'];?>">
            </div>

            <div class="divider"></div>

            <div class="form-group <?php if( isset($error['1']['message']) ) { echo 'has-error'; } ?>">
                <label class="form-label">Image</label>
                <?php if( isset($error['1']['message']) ) { echo '<p class="form-input-hint form-input-hint-top">'.$error['1']['message'].'</p>'; } ?>
                <label class="form-radio">
                    <input type="radio" name="article_image" value="current" <?php if ( isset($error['0']) || !isset($error['1']) ) { echo 'checked'; } ?>>
                    <i class="form-icon"></i> Use currently saved image
                    <a href="#preview-image">(preview)</a>
                </label>
                <label class="form-radio">
                    <input type="radio" name="article_image" value="new" <?php if ( isset($error['1']) ) { echo 'checked'; } ?>>
                    <i class="form-icon"></i> Replace current image
                </label> 

                <div id="upload_image_form_container" style="display:none">
                    <input class="form-input" type="file" id="input-example-2" name="uploaded_article_image" placeholder="Image" value="">
                </div>

                <label class="form-radio">
                    <input type="radio" name="article_image" value="delete">
                    <i class="form-icon"></i> Delete saved image
                </label>  
            </div>        
                    
            <div class="divider"></div>
            
            <div class="form-group <?php if( $e['content'] == 1 ) { echo 'has-error'; } ?>">        
                <label class="form-label" for="article_content">Content</label>
                <?php if( $e['content'] == 1 ) { echo '<p class="form-input-hint form-input-hint-top">'.$e['content_error'].'</p>'; } ?>
                <textarea class="form-input" type="text" name="article_content" id="article_content" placeholder="Content" style="height: 13rem;"><?=$result['content'];?></textarea>
            </div> 

            <div class="divider"></div>
        </div>
        <div class="card-footer">
            <input class="btn btn-primary" type="submit" value="Update Article">
            <a class="btn" href="/?1=news">Discard</a>
        </div>
    </form>
</div>

<h2></h2>
    

<div class="modal" id="preview-image">
  <a href="#close" class="modal-overlay" aria-label="Close"></a>
  <div class="modal-container">
    <div class="modal-header">
      <a href="#close" class="btn btn-clear float-right" aria-label="Close"></a>
    </div>
    <div class="modal-body">
      <div class="content">
        <!-- content here -->
        <div style="box-sizing: border-box; padding: 2rem; width: 100%; height: 100%; text-align: center;">
            <img src="<?=$result['image'];?>" style="max-width: 100%; max-height: 100%; margin: auto;">
        </div>
      </div>
    </div>
    <div class="modal-footer">
    </div>
  </div>
</div>


<?php
    }
}
?>

<?php   if($success_modal == 1) {   ?>
<div id="success_modal" class="modal modal-sm">
    <a href="#close" class="modal-overlay" aria-label="Close"></a>
    <div class="modal-container">
    <div class="modal-body">
        <div class="content">
            <p>Your article has been updated successfully!</p>
        </div>
    </div>
    <div class="modal-footer">
    <a href="#close" id="close" class="btn btn-primary float-right" aria-label="Close">Close</a>
    </div>
</div>
<script type="text/javascript">
$(window).on('load',function(){
    $("#success_modal").addClass("active");
});
</script>
<?php   }   ?>
<?php   if($error_modal == 1) {   ?>
    <div id="error_modal" class="modal modal-sm">
    <a href="#close" class="modal-overlay" aria-label="Close"></a>
    <div class="modal-container">
    <div class="modal-body">
        <div class="content">
            <p>There was an error updating your article. Please review your changes.</p>
        </div>
    </div>
    <div class="modal-footer">
    <a href="#close" id="close" class="btn btn-primary float-right" aria-label="Close">Close</a>
    </div>
</div>
<script type="text/javascript">
$(window).on('load',function(){
    $("#error_modal").addClass("active");
});
</script>
<?php   }   ?>

<script type="text/javascript">
  $("input[name='article_image']:radio")
    .change(function() {
      $("#upload_image_form_container").toggle($(this).val() == "new");
    });
    $("#close").click(function() {
        $(".modal").removeClass("active")
    });
</script>
