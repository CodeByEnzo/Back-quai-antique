<?php ob_start(); ?>

<table class="table table-hover table-dark">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">ID Client</th>
            <th scope="col">Nom</th>
            <th scope="col">Date</th>
            <th scope="col">Heure</th>
            <th scope="col">Commentaire</th>
            <th scope="col">Téléphone</th>
            <th scope="col" colspan="2">actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservations as $reservation) : ?>
            <?php if (isset($_POST['reservation_id']) && $_POST['reservation_id'] == $reservation['reservation_id']) : ?>
                <!--Inputs to modify client's reservation-->
                <form method="POST" action="<?= URL ?>back/reservations/validationModification">
                    <tr>
                        <td><?= $reservation['reservation_id'] ?></td>
                        <td><?= $reservation['client_id'] ?></td>
                        <td><?= $reservation['client_id'] ?></td>
                        <!-- Hidden input contains client's ID (cant be changed)-->
                        <input type="hidden" name="client_id" value="<?= $reservation['client_id'] ?>" />
                        <td><input type="text" name="date" class="form-control" value="<?= $reservation['date'] ?>" /></td>
                        <td><input type="text" name="time" class="form-control" value="<?= $reservation['time'] ?>" /></td>
                        <td><textarea name='comments' class="form-control" rows="3"><?= $reservation['comments'] ?></textarea></td>
                        <td><p><?= $reservation['client_number'] ?></p></td>

                        <td colspan="2">
                            <input type="hidden" name="reservation_id" value="<?= $reservation['reservation_id'] ?>" />
                            <button class="btn btn-primary" type="submit">Valider</button>
                        </td>
                    </tr>
                </form>
            <?php else : ?>
                <tr>
                    <td><?= $reservation['reservation_id'] ?></td>
                    <td><?= $reservation['client_id'] ?></td>
                    <td><?= $reservation['date'] ?></td>
                    <td><?= $reservation['time'] ?></td>
                    <td><?= $reservation['comments'] ?></td>
                    <td><?= $reservation['client_number'] ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="reservation_id" value="<?= $reservation['reservation_id'] ?>" />
                            <button class="btn btn-warning" type="submit">Modifier</button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="<?= URL ?>back/reservations/validationDelete" onSubmit="return confirm('Voulez-vous vraiment supprimer ?');">
                            <input type="hidden" name="reservation_id" value="<?= $reservation['reservation_id'] ?>" />
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
$title = "Administration des réservations";
require "views/commons/template.php";
?>