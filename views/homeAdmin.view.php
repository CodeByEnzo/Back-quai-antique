<?php ob_start(); ?>
<main class="container-fluid mb-5 row d-flex justify-content-center align-items-center ">

    <!-- <div class="card bg-dark shadow m-3 text-center col-12 col-sm-5 p-2">
        <h3 class="mt-4 text-light">Gaby Diagnostic</h3>
        <a class="mt-2 text-decoration-none" href="<?= URL ?>back/diag/visualisation">
            <button class="btn btn-warning">
                Modifier le diagnostic
            </button>
        </a>
        <a class="mt-2 text-decoration-none" href="<?= URL ?>back/diag/creation">
            <button class="btn btn-warning">
                Ajouter une Question
            </button>
        </a>
    </div> -->

    <div class="card bg-dark shadow m-3 text-center col-12 col-sm-5 p-2">
        <h3 class="mt-4 text-light">La carte</h3>
        <a class="mt-2 text-decoration-none" href="<?= URL ?>back/products/visualisation">
            <button class="btn btn-warning">
                Modifier les plats
            </button>
        </a>
        <a class="mt-2 text-decoration-none" href="<?= URL ?>back/products/creation">
            <button class="btn btn-warning">
                Ajouter un plat
            </button>
        </a>
    </div>


    <div class="card bg-dark shadow m-3 text-center col-12 col-sm-5 p-2">
        <h3 class="mt-4 text-light">La gallerie</h3>
        <a class="mt-2 text-decoration-none" href="<?= URL ?>back/gallerys/visualisation">
            <button class="btn btn-warning">
                Modifier la gallerie
            </button>
        </a>
        <a class="mt-2 text-decoration-none" href="<?= URL ?>back/gallerys/creation">
            <button class="btn btn-warning">
                Ajouter une photo
            </button>
        </a>
    </div>


    <div class="card bg-dark shadow m-3 text-center col-12 col-sm-5 p-2">
        <h3 class="mt-4 text-light">Les clients</h3>
        <a class="mt-2 text-decoration-none" href="<?= URL ?>back/clients/visualisation">
            <button class="btn btn-warning">
                Modifier les clients
            </button>
        </a>
        <a class="mt-2 text-decoration-none" href="<?= URL ?>back/clients/creation">
            <button class="btn btn-warning">
                Ajouter un client
            </button>
        </a>
    </div>


    <div class="card bg-dark shadow m-3 text-center col-12 col-sm-5 p-2">
        <h3 class="mt-4 text-light">Les réservations</h3>
        <a class="mt-2 text-decoration-none" href="<?= URL ?>back/reservations/visualisation">
            <button class="btn btn-warning">
                Modifier les réservations
            </button>
        </a>
        <a class="mt-2 text-decoration-none" href="<?= URL ?>back/reservations/creation">
            <button class="btn btn-warning">
                Ajouter une réservation
            </button>
        </a>
    </div>


    <div class="card bg-dark shadow m-3 text-center col-12 col-sm-5 p-2">
        <h3 class="mt-4 text-light">Les horraires d'ouverture</h3>
        <a class="mt-2 text-decoration-none" href="<?= URL ?>back/hours/visualisation">
            <button class="btn btn-warning">
                Modifier les horraires
            </button>
        </a>
    </div>
    <div class="card bg-dark shadow m-3 text-center col-12 col-sm-5 p-2">
        <h3 class="mt-4 text-light">Les Coordonnées</h3>
        <a class="mt-2 text-decoration-none" href="<?= URL ?>back/companyInfo/visualisation">
            <button class="btn btn-warning">
                Modifier les coordonnées de l'entreprise
            </button>
        </a>
    </div>


</main>

<?php
$content = ob_get_clean();
$title = "Tableau de bord";
require "views/commons/template.php";
