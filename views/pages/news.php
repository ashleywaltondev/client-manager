<h2>List Articles</h2>

<div class="container">
<?php
$results = query_db("SELECT * FROM articles");
if ($results) {
    foreach ($results as $result) {
?>


    <div class="column col-6">
        <div class="card">
            <div class="card-image card-image-small">
                <img src="<?=$result['image']?>" class="img-responsive">
            </div>
            <div class="card-header">
                <div class="card-title h5"><?=$result['title']?></div>
            </div>
            <div class="card-body">
                <p><?=truncate_text($result['content'])?></p>
            </div>
            <div class="card-footer">
                <a class="btn btn-primary" href="/?1=news&2=update&id=<?=$result['id']?>">Edit</a>
                <button class="btn">Delete</button>
            </div>
        </div>
    </div>
  </div>

<?php
    }
}
?>

</div>