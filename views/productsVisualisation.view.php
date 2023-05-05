<?php ob_start(); ?>

<h2>Entrées</h2>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Produit</th>
            <th scope="col">Description</th>
            <th scope="col">Prix</th>
            <th scope="col">Catégorie</th>
            <th scope="col" colspan="2">actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product) : ?>
            <?php if ($product['category_id'] == 1) : ?>
                <?php if (isset($_POST['product_id']) && $_POST['product_id'] == $product['product_id']) : ?>
                    <form method="post" action="<?= URL ?>back/products/validationModification">
                        <tr>
                            <td><?= $product['product_id'] ?></td>
                            <td><input type="text" name="title" class="form-control" value="<?= $product['title'] ?>" /></td>
                            <td><textarea name='content' class="form-control" rows="3"><?= $product['content'] ?></textarea></td>
                            <td><input type="text" name="prix" class="form-control" value="<?= $product['prix'] ?>" /></td>
                            <td><input type="text" name="category_id" class="form-control" value="<?= $product['category_id'] ?>" /></td>
                            <td colspan="2">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" />
                                <button class="btn btn-primary" type="submit">Valider</button>
                            </td>
                        </tr>
                    </form>
                <?php else : ?>
                    <tr>
                        <td><?= $product['product_id'] ?></td>
                        <td><?= $product['title'] ?></td>
                        <td><?= $product['content'] ?></td>
                        <td><?= $product['prix'] ?></td>
                        <td><?= $product['category_id'] ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" />
                                <button class="btn btn-warning" type="submit">Modifier</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="<?= URL ?>back/products/validationDelete" onSubmit="return confirm('Voulez-vous vraiment supprimer ?');">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" />
                                <button class="btn btn-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<h2>Plats</h2>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Produit</th>
            <th scope="col">Description</th>
            <th scope="col">Prix</th>
            <th scope="col">Catégorie</th>
            <th scope="col" colspan="2">actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product) : ?>
            <?php if ($product['category_id'] == 2) : ?>
                <?php if (isset($_POST['product_id']) && $_POST['product_id'] == $product['product_id']) : ?>
                    <form method="post" action="<?= URL ?>back/products/validationModification">
                        <tr>
                            <td><?= $product['product_id'] ?></td>
                            <td><input type="text" name="title" class="form-control" value="<?= $product['title'] ?>" /></td>
                            <td><textarea name='content' class="form-control" rows="3"><?= $product['content'] ?></textarea></td>
                            <td><input type="text" name="prix" class="form-control" value="<?= $product['prix'] ?>" /></td>
                            <td><input type="text" name="category_id" class="form-control" value="<?= $product['category_id'] ?>" /></td>
                            <td colspan="2">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" />
                                <button class="btn btn-primary" type="submit">Valider</button>
                            </td>
                        </tr>
                    </form>
                <?php else : ?>
                    <tr>
                        <td><?= $product['product_id'] ?></td>
                        <td><?= $product['title'] ?></td>
                        <td><?= $product['content'] ?></td>
                        <td><?= $product['prix'] ?></td>
                        <td><?= $product['category_id'] ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" />
                                <button class="btn btn-warning" type="submit">Modifier</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="<?= URL ?>back/products/validationDelete" onSubmit="return confirm('Voulez-vous vraiment supprimer ?');">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" />
                                <button class="btn btn-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<h2>Desserts</h2>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Produit</th>
            <th scope="col">Description</th>
            <th scope="col">Prix</th>
            <th scope="col">Catégorie</th>
            <th scope="col" colspan="2">actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product) : ?>
            <?php if ($product['category_id'] == 3) : ?>
                <?php if (isset($_POST['product_id']) && $_POST['product_id'] == $product['product_id']) : ?>
                    <form method="post" action="<?= URL ?>back/products/validationModification">
                        <tr>
                            <td><?= $product['product_id'] ?></td>
                            <td><input type="text" name="title" class="form-control" value="<?= $product['title'] ?>" /></td>
                            <td><textarea name='content' class="form-control" rows="3"><?= $product['content'] ?></textarea></td>
                            <td><input type="text" name="prix" class="form-control" value="<?= $product['prix'] ?>" /></td>
                            <td><input type="text" name="category_id" class="form-control" value="<?= $product['category_id'] ?>" /></td>
                            <td colspan="2">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" />
                                <button class="btn btn-primary" type="submit">Valider</button>
                            </td>
                        </tr>
                    </form>
                <?php else : ?>
                    <tr>
                        <td><?= $product['product_id'] ?></td>
                        <td><?= $product['title'] ?></td>
                        <td><?= $product['content'] ?></td>
                        <td><?= $product['prix'] ?></td>
                        <td><?= $product['category_id'] ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" />
                                <button class="btn btn-warning" type="submit">Modifier</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="<?= URL ?>back/products/validationDelete" onSubmit="return confirm('Voulez-vous vraiment supprimer ?');">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" />
                                <button class="btn btn-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = "Administration des produits";
require "views/commons/template.php";
