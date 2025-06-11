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
    <?php include_once("header.php"); ?>
    <main class="flex-fill">
        <h1 class="mb-4 mt-4 text-center event-ins">Lista de vehículos que posees</h1>

        <article class="container bg-light shadow-sm p-4 rounded-3">
            <?php if (!empty($data['vehiculos'])): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Matrícula</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Año</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['vehiculos'] as $vehiculo): ?>
                                <tr>
                                    <td><?= htmlspecialchars($vehiculo->getMatricula()) ?></td>
                                    <td><?= htmlspecialchars($vehiculo->getMarca()) ?></td>
                                    <td><?= htmlspecialchars($vehiculo->getModelo()) ?></td>
                                    <td><?= htmlspecialchars($vehiculo->getAnio()) ?></td>
                                    <td class="text-center">
                                        <a href="?controller=VehiculoController&action=editarVehiculo&id=<?= $vehiculo->getId_vehiculo() ?>" class="btn btn-sm btn-outline-dark me-2" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                            </svg>
                                        </a>
                                        <a href="?controller=VehiculoController&action=eliminarVehiculo&id=<?= $vehiculo->getId_vehiculo() ?>" class="btn btn-sm btn-outline-dark" title="Eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-muted fs-5">No tienes vehículos registrados.</p>
            <?php endif; ?>

            <!-- Botón "Añadir nuevo vehículo" si hay menos de 3 -->
            <div class="text-center mt-4">
                <?php if (count($data['vehiculos']) < 3): ?>
                    <a href="?controller=VehiculoController&action=insertarVehiculo" class="btn btn-outline-danger text-white">
                        Añadir nuevo vehículo
                    </a>
                <?php else: ?>
                    <p class="text-danger fw-bold">Has alcanzado el límite de 3 vehículos registrados.</p>
                <?php endif; ?>
            </div>

            <?php if (!empty($data['errores'])): ?>
                <div class="alert alert-danger mt-3">
                    <?= $data['errores'] ?>
                </div>
            <?php endif; ?>
        </article>

    </main>

    <?php include_once("footer.html"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>