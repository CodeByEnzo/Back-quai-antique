<nav class="navbar navbar-expand-lg navbar bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
        </a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav text-center me-auto">
                <?php if (!security::verifAccessSession()) : ?>
                    <li class="nav-item">
                        <a class="nav-link active me-0" aria-current="page" href="<?= URL ?>back/login">Login</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL ?>back/admin">Accueil</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Carte
                        </a>
                        <ul class="dropdown-menu text-center">
                            <li><a class="dropdown-item" href="<?= URL ?>back/products/visualisation">Modifier</a></li>
                            <li><a class="dropdown-item" href="<?= URL ?>back/products/creation">Ajouter</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Gallerie
                        </a>
                        <ul class="dropdown-menu text-center">
                            <li><a class="dropdown-item" href="<?= URL ?>back/gallerys/visualisation">Modifier</a></li>
                            <li><a class="dropdown-item" href="<?= URL ?>back/gallerys/creation">Ajouter</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Clients
                        </a>
                        <ul class="dropdown-menu text-center">
                            <li><a class="dropdown-item" href="<?= URL ?>back/clients/visualisation">Modifier</a></li>
                            <li><a class="dropdown-item" href="<?= URL ?>back/clients/creation">Ajouter</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Réservations
                        </a>
                        <ul class="dropdown-menu text-center">
                            <li><a class="dropdown-item" href="<?= URL ?>back/reservations/visualisation">Modifier</a></li>
                            <li><a class="dropdown-item" href="<?= URL ?>back/reservations/creation">Ajouter</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Horraire
                        </a>
                        <ul class="dropdown-menu text-center">
                            <li><a class="dropdown-item" href="<?= URL ?>back/hours/visualisation">Modifier</a></li>
                        </ul>
                    </li>
            </ul>
            <span class="nav-item text-light text-center me-5">
                <a class="nav-link" href="<?= URL ?>back/logout">Log out</a>
            </span>


        <?php endif; ?>
        </div>
    </div>
</nav>