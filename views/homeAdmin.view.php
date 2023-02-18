<?php ob_start(); ?>
<main class="container-fluid">
    <h2 class="mt-5 text-center">Sommaire de l'administration</h2>
    <h3 class="mt-5">La carte du restaurant :</h3>
    <a class="mt-3 text-decoration-none" href="<?= URL ?>back/products/visualisation">
        <button class="btn btn-warning">
            Modifier les plats
        </button>
    </a>
    <a class="mt-3 text-decoration-none" href="<?= URL ?>back/products/creation">
        <button class="btn btn-warning">
            Ajouter un plat
        </button>
    </a>
    <h3 class="mt-5">La gallerie :</h3>
    <a class="mt-3 text-decoration-none" href="<?= URL ?>back/gallerys/visualisation">
        <button class="btn btn-warning">
            Modifier la gallerie
        </button>
    </a>
    <a class="mt-3 text-decoration-none" href="<?= URL ?>back/gallerys/creation">
        <button class="btn btn-warning">
            Ajouter une photo
        </button>
    </a>
    <h3 class="mt-5">Les clients :</h3>
    <a class="mt-3 text-decoration-none" href="<?= URL ?>back/clients/visualisation">
        <button class="btn btn-warning">
            Modifier les clients
        </button>
    </a>
    <a class="mt-3 text-decoration-none" href="<?= URL ?>back/clients/creation">
        <button class="btn btn-warning">
            Ajouter un client
        </button>
    </a>



</main>

<?php
$content = ob_get_clean();
$title = "Page d'administration du site";
require "views/commons/template.php";
