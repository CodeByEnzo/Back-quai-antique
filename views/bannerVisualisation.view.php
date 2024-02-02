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
        <?php foreach ($banner as $banner) : ?>
            <?php if (isset($_POST['ID']) && $_POST['ID'] == $banner['ID']) : ?>
                <form method="post" action="<?= URL ?>back/banner/validationModification" enctype="multipart/form-data">
                    <tr>
                        <td><?= $banner['ID'] ?></td>
                        <td>
                            <input type="text" name="Name" class="form-control" value="<?= $banner['Name'] ?>" />
                        </td>
                        <td>
                            <textarea name='AltText' class="form-control" rows="3">
                                <?= $banner['AltText'] ?>
                            </textarea>
                        </td>
                        <td>
                            <label for="Image" class="form-label">Ajouter une image</label>
                            <input type="file" class="form-control-file" id="Image" name="Image"></input>
                        </td>
                        <td colspan="2">
                            <input type="hidden" name="ID" value="<?= $banner['ID'] ?>" />
                            <button class="btn btn-primary" type="submit">Valider</button>
                        </td>
                    </tr>
                </form>
            <?php else : ?>
                <tr>
                    <td><?= $banner['ID'] ?></td>
                    <td><?= $banner['Name'] ?></td>
                    <td><?= $banner['AltText'] ?></td>
                    <td><?= $banner['Image'] ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="ID" value="<?= $banner['ID'] ?>" />
                            <button class="btn btn-warning" type="submit">Modifier</button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="<?= URL ?>back/banner/validationDelete" onSubmit="return confirm('Voulez-vous vraiment supprimer ?');">
                            <input type="hidden" name="ID" value="<?= $banner['ID'] ?>" />
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
$title = "Administration de la bannière";
require "views/commons/template.php";
?>