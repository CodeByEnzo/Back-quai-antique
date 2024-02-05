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
        <?php foreach ($articles as $article) : ?>
            <?php if (isset($_POST['id']) && $_POST['id'] == $article['id']) : ?>
                <td><?= $article['id'] ?></td>
                <td>
                    <?php if (isset($_POST['id']) && $_POST['id'] == $article['id']) : ?>
                        <form method="post" action="<?= URL ?>back/blog/validationModification">
                            <input type="text" name="content" class="form-control" value="<?= $article['content'] ?>" />
                            <input type="hidden" name="article_id" value="<?= $article['id'] ?>" />
                            <button class="btn btn-primary" type="submit">Valider</button>
                        </form>
                    <?php else : ?>
                        <?= $article['content'] ?>
                        <form method="post" action="<?= URL ?>back/blog/validationModification">
                            <input type="hidden" name="id" value="<?= $article['id'] ?>" />
                            <button class="btn btn-secondary" type="submit">Modifier</button>
                        </form>
                    <?php endif; ?>
                </td>
                <td>
                    <?php foreach ($article['blocs'] as $bloc) : ?>
                        <div>
                            <label for="type">Type <?= $bloc['type'] ?>:</label>
                            <input type="text" name="type[<?= $bloc['type'] ?>]" class="form-control" value="<?= $bloc['content'] ?>" />
                        </div>
                    <?php endforeach; ?>
                </td>
            <?php else : ?>
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