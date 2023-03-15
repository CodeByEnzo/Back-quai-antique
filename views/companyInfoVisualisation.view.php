<?php ob_start(); ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Name</th>
            <th scope="col">Adresse</th>
            <th scope="col">Téléhpone</th>
            <th scope="col">Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($companyInfo as $compan) : ?>
            <?php if (isset($_POST['id']) && $_POST['id'] == $companyInfo['id']) : ?>
                <form method="POST" action="<?= URL ?>back/companyInfo/validationModification">
                    <tr>
                        <td><?= $companyInfo['id'] ?></td>
                        <td><input type="text" name="name" class="form-control" value="<?= $companyInfo['name'] ?>" /></td>
                        <td><input type="text" name="adress" class="form-control" value="<?= $companyInfo['adress'] ?>" /></td>
                        <td><input type="text" name="phone" class="form-control" value="<?= $companyInfo['phone'] ?>" /></td>
                        <td><input type="text" name="email" class="form-control" value="<?= $companyInfo['email'] ?>" /></td>

                        <td colspan="2">
                            <input type="hidden" name="id" value="<?= $companyInfo['id'] ?>" />
                            <button class="btn btn-primary" type="submit">Valider</button>
                        </td>
                    </tr>
                </form>
            <?php else : ?>
                <tr>
                    <td><?= $companyInfo['id'] ?></td>
                    <td><?= $companyInfo['name'] ?></td>
                    <td><?= $companyInfo['adress'] ?></td>
                    <td><?= $companyInfo['phone'] ?></td>
                    <td><?= $companyInfo['email'] ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="id" value="<?= $companyInfo['id'] ?>" />
                            <button class="btn btn-warning" type="submit">Modifier</button>
                        </form>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = "Administration des informations de l'entreprise";
require "views/commons/template.php";
?>