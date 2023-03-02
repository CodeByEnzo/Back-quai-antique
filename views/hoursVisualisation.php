<?php ob_start(); ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Jour</th>
            <th scope="col">ouverture déjeuner</th>
            <th scope="col">fermeture déjeuner</th>
            <th scope="col">ouverture dîner</th>
            <th scope="col">fermeture dîner</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($hours as $hour) : ?>
            <?php if (isset($_POST['id']) && $_POST['id'] == $hour['id']) : ?>
                <form method="POST" action="<?= URL ?>back/hours/validationModification">
                    <tr>
                        <td><?= $hour['id'] ?></td>
                        <td>
                            <?= $hour['day_of_week'] ?>
                            <!-- input is hidden because we cannot change a day of the week -->
                            <input type="hidden" name="day_of_week" class="form-control" value="<?= $hour['day_of_week'] ?>" />
                        </td>

                        <td><input type="text" name="lunch_opening_time" class="form-control" value="<?= $hour['lunch_opening_time'] ?>" /></td>
                        <td><input type="text" name="lunch_closing_time" class="form-control" value="<?= $hour['lunch_closing_time'] ?>" /></td>
                        <td><input type="text" name="dinner_opening_time" class="form-control" value="<?= $hour['dinner_opening_time'] ?>" /></td>
                        <td><input type="text" name="dinner_closing_time" class="form-control" value="<?= $hour['dinner_closing_time'] ?>" /></td>

                        <td colspan="2">
                            <input type="hidden" name="id" value="<?= $hour['id'] ?>" />
                            <button class="btn btn-primary" type="submit">Valider</button>
                        </td>
                    </tr>
                </form>
            <?php else : ?>
                <tr>
                    <td><?= $hour['id'] ?></td>
                    <td><?= $hour['day_of_week'] ?></td>
                    <td><?= $hour['lunch_opening_time'] ?></td>
                    <td><?= $hour['lunch_closing_time'] ?></td>
                    <td><?= $hour['dinner_opening_time'] ?></td>
                    <td><?= $hour['dinner_closing_time'] ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="id" value="<?= $hour['id'] ?>" />
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
$title = "Administration des réservations";
require "views/commons/template.php";
?>