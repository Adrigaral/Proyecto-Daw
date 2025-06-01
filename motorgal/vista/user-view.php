<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header class="sticky-top bg-white py-3 px-4 border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <a href="?controller=EventoController&action=lista_eventos_activos" class="d-flex align-items-center me-4">
                <img src="../img/motorgal.png" alt="Logo de Motorgal" id="logo">
            </a>

            <!-- Menú principal -->
            <nav class="flex-grow-1">
                <ul class="nav justify-content-evenly">
                    <li class="nav-item">
                        <a class="nav-link text-black" href="?controller=EventoController&action=lista_eventos_activos">Eventos</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-black" href="?controller=VehiculoController&action=listarVehiculos">Mis Coches</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="calendario.php">Mis eventos</a>
                    </li>
                </ul>
            </nav>

            <!-- Botones de usuario -->
            <div class="d-flex align-items-center gap-4">
                <p class="mb-0 text-primary"><?= $_SESSION['loged'] ?></p>
                <a href="?controller=UsuarioController&action=logout" class="btn btn-dark">Salir</a>
            </div>
        </div>
    </header>
    <!-- Formulario Alta Usuario -->
    <main class="flex-fill">
        <h1 class="section-title mb-4">Te damos la bienvenid@ <?php echo $_SESSION['loged']; ?></h1>
        <article class="d-flex flex-column justify-content-center align-items-center pb-4">
            <a href="?controller=EventoController&action=lista_eventos_activos">
                <img src="../img/Porsche.jpg" alt="porsche">
            </a>
        </article>
    </main>

    <!-- Footer -->
    <footer class="pt-5 pb-4 px-4 d-flex justify-content-around align-items-center flex-wrap footer">

        <p class="footer-text">Motorgal</p>
        <p><a href="#" class="footer-link">Aviso Legal</a></p>
        <p><a href="#" class="footer-link">Política de Privacidad</a></p>
        <p><a href="#" class="footer-link">Cookies</a></p>
        <p class="footer-text">Adrián García, 2025</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>