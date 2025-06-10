<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="../estilos/style.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="../js/ocultar-texto.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include_once("header.php"); ?>
    <main class="flex-fill">
        <article class="container my-5">
            <div class="card shadow-lg border-0 p-4 event-card">
                <?php $evento = $data['evento']; ?>
                <div class="card-header text-white text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5))
                ,url('../img/uploads/<?= $evento->getFoto_evento() ?>') center/cover no-repeat;
                height: 500px;
                position: relative;
                border-radius: 0.5rem;
            ">
                    <h1 class="card-title"><?= htmlspecialchars($evento->getTitulo()) ?></h1>
                </div>

                <div class="card-body">
                    <p><strong>Descripción:</strong> <?= htmlspecialchars($evento->getDescripcion()) ?></p>

                    <p>
                        <strong>Fecha:</strong>
                        <?php
                        $fecha_inicio = $evento->getFecha_inicio_evento()->format('d-m-Y');
                        $fecha_fin = $evento->getFecha_fin_evento()->format('d-m-Y');
                        echo ($fecha_inicio === $fecha_fin) ? $fecha_inicio : "$fecha_inicio hasta el $fecha_fin";
                        ?>
                    </p>

                    <p>
                        <strong>Hora:</strong>
                        <?= htmlspecialchars($evento->getFecha_inicio_evento()->format('H:i')) ?> - <?= htmlspecialchars($evento->getFecha_fin_evento()->format('H:i')) ?>
                    </p>

                    <p><strong>Lugar:</strong> <?= htmlspecialchars($evento->getLugar()) ?></p>

                    <p><strong>Estado:</strong>
                        <span class="badge bg-<?= $evento->getEstado_evento() === 'ACTIVO' ? 'success' : 'danger' ?>">
                            <?= htmlspecialchars($evento->getEstado_evento()) ?>
                        </span>
                    </p>

                    <p><strong>Límite de plazas:</strong> <?= htmlspecialchars($evento->getLimite_plazas()) ?></p>

                    <p><strong>Requisitos:</strong> <?= htmlspecialchars($evento->getRequisitos()) ?></p>

                    <p><strong>Precio:</strong>
                        <?= $evento->getPrecio() == 0.00 ? '<span class="text-success">Gratuito</span>' : '<span class="text-danger">' . htmlspecialchars($evento->getPrecio()) . ' €</span>'; ?>
                    </p>
                    <div id="map" style="height: 400px;"></div>
                    <input type="hidden" name="latitud" id="latitud" value="<?= htmlspecialchars($evento->getLatitud()) ?>">
                    <input type="hidden" name="longitud" id="longitud" value="<?= htmlspecialchars($evento->getLongitud()) ?>">

                    <?php if (!empty($data['creador']) && isset($_SESSION['id_usuario']) && $data['creador'] == $_SESSION['id_usuario']): ?>
                        <?php $inscritos = $data['inscritos'] ?? []; ?>
                        <?php if ($evento->getEstado_evento() === 'ACTIVO' || $evento->getEstado_evento() === 'EN PROGRESO'): ?>
                            <div class="container filter my-4">
                                <div class="d-flex align-items-center justify-content-center flex-wrap gap-3">
                                    <form method="get" action="index.php" class="d-flex align-items-center gap-2">
                                        <input type="hidden" name="controller" value="EventoController">
                                        <input type="hidden" name="action" value="ver_evento">
                                        <input type="hidden" name="id" value="<?= $evento->getId_evento() ?>">
                                        <input type="text" name="matricula" class="form-control form-control-sm" placeholder="Buscar por matrícula" value="<?= htmlspecialchars($data['matricula'] ?? '') ?>">
                                        <button type="submit" class="buscar btn btn-outline-danger btn-sm d-flex align-items-center">Buscar</button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($inscritos)): ?>
                            <h3 class="text-primary fw-bold my-4">Hay <?= $data['totalInscritos'] ?> inscrito<?= $data['totalInscritos'] !== 1 ? 's' : '' ?> en total.</h3>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>DNI</th>
                                            <th>Nombre</th>
                                            <th>Marca</th>
                                            <th>Matrículas</th>
                                            <th>Modelos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($inscritos as $i): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($i['dni']) ?></td>
                                                <td><?= htmlspecialchars($i['nombre']) ?></td>
                                                <td><?= htmlspecialchars($i['marca']) ?></td>
                                                <td><?= htmlspecialchars($i['matriculas']) ?></td>
                                                <td><?= htmlspecialchars($i['modelos']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <?php if (!empty($data['matricula'])): ?>
                                <div class="alert alert-warning mt-3 alert-dismissible fade show text-center">
                                    No se encontró ninguna coincidencia para la matrícula "<strong><?= htmlspecialchars($data['matricula']) ?></strong>".
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info mt-3 alert-dismissible fade show text-center">No hay ningún usuario inscrito en este evento.</div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <!-- Paginación -->
                        <?php if (!empty($data['total_paginas']) && $data['total_paginas'] > 1): ?>
                            <nav aria-label="Navegación de páginas">
                                <ul class="pagination justify-content-center mt-4">
                                    <?php for ($i = 1; $i <= $data['total_paginas']; $i++): ?>
                                        <li class="page-item <?= $i == $data['pagina_actual'] ? 'active' : '' ?>">
                                            <a class="page-link" href="index.php?controller=EventoController&action=ver_evento&id=<?= $data['evento']->getId_evento() ?>&pagina=<?= $i ?>&matricula=<?= urlencode($data['matricula'] ?? '') ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                        <div class="text-center mt-4">
                            <a href="index.php?controller=EventoController&action=lista_eventos_creados" class="btn btn-outline-danger text-white">
                                Volver a mis eventos
                            </a>
                        </div>
                    <?php else: ?>
                        <?php if ($evento->getEstado_evento() === 'ACTIVO'): ?>
                            <div class="d-flex justify-content-center my-3">
                                <?php if (!empty($data['inscrito'])): ?>
                                    <form action="index.php?controller=InscribeController&action=quitarInscripcion" method="POST">
                                        <input type="hidden" name="id_evento" value="<?= htmlspecialchars($data['evento']->getId_evento()) ?>">
                                        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($_SESSION['id_usuario'] ?? '') ?>">
                                        <button type="submit" class="btn btn-outline-danger text-white">Quitar Inscripción</button>
                                    </form>
                                <?php else: ?>
                                    <form action="index.php?controller=InscribeController&action=inscribirse" method="POST">
                                        <input type="hidden" name="id_evento" value="<?= htmlspecialchars($data['evento']->getId_evento()) ?>">
                                        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($_SESSION['id_usuario'] ?? '') ?>">
                                        <button type="submit" class="btn btn-outline-danger text-white">Inscribirse</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-danger text-center fw-bold">La inscripción ha terminado.</p>
                        <?php endif; ?>
                        <div class="text-center mt-4">
                            <a href="index.php?controller=EventoController&action=listarEventosUsuario" class="btn btn-outline-danger text-white">
                                Ir a inscripciones
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['mensaje'])): ?>
                        <p class="alert alert-success mt-3 alert-dismissible fade show text-center" role="alert" id="alert-success">
                            <?= htmlspecialchars($_SESSION['mensaje']) ?>
                        </p>
                        <?php unset($_SESSION['mensaje']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <p class="alert alert-danger mt-3 alert-dismissible fade show text-center" role="alert" id="alert-error">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                        </p>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <div class="text-center mt-4">
                        <a href="index.php?controller=EventoController&action=lista_eventos_activos" class="btn btn-outline-danger text-white">
                            Ir a la lista de eventos
                        </a>
                    </div>
                </div>
            </div>
        </article>
    </main>

    <?php include_once("footer.php"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/mapa-vista.js"></script>
</body>

</html>