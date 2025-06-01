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
    <main class="flex-fill">
        <h1 class="section-title mb-4">Lista de vehículos que posees</h1>
        <article class="container d-flex flex-column justify-content-center align-items-center pb-4">
            <?php if (!empty($data['vehiculos'])): ?>
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Matrícula</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Año</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['vehiculos'] as $vehiculo): ?>
                            <tr>
                                <td><?= htmlspecialchars($vehiculo->getMatricula()) ?></td>
                                <td><?= htmlspecialchars($vehiculo->getMarca()) ?></td>
                                <td><?= htmlspecialchars($vehiculo->getModelo()) ?></td>
                                <td><?= htmlspecialchars($vehiculo->getAnio()) ?></td>
                                <td class="d-flex gap-4">
                                    <a href="?controller=VehiculoController&action=editarVehiculo&id=<?= $vehiculo->getId_vehiculo() ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                        </svg>
                                    </a>
                                    <a href="?controller=VehiculoController&action=eliminarVehiculo&id=<?= $vehiculo->getId_vehiculo() ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No tienes vehículos registrados.</p>
            <?php endif; ?>

            <!-- Botón "Añadir nuevo vehículo" si hay menos de 3 -->
            <?php if (count($data['vehiculos']) < 3): ?>
                <a href="?controller=VehiculoController&action=insertarVehiculo" class="btn btn-primary">Añadir nuevo vehículo</a>
            <?php else: ?>
                <p class="text-danger">Has alcanzado el límite de 3 vehículos registrados.</p>
            <?php endif; ?>

            <?php
            $errores = $data['errores'] ?? '';
            if (!empty($errores)): ?>
                <div class="alert alert-danger mt-3">
                    <?= $errores ?>
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