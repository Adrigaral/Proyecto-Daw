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
        <?php if ($data['ultimo_evento_activo']): ?>
            <section class="last-event d-flex flex-column align-items-start justify-content-center" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
              url('../img/uploads/<?= htmlspecialchars($data['ultimo_evento_activo']->getFoto_evento()) ?>') center/cover no-repeat; height: 500px; padding: 2rem; border-radius: 0.5rem;">
                <h2 class="text-white mb-3">¡Último evento publicado!</h2>
                <p class="text-white mb-3 descrip"><?= htmlspecialchars($data['ultimo_evento_activo']->getTitulo()) ?></p>
                <ul class="list-unstyled d-flex gap-4 mb-3">
                    <li class="list-group-item d-flex align-items-center gap-2 mb-2 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#eb3223" class="bi bi-calendar2-week-fill" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5m9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5M8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                        </svg>
                        <?php
                        $fecha_inicio = $data['ultimo_evento_activo']->getFecha_inicio_evento();
                        $fecha_fin = $data['ultimo_evento_activo']->getFecha_fin_evento();
                        $formato = 'd-m-Y';

                        if ($fecha_inicio->format($formato) === $fecha_fin->format($formato)) {
                            echo htmlspecialchars($fecha_inicio->format($formato));
                        } else {
                            echo htmlspecialchars($fecha_inicio->format($formato)) . ' hasta el ' . htmlspecialchars($fecha_fin->format($formato));
                        }
                        ?>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-2 mb-2 text-white"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#eb3223" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                        </svg><?= htmlspecialchars($data['ultimo_evento_activo']->getLugar()) ?>
                    </li>
                </ul>
                <a href="?controller=EventoController&action=ver_evento&id=<?= $data['ultimo_evento_activo']->getId_evento() ?>" class="border border-light px-3 py-1 rounded-1 btn-inset">
                    Ver detalles
                </a>
            </section>
        <?php endif; ?>

        <article class="d-flex eventos-art flex-column justify-content-center align-items-center pb-4">
            <div class="container filter my-4">
                <div class="d-flex align-items-center justify-content-center flex-wrap gap-3">
                    <h2 class="eventos mb-0">Eventos Activos</h2>
                    <form method="get" action="index.php" class="d-flex align-items-center gap-2">
                        <input type="hidden" name="controller" value="EventoController">
                        <input type="hidden" name="action" value="lista_eventos_activos">
                        <input type="text" name="lugar" class="form-control form-control-sm" placeholder="Lugar del evento" value="<?= htmlspecialchars($data['lugar'] ?? '') ?>" style="max-width: 200px;">
                        <select name="modelo" class="form-select form-select-sm" style="max-width: 200px;">
                            <option value="">Todos los modelos</option>
                            <?php foreach ($data['modelos'] as $m): ?>
                                <option value="<?= htmlspecialchars($m) ?>" <?= (isset($data['modelo']) && $data['modelo'] == $m) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($m) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-outline-danger text-white btn-sm d-flex align-items-center">Buscar</button>
                    </form>
                </div>
            </div>
            <section class="container my-4">
                <section class="row justify-content-center">
                    <?php if (!empty($data['eventos'])): ?>
                        <?php foreach ($data['eventos'] as $e):
                            $evento = $e['evento'];
                            $inscrito = $e['inscrito'];
                        ?>
                            <article class="col-12 col-md-6 col-lg-4 mb-4">
                                <section class="card shadow-sm h-100">
                                    <figure class="card-img-container m-0">
                                        <img src="../img/uploads/<?php echo $evento->getFoto_evento(); ?>" class="card-img-top img-fluid" alt="Imagen evento">
                                    </figure>
                                    <section class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($evento->getTitulo()) ?></h5>
                                        <ul class="list-unstyled mb-3">
                                            <li class="list-group-item d-flex align-items-center gap-2 mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#eb3223" class="bi bi-calendar2-week-fill" viewBox="0 0 16 16">
                                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5m9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5M8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                                                </svg>
                                                <?php
                                                $fecha_inicio = $evento->getFecha_inicio_evento();
                                                $fecha_fin = $evento->getFecha_fin_evento();
                                                $formato = 'd-m-Y';
                                                if ($fecha_inicio->format($formato) === $fecha_fin->format($formato)) {
                                                    echo htmlspecialchars($fecha_inicio->format($formato));
                                                } else {
                                                    echo htmlspecialchars($fecha_inicio->format($formato)) . ' hasta el ' . htmlspecialchars($fecha_fin->format($formato));
                                                }
                                                ?>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center gap-2 mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#eb3223" class="bi bi-clock" viewBox="0 0 16 16">
                                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                                                </svg>
                                                <?= htmlspecialchars($evento->getFecha_inicio_evento()->format('H:i')) ?> - <?= htmlspecialchars($evento->getFecha_fin_evento()->format('H:i')) ?>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center gap-2 mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#eb3223" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                                </svg>
                                                <?= htmlspecialchars($evento->getLugar()) ?>
                                            </li>
                                        </ul>

                                        <section class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <p class="gasto mb-0 d-flex align-items-center">Coste: <?= $evento->getPrecio() == 0.00 ? 'Gratuito' : htmlspecialchars($evento->getPrecio()) . ' &euro;'; ?></p>
                                            <form action="index.php" method="GET">
                                                <input type="hidden" name="controller" value="EventoController">
                                                <input type="hidden" name="action" value="ver_evento">
                                                <input type="hidden" name="id" value="<?= $evento->getId_evento() ?>">
                                                <input type="hidden" name="latitud" id="latitud" value="<?= $evento->getLatitud() ?>">
                                                <input type="hidden" name="longitud" id="longitud" value="<?= $evento->getLongitud() ?>">
                                                <button type="submit" class="btn btn-outline-danger text-white">Ver detalles</button>
                                            </form>
                                        </section>
                                    </section>
                                </section>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center">No hay más eventos disponibles.</p>
                    <?php endif; ?>
                </section>

                <!-- Paginación -->
                <?php if (!empty($data['total_paginas']) && $data['total_paginas'] > 1): ?>
                    <nav aria-label="Navegación de páginas">
                        <ul class="pagination justify-content-center mt-4">
                            <?php for ($i = 1; $i <= $data['total_paginas']; $i++): ?>
                                <li class="page-item <?= $i == $data['pagina_actual'] ? 'active' : '' ?>">
                                    <a class="page-link" href="index.php?controller=EventoController&action=lista_eventos_activos&pagina=<?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </section>

        </article>
    </main>

    <?php include_once("footer.html"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>