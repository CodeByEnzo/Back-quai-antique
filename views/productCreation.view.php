<?php ob_start(); ?>

<form method="post" action="<?= URL ?>back/products/creationValidation" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title">
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" id="content" name="content"></textarea>
    </div>
    <div class="mb-3">
        <label for="prix" class="form-label">Prix</label>
        <input type="text" class="form-control" id="prix" name="prix"></input>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Categorie</label>
        <input type="text" class="form-control" id="category_id" name="category_id" placeholder="1 pour les entrées / 2 pour les plats / 3 pour les desserts"></input>
    </div>
    <div class="mb-3">
        <label for="product_image" class="form-label">Ajouter une image</label>
        <input type="file" class="form-control-file" id="product_image" name="product_image"></input>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php
$content = ob_get_clean();
$title = "Page de création d'un plat";
require "views/commons/template.php";
