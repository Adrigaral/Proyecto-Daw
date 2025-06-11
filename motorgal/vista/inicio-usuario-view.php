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
        <nav class="navbar navbar-light px-3 py-2">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center me-3" href="index.php">
                <img src="../img/motorgal.png" alt="Logo de Motorgal" id="logo" height="40">
            </a>

            <!-- Menú de navegación -->
            <div class="d-flex flex-column flex-sm-row gap-2 ms-auto" id="mainNavbar">
                <a class="btn btn-sm btn-outline-danger text-white px-3 py-2" href="?controller=UsuarioController&action=altaForm">
                    Regístrate ya
                </a>
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
                                    <button type="submit" class="btn btn-outline-danger text-white">Iniciar sesión</button>
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

    <?php include_once("footer.html"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>