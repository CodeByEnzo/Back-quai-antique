<?php ob_start(); ?>

<form method="post" action="<?= URL ?>back/gallerys/creationValidation" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="gallery_title" class="form-label">Title</label>
        <input type="text" class="form-control" id="gallery_title" name="gallery_title">
    </div>
    <div class="mb-3">
        <label for="gallery_content" class="form-label">Content</label>
        <textarea class="form-control" id="gallery_content" name="gallery_content"></textarea>
    </div>
    <div class="mb-3">
        <label for="gallery_img" class="form-label">Ajouter une image</label>
        <input type="file" class="form-control-file" id="gallery_img" name="gallery_img"></input>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php
$content = ob_get_clean();
$title = "Page d'administration de la gallerie";
require "views/commons/template.php";
