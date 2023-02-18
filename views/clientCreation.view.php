<?php ob_start(); ?>

<form method="post" action="<?= URL ?>back/clients/creationValidation">
    <div class="mb-3">
        <label for="username" class="form-label">Nom</label>
        <input type="text" class="form-control" id="username" name="username">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email"></input>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password"></input>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php
$content = ob_get_clean();
$title = "Créer un clients";
require "views/commons/template.php";

