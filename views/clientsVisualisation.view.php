<?php ob_start(); ?>

<table class="table border-dark text-center mt-5">
    <thead>
        <tr class="text-center bg-light rounded">
            <th class="bg-info-subtle" scope="col">#ID</th>
            <th class="bg-primary-subtle" scope="col">Client</th>
            <th class="bg-info-subtle" scope="col">Email</th>
            <th class="bg-primary-subtle" scope="col">Numéro</th>
            <th class="bg-info-subtle" scope="col" colspan="2">actions</th>
        </tr>
    </thead>
    <tbody class="bg-light">
        <?php foreach ($clients as $client) : ?>
            <?php if (isset($_POST['client_id']) && $_POST['client_id'] == $client['client_id']) : ?>
                <form method="post" action="<?= URL ?>back/clients/validationModification">
                    <tr>
                        <td><?= $client['client_id'] ?></td>
                        <td><input type="text" name="username" class="form-control" value="<?= $client['username'] ?>" /></td>
                        <td><input type="text" name='email' class="form-control" rows="3" value="<?= $client['email'] ?>" /></td>
                        <td><input type="text" name='number' class="form-control" rows="3" value="<?= $client['number'] ?>" /></td>
                        <input type="hidden" name="client_id" value="<?= $client['client_id'] ?>" />
                        <td colspan="2">
                            <button class="btn btn-success" type="submit">Valider</button>
                        </td>
                    </tr>
                </form>
            <?php else : ?>
                <tr>
                    <td class="bg-primary-subtle"><?= $client['client_id'] ?></td>
                    <td class="bg-info-subtle"><?= $client['username'] ?></td>
                    <td class="bg-primary-subtle"><?= $client['email'] ?></td>
                    <td class="bg-info-subtle"><?= $client['number'] ?></td>
                    <td class="bg-primary-subtle">
                        <form method="post" action="">
                            <input type="hidden" name="client_id" value="<?= $client['client_id'] ?>" />
                            <button class="btn btn-warning" type="submit">Modifier</button>
                        </form>
                    </td>
                    <td class="bg-primary-subtle">
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