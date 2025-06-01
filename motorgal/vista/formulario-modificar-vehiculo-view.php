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
                        <a class="nav-link text-black" href="inicio.php">Perfil</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-black" href="?controller=VehiculoController&action=listarVehiculos">Mis Coches</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="?controller=EventoController&action=lista_eventos_activos">Mis eventos</a>
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
    <!-- Formulario Alta Vehículo -->
    <main class="flex-fill">
        <h2 class="section-title mb-4">¡Añadir Vehículo!</h2>
        <article class="d-flex flex-column justify-content-center align-items-center pb-4">
            <?php $vehiculo = $data['vehiculo']; ?>
            <form class="border p-4 rounded shadow-sm" action="?controller=VehiculoController&action=actualizarVehiculo" method="post">
                <input type="hidden" name="id_vehiculo" value="<?= htmlspecialchars($vehiculo->getId_vehiculo()) ?>">
                <div class="mb-3">
                    <label for="matricula" class="form-label text-white">Matrícula</label>
                    <input type="text" class="form-control" id="matricula" name="matricula" value="<?= htmlspecialchars($vehiculo->getMatricula()) ?>" required pattern="[0-9]{4}[A-Z]{3}" placeholder="1234ABC">
                </div>

                <div class="mb-3">
                    <label for="marca" class="form-label text-white">Marca:</label>
                    <select name="marca" class="form-select form-select-sm">
                        <?php foreach ($data['marcas'] as $m): ?>
                            <option value="<?= htmlspecialchars($m) ?>" <?= ($vehiculo->getMarca() == $m) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="modelo" class="form-label text-white">Modelo</label>
                    <input type="text" class="form-control" id="modelo" name="modelo" value="<?= htmlspecialchars($vehiculo->getModelo()) ?>" required maxlength="30" placeholder="TDI">
                </div>

                <div class="mb-3">
                    <label for="anio" class="form-label text-white">Año</label>
                    <input type="number" class="form-control" id="anio" name="anio" value="<?= htmlspecialchars($vehiculo->getAnio()) ?>" required min="1900" max="<?= date('Y') ?>" placeholder="2018">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-dark">Insertar</button>
                    <a href="?controller=VehiculoController&action=listarVehiculos" class="btn btn-dark btn-inset">Cancelar</a>
                </div>
            </form>
            <?php
            if (!empty($data['errores'])): ?>
                <div class="alert alert-danger w-100 mt-4" style="max-width: 500px;">
                    <?= $data['errores'] ?>
                </div>
            <?php endif; ?>

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