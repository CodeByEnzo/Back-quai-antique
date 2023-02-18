<?php ob_start(); ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Client</th>
            <th scope="col">Email</th>
            <th scope="col">Mot de passe</th>
            <th scope="col" colspan="2">actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client) : ?>
            <?php if (isset($_POST['client_id']) && $_POST['client_id'] == $client['client_id']) : ?>
                <form method="post" action="<?= URL ?>back/clients/validationModification">
                    <tr>
                        <td><?= $client['client_id'] ?></td>
                        <td><input type="text" name="username" class="form-control" value="<?= $client['username'] ?>" /></td>
                        <td><input type="text" name='email' class="form-control" rows="3" value="<?= $client['email'] ?>" /></td>
                        <td><input type="text" name='password' class="form-control" rows="3" value="<?= $client['password'] ?>" /></td>
                        <input type="hidden" name="client_id" value="<?= $client['client_id'] ?>" />
                        <td colspan="2">
                            <button class="btn btn-primary" type="submit">Valider</button>
                        </td>
                    </tr>
                </form>
            <?php else : ?>
                <tr>
                    <td><?= $client['client_id'] ?></td>
                    <td><?= $client['username'] ?></td>
                    <td><?= $client['email'] ?></td>
                    <td><?= $client['password'] ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="client_id" value="<?= $client['client_id'] ?>" />
                            <button class="btn btn-warning" type="submit">Modifier</button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="<?= URL ?>back/clients/validationDelete" onSubmit="return confirm('Voulez-vous vraiment supprimer ?');">
                            <input type="hidden" name="client_id" value="<?= $client['client_id'] ?>" />
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
$title = "Administration des clients";
require "views/commons/template.php";
?>