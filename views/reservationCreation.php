<?php ob_start(); ?>

<form method="post" action="<?= URL ?>back/reservations/creationValidation" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="client_id" class="form-label">ID Client</label>
        <input type="number" class="form-control" id="client_id" name="client_id">
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">date</label>
        <input type="date" class="form-control-file" id="date" name="date"></input>
    </div>
    <div class="mb-3">
        <label for="time" class="form-label">Ajouter une horraire</label>
        <input type="time" class="form-control-file" id="time" name="time"></input>
    </div>
    <div class="mb-3">
        <label for="number_of_people" class="form-label">Nombre de personne</label>
        <input type="number" class="form-control" id="number_of_people" name="number_of_people">
    </div>
    <div class="mb-3">
        <label for="comment" class="form-label">Ajouter un commentaire</label>
        <textarea class="form-control" id="comment" name="comment"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php
$content = ob_get_clean();
$title = "Ajouter une réservation";
require "views/commons/template.php";
