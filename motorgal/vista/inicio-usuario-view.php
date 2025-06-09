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
    <header class="sticky-top bg-white border-bottom">
        <nav class="navbar navbar-expand-lg navbar-light px-3 py-2">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center me-3" href="index.php">
                <img src="../img/motorgal.png" alt="Logo de Motorgal" id="logo" height="40">
            </a>

            <!-- Botón hamburguesa para móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú de navegación -->
            <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn py-2 px-3" href="?controller=UsuarioController&action=altaForm">
                            Registrarse
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Formulario Alta Usuario -->
    <main class="flex-fill">
        <section class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h2 class="text-center mb-4">Inicia sesión</h2>
                            <form action="?controller=UsuarioController&action=login" method="post">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Nombre de usuario</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Introduce tu nombre de usuario" required>
                                </div>
                                <div class="mb-3">
                                    <label for="contrasinal" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="contrasinal" name="contrasinal" placeholder="Introduce tu contraseña" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn text-white">Iniciar sesión</button>
                                </div>
                            </form>

                            <?php if (isset($data['errores'])): ?>
                                <div class="alert alert-danger mt-4" role="alert">
                                    <?= htmlspecialchars($data['errores']) ?>
                                </div>
                            <?php endif; ?>

                            <div class="text-center mt-3">
                                <small class="text-muted">¿No tienes cuenta? <a href="?controller=UsuarioController&action=altaForm" class="text-decoration-none">Regístrate aquí</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="bg-light pt-4 pb-3 border-top">
        <div class="container">
            <div class="row text-center text-md-start align-items-center gy-2">
                <div class="col-12 col-md">
                    <p class="mb-0 fw-bold">Motorgal</p>
                </div>
                <div class="col-12 col-md-auto">
                    <a href="#" class="text-decoration-none text-muted me-3">Aviso Legal</a>
                    <a href="#" class="text-decoration-none text-muted me-3">Política de Privacidad</a>
                    <a href="#" class="text-decoration-none text-muted">Cookies</a>
                </div>
                <div class="col-12 col-md text-md-end">
                    <p class="mb-0 text-muted">Adrián García, 2025</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>