<?php ob_start(); ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Titre</th>
            <th scope="col">Auteur</th>
            <th scope="col">Date</th>
            <th scope="col" colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach ($articles as $article) : ?>
                <?php if (isset($_POST['id']) && $_POST['id'] == $article['id']) : ?>
                    <form method="post" action="<?= URL ?>back/blog/validationModification">
                        <td><?= $article['id'] ?></td>
                        <td><input type="text" name="title" class="form-control" value="<?= $article['title'] ?>" /></td>
                        <td><input type="text" name="author" class="form-control" value="<?= $article['author'] ?>" /></td>
                        <td><?= $article['date_creation'] ?></td>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?= $companyInfo['id'] ?>" />
                            <button class="btn btn-primary m-1" type="submit">Valider</button>
                            <a href="<?= URL ?>back/blog/visualisation" class="btn btn-primary m-1">Annuler</a>
                        </td>
                    </form>
        </tr>
    </tbody>
</table>
<?php foreach ($blocs as $bloc) : ?>
    <?php if (isset($_POST['id']) && $_POST['id'] == $bloc['article_id']) : ?>
        <form class="m-3 p-2 bg-dark rounded border border-warning" method="post" action="<?= URL ?>back/blog/validationModification">
            <div class="p-4 row">
                <h4 class=" text-warning">
                    Bloque <?= $bloc['order_index'] ?>
                </h4>
                <div class="col col-md-5">
                    <div class="input-group">
                        <label class="input-group-text mb-2" for="inputGroupSelect01">Choose a type:</label>
                        <select class="form-select mb-2" id="inputGroupSelect01">
                            <option selected><?= $bloc['type'] ?></option>
                            <option value="image">Image</option>
                            <option value="h1">h1</option>
                            <option value="h2">h2</option>
                            <option value="h3">h3</option>
                            <option value="h4">h4</option>
                            <option value="h5">h5</option>
                            <option value="paragraphe">Paragraphe</option>
                        </select>
                    </div>
                    <div>
                        <label for="order_index" class="text-light">Position du bloque :</label>
                        <input type="number" id="order_index" name="order_index" class="form-control mb-2 mx-auto" value="<?= $bloc['order_index'] ?>" />
                    </div>
                </div>


                <div>
                    <label for="content" class="text-light">Contenu :</label>
                    <input type="text" id="content" name="content" class="form-control mb-2 mx-auto" value="<?= $bloc['content'] ?>" />
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-warning m-1" type="submit">Valider</button>
                    <a href="<?= URL ?>back/blog/visualisation" class="btn btn-warning m-1">Annuler</a>

                </div>
            </div>


        </form>
    <?php endif; ?>
<?php endforeach; ?>
<?php else : ?>
    <tbody>
        <tr>
            <td><?= $article['id'] ?></td>
            <td><?= $article['title'] ?></td>
            <td><?= $article['author'] ?></td>
            <td><?= $article['date_creation'] ?></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="id" value="<?= $article['id'] ?>" />
                    <button class="btn btn-warning" type="submit">Modifier</button>
                </form>
            </td>
            <td>
                <form method="post" action="<?= URL ?>back/blog/validationDelete" onSubmit="return confirm('Voulez-vous vraiment supprimer ?');">
                    <input type="hidden" name="id" value="<?= $article['id'] ?>" />
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
    $title = "Administration des articles du blog";
    require "views/commons/template.php";
    ?>