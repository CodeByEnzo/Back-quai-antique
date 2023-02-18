<?php ob_start(); ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Produit</th>
            <th scope="col">Description</th>
            <th scope="col">img</th>
            <th scope="col" colspan="2">actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($gallerys as $gallery) : ?>
            <?php if (isset($_POST['gallery_id']) && $_POST['gallery_id'] == $gallery['gallery_id']) : ?>
                <form method="post" action="<?= URL ?>back/gallerys/validationModification" enctype="multipart/form-data">
                    <tr>
                        <td><?= $gallery['gallery_id'] ?></td>
                        <td><input type="text" name="gallery_title" class="form-control" value="<?= $gallery['gallery_title'] ?>" /></td>
                        <td><textarea name='gallery_content' class="form-control" rows="3"><?= $gallery['gallery_content'] ?></textarea></td>
                        <td>
                            <label for="gallery_img" class="form-label">Ajouter une image</label>
                            <input type="file" class="form-control-file" id="gallery_img" name="gallery_img"></input>
                        </td>
                        <td colspan="2">
                            <input type="hidden" name="gallery_id" value="<?= $gallery['gallery_id'] ?>" />
                            <button class="btn btn-primary" type="submit">Valider</button>
                        </td>
                    </tr>
                </form>
            <?php else : ?>
                <tr>
                    <td><?= $gallery['gallery_id'] ?></td>
                    <td><?= $gallery['gallery_title'] ?></td>
                    <td><?= $gallery['gallery_content'] ?></td>
                    <td><?= $gallery['gallery_img'] ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="gallery_id" value="<?= $gallery['gallery_id'] ?>" />
                            <button class="btn btn-warning" type="submit">Modifier</button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="<?= URL ?>back/gallerys/validationDelete" onSubmit="return confirm('Voulez-vous vraiment supprimer ?');">
                            <input type="hidden" name="gallery_id" value="<?= $gallery['gallery_id'] ?>" />
                            <button class="btn btn-danger" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = "Administration de la gallerie";
require "views/commons/template.php";
?>