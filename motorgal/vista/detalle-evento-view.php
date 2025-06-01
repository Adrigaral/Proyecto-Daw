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

                    <p><strong>Lugar:</strong> <?= htmlspecialchars($evento->getLugar()) ?></p>

                    <p><strong>Estado:</strong>
                        <span class="badge bg-<?= $evento->getEstado_evento() === 'ACTIVO' ? 'success' : 'secondary' ?>">
                            <?= htmlspecialchars($evento->getEstado_evento()) ?>
                        </span>
                    </p>

                    <p><strong>Límite de plazas:</strong> <?= htmlspecialchars($evento->getLimite_plazas()) ?></p>

                    <p><strong>Requisitos:</strong> <?= htmlspecialchars($evento->getRequisitos()) ?></p>

                    <p><strong>Precio:</strong>
                        <?= $evento->getPrecio() == 0.00 ? '<span class="text-success">Gratuito</span>' : '<span class="text-danger">' . htmlspecialchars($evento->getPrecio()) . ' €</span>'; ?>
                    </p>

                    <?php if ($evento->getEstado_evento() === 'ACTIVO'): ?>
                        <div class="d-flex justify-content-center my-3">
                            <?php if (!empty($data['inscrito'])): ?>
                                <form action="index.php?controller=InscribeController&action=quitarInscripcion" method="POST">
                                    <input type="hidden" name="id_evento" value="<?= htmlspecialchars($data['evento']->getId_evento()) ?>">
                                    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($_SESSION['id_usuario'] ?? '') ?>">
                                    <button type="submit" class="btn btn-dark">Quitar Inscripción</button>
                                </form>
                            <?php else: ?>
                                <form action="index.php?controller=InscribeController&action=inscribirse" method="POST">
                                    <input type="hidden" name="id_evento" value="<?= htmlspecialchars($data['evento']->getId_evento()) ?>">
                                    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($_SESSION['id_usuario'] ?? '') ?>">
                                    <button type="submit" class="btn btn-dark">Inscribirse</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-danger text-center fw-bold">La inscripción ha terminado.</p>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['mensaje'])): ?>
                        <p class="alert alert-success mt-3 text-center">
                            <?= htmlspecialchars($_SESSION['mensaje']) ?>
                        </p>
                        <?php unset($_SESSION['mensaje']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <p class="alert alert-danger mt-3 text-center">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                        </p>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <div class="text-center mt-4">
                        <a href="index.php?controller=EventoController&action=lista_eventos_activos" class="btn btn-dark">
                            Volver a la lista de eventos
                        </a>
                    </div>
                </div>
            </div>
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