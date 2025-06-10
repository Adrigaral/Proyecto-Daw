<!-- Header -->
<header class="sticky-top bg-white border-bottom">
    <nav class="navbar navbar-expand-lg navbar-light px-3 py-2">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center me-3" href="index.php?controller=EventoController&action=lista_eventos_activos">
            <img src="../img/motorgal.png" alt="Logo de Motorgal" id="logo" height="40">
        </a>

        <!-- Botón hamburguesa para móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido del navbar -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <!-- Menú principal -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-evenly">
                <li class="nav-item">
                    <a class="nav-link text-black" href="?controller=EventoController&action=lista_eventos_activos">Eventos Actuales</a>
                </li>
                <?php if ($_SESSION['tipo'] == "PREMIUM"): ?>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="?controller=EventoController&action=lista_eventos_creados">Mis Eventos</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link text-black" href="?controller=VehiculoController&action=listarVehiculos">Mis Coches</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" href="?controller=EventoController&action=listarEventosUsuario">Mis inscripciones</a>
                </li>
            </ul>

            <!-- Usuario y botón salir -->
            <div class="d-flex align-items-center gap-3 mt-2 mt-lg-0">
                <p class="mb-0 text-primary fw-semibold"><?= $_SESSION['loged'] ?></p>
                <a href="?controller=UsuarioController&action=logout" class="btn btn-sm btn-outline-danger text-white">Salir</a>
            </div>
        </div>
    </nav>
</header>