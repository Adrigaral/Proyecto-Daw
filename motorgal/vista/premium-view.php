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
    <header class="sticky-top bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
        <a href="../index.php">
            <img src="../img/motorgal.png" alt="Logo de Motorgal" id="logo">
        </a>
        <nav class="w-100 ps-4">
            <ul class="nav d-flex justify-content-end">
                <li class="nav-item"><button type="button" class="btn"><a class="nav-link" href="?controller=VehiculoController&action=listarVehiculos">Coches</a></button></li>
                <li class="nav-item"><button type="button" class="btn"><a class="nav-link" href="?controller=UsuarioController&action=logout">Salir</a></button></li>
            </ul>
        </nav>
    </header>
    <!-- Formulario Alta Usuario -->
    <main class="flex-fill">
        <h1 class="section-title mb-4">BIENVENID@ <?php echo $_SESSION['loged']; ?>, eres usuari@ <?php echo $_SESSION['tipo']; ?>, aquí tienes tu id de usuari@ <?php echo $_SESSION['id_usuario']; ?> ;D </h1>
        <article class="d-flex flex-column justify-content-center align-items-center pb-4">
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