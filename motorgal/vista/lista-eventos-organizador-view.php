<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/style.css">
    <script src="../js/ocultar-texto.js"></script>
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
                        <a class="nav-link text-black" href="?controller=EventoController&action=lista_eventos_creados">Mis Eventos</a>
                    </li>
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
            <h1 class="mb-4 mt-4 text-center event-ins">Eventos propios</h1>
            <div class="container filter my-4">
                <div class="d-flex align-items-center justify-content-center flex-wrap gap-3">
                    <h2 class="eventos-filter mb-0">Filtrar eventos</h2>
                    <form method="get" action="index.php" class="d-flex align-items-center gap-2">
                        <input type="hidden" name="controller" value="EventoController">
                        <input type="hidden" name="action" value="lista_eventos_creados">

                        <input type="text" name="lugar" class="form-control form-control-sm" placeholder="Lugar del evento" value="<?= htmlspecialchars($data['lugar'] ?? '') ?>" style="max-width: 200px;">

                        <select name="estado" class="form-select form-select-sm" style="max-width: 200px;">
                            <option value="" <?= (!isset($data['estado']) || $data['estado'] === '') ? 'selected' : '' ?>>Todos los estados</option>
                            <option value="ACTIVO" <?= (isset($data['estado']) && $data['estado'] == 'ACTIVO') ? 'selected' : '' ?>>Activo</option>
                            <option value="EN PROGRESO" <?= (isset($data['estado']) && $data['estado'] == 'EN PROGRESO') ? 'selected' : '' ?>>En progreso</option>
                            <option value="FINALIZADO" <?= (isset($data['estado']) && $data['estado'] == 'FINALIZADO') ? 'selected' : '' ?>>Finalizado</option>
                            <option value="CANCELADO" <?= (isset($data['estado']) && $data['estado'] == 'CANCELADO') ? 'selected' : '' ?>>Cancelado</option>
                        </select>

                        <select name="requisitos" class="form-select form-select-sm" style="max-width: 200px;">
                            <option value="">Todas las marcas</option>
                            <?php foreach ($data['requisitos'] as $r): ?>
                                <option value="<?= htmlspecialchars($r) ?>" <?= (isset($data['requisito']) && $data['requisito'] == $r) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit" class="text-white btn btn-outline-danger btn-sm d-flex align-items-center">Buscar</button>
                        <a class="btn text-white btn-outline-danger btn-sm" href="?controller=EventoController&action=crear_evento">Crear</a>
                    </form>
                </div>
            </div>
            <?php if (!empty($_SESSION['errores'])): ?>
                <div class="alert alert-danger mt-3 alert-dismissible fade show text-center" role="alert" id="alert-error">
                    <?= htmlspecialchars($_SESSION['errores']) ?>
                </div>
                <?php unset($_SESSION['errores']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['mensaje'])): ?>
                <div class="alert alert-success mt-3 alert-dismissible fade show text-center" role="alert" id="alert-success">
                    <?= htmlspecialchars($_SESSION['mensaje']) ?>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php endif; ?>
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
                                        <p><strong>Estado:</strong>
                                            <span class="badge bg-<?= $evento['estado_evento'] === 'ACTIVO' ? 'success' : 'danger' ?>">
                                                <?= htmlspecialchars($evento['estado_evento']) ?>
                                            </span>
                                        </p>
                                        <p><strong>Requisitos:</strong> <?= htmlspecialchars($evento['requisitos']) ?></p>
                                        <p><strong>Lugar:</strong> <?= htmlspecialchars($evento['lugar']) ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <form action="index.php" method="GET" class="m-0">
                                                <input type="hidden" name="controller" value="EventoController">
                                                <input type="hidden" name="action" value="ver_evento">
                                                <input type="hidden" name="id" value="<?= $evento['id_evento'] ?>">
                                                <button type="submit" class="btn btn-dark">Ver detalles</button>
                                            </form>
                                            <div class="d-flex gap-3">
                                                <a href="?controller=EventoController&action=modificar_evento&id=<?= $evento['id_evento'] ?>" class="text-primary link-action" title="Editar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                                    </svg>
                                                </a>
                                                <a href="?controller=EventoController&action=eliminar_evento&id=<?= $evento['id_evento'] ?>" class="text-warning link-action" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este evento?');">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
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
                                <a class="page-link" href="index.php?controller=EventoController&action=lista_eventos_creados&pagina=<?= $i ?>&lugar=<?= urlencode($data['lugar'] ?? '') ?>&estado=<?= urlencode($data['estado'] ?? '') ?>&requisitos=<?= urlencode($data['requisito'] ?? '') ?>">
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