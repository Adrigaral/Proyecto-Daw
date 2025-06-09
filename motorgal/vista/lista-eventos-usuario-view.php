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
            <a href="index.php?user" class="d-flex align-items-center me-4">
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
                        <a class="nav-link text-black" href="?controller=EventoController&action=listarEventosUsuario">Inscripciones</a>
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
        <article class="container my-5 bg-light border rounded">
            <h1 class="mb-4 mt-4 text-center event-ins">Eventos inscritos</h1>
            <div class="container my-4">
                <div class="bg-light">
                    <h2 class="eventos-filter text-center mb-3">Filtrar eventos</h2>
                    <form method="get" action="index.php">
                        <input type="hidden" name="controller" value="EventoController">
                        <input type="hidden" name="action" value="listarEventosUsuario">
                        <div class="row gy-2">
                            <div class="col-12 col-md-4">
                                <input type="text" name="lugar" class="form-control form-control-sm" placeholder="Lugar del evento" value="<?= htmlspecialchars($data['lugar'] ?? '') ?>">
                            </div>
                            <div class="col-12 col-md-4">
                                <select name="estado" class="form-select form-select-sm">
                                    <option value="" <?= (!isset($data['estado']) || $data['estado'] === '') ? 'selected' : '' ?>>Todos los estados</option>
                                    <option value="ACTIVO" <?= (isset($data['estado']) && $data['estado'] == 'ACTIVO') ? 'selected' : '' ?>>Activo</option>
                                    <option value="EN PROGRESO" <?= (isset($data['estado']) && $data['estado'] == 'EN PROGRESO') ? 'selected' : '' ?>>En progreso</option>
                                    <option value="FINALIZADO" <?= (isset($data['estado']) && $data['estado'] == 'FINALIZADO') ? 'selected' : '' ?>>Finalizado</option>
                                    <option value="CANCELADO" <?= (isset($data['estado']) && $data['estado'] == 'CANCELADO') ? 'selected' : '' ?>>Cancelado</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <select name="requisitos" class="form-select form-select-sm">
                                    <option value="">Todas las marcas</option>
                                    <?php foreach ($data['requisitos'] as $r): ?>
                                        <option value="<?= htmlspecialchars($r) ?>" <?= (isset($data['requisito']) && $data['requisito'] == $r) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($r) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12 d-flex justify-content-center gap-2 flex-wrap mt-3">
                                <button type="submit" class="btn btn-sm text-white">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <section class="container my-4">
                <?php if (!empty($data['eventos'])): ?>
                    <div class="row justify-content-center">
                        <?php foreach ($data['eventos'] as $evento): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <?php if (!empty($evento['foto_evento'])): ?>
                                        <img src="../img/uploads/<?= htmlspecialchars($evento['foto_evento']) ?>" class="card-img-top" alt="Imagen del evento">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($evento['titulo']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($evento['descripcion']) ?></p>
                                        <p><strong>Estado:</strong>
                                            <?php
                                            $estado = $evento['estado_evento'];
                                            $badgeClass = match ($estado) {
                                                'ACTIVO' => 'success',
                                                'EN PROGRESO' => 'primary',
                                                'FINALIZADO' => 'secondary',
                                                'CANCELADO' => 'danger',
                                                default => 'dark',
                                            };
                                            ?>
                                            <span class="badge bg-<?= $badgeClass ?>">
                                                <?= htmlspecialchars($estado) ?>
                                            </span>
                                        </p>
                                        <p><strong>Requisitos:</strong> <?= htmlspecialchars($evento['requisitos']) ?></p>
                                        <p><strong>Lugar:</strong> <?= htmlspecialchars($evento['lugar']) ?></p>
                                        <p><strong>Precio:</strong> <?= $evento['precio'] == 0.00 ? '<span class="text-success">Gratuito</span>' : '<span class="text-danger">' . htmlspecialchars($evento['precio']) . ' €</span>'; ?></p>
                                        <p><strong>Fecha Inscripción:</strong> <span class="text-success"><?= htmlspecialchars($evento['fecha_inscripcion']) ?></span></p>
                                        <form action="index.php" method="GET">
                                            <input type="hidden" name="controller" value="EventoController">
                                            <input type="hidden" name="action" value="ver_evento">
                                            <input type="hidden" name="id" value="<?= $evento['id_evento'] ?>">
                                            <button type="submit" class="btn text-white">Ver detalles</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="alert alert-info">Ningún evento encontrado.</p>
                <?php endif; ?>
            </section>
            <!-- Paginación -->
            <?php if (!empty($data['total_paginas']) && $data['total_paginas'] > 1): ?>
                <nav aria-label="Navegación de páginas">
                    <ul class="pagination justify-content-center mt-4">
                        <?php for ($i = 1; $i <= $data['total_paginas']; $i++): ?>
                            <li class="page-item <?= $i == $data['pagina_actual'] ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?controller=EventoController&action=listarEventosUsuario&pagina=<?= $i ?>&lugar=<?= urlencode($data['lugar'] ?? '') ?>&estado=<?= urlencode($data['estado'] ?? '') ?>&requisitos=<?= urlencode($data['requisito'] ?? '') ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
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