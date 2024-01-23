<?php ob_start(); ?>
<p class="text-center">
   OOPS ! </br>
    La page demandée n'existe pas.
</p>

<?php
$content = ob_get_clean();
$title = "Erreur 404";
require "views/commons/template.php";
