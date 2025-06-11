<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Evento | Motorgal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="../estilos/style.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include_once("header.php"); ?>
    <main class="flex-fill py-5">
        <?php
        $evento = $data['evento'] ?? null;
        $requisitos = $data['requisitos'] ?? [];
        $errores = $data['errores'] ?? '';
        ?>
        <div class="container">
            <div class="card shadow-lg">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Creación del evento</h4>
                </div>
                <div class="card-body">
                    <form action="?controller=EventoController&action=modificar_evento&id=<?= $evento->getId_evento() ?>" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" name="titulo" id="titulo" class="form-control" value="<?= htmlspecialchars($evento->getTitulo()) ?>" placeholder="Ponle un título para llamar la atención" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lugar" class="form-label">Lugar</label>
                                <input type="text" name="lugar" id="lugar" class="form-control" value="<?= htmlspecialchars($evento->getLugar()) ?>" placeholder="Lugar donde se celebrará el evento" required>
                            </div>
                            <div class="col-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea name="descripcion" id="descripcion" rows="4" class="form-control descrip" placeholder="Escribe aquí toda la información que creas conveniente para promocionarte" required><?= htmlspecialchars($evento->getDescripcion()) ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_inicio_evento" class="form-label">Fecha y hora de inicio</label>
                                <input type="datetime-local" name="fecha_inicio_evento" class="form-control" value="<?= $evento->getFecha_inicio_evento()->format('Y-m-d\TH:i') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_fin_evento" class="form-label">Fecha y hora de fin</label>
                                <input type="datetime-local" name="fecha_fin_evento" class="form-control" value="<?= $evento->getFecha_fin_evento()->format('Y-m-d\TH:i') ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="limite_plazas" class="form-label">Límite de plazas</label>
                                <input type="number" name="limite_plazas" class="form-control" value="<?= htmlspecialchars($evento->getLimite_plazas()) ?>" placeholder="Plazas máximas para llevar a cabo el evento" min="10">
                            </div>
                            <div class="col-md-4">
                                <label for="requisitos" class="form-label">Marca del vehículo</label>
                                <select name="requisitos" class="form-select" required>
                                    <?php if (!empty($data['requisitos']) && is_array($data['requisitos'])): ?>
                                        <?php foreach ($data['requisitos'] as $r): ?>
                                            <option value="<?= htmlspecialchars($r) ?>"
                                                <?= ($evento && $evento->getRequisitos() === $r) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($r) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" name="precio" class="form-control" value="<?= htmlspecialchars($evento->getPrecio()) ?>" placeholder="Costo de entrada para participar" required>
                            </div>
                            <div class="col-md-6">
                                <label for="foto_evento" class="form-label">Foto del evento</label>
                                <input type="hidden" name="foto_evento_actual" value="<?= htmlspecialchars($evento->getFoto_evento()) ?>">
                                <input type="file" name="foto_evento" id="foto_evento" class="form-control">
                                <?php if ($evento && $evento->getFoto_evento()): ?>
                                    <img src="../img/uploads/<?= htmlspecialchars($evento->getFoto_evento()) ?>"
                                        id="imgPreview" class="mt-2 img-thumbnail" style="max-height: 150px;">
                                <?php else: ?>
                                    <img id="imgPreview" class="mt-2 img-thumbnail" style="max-height: 150px;">
                                <?php endif; ?>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Ubicación en el mapa</label>
                                <div id="map" style="height: 400px;" class="rounded border"></div>
                                <input type="hidden" name="latitud" id="latitud" value="<?= htmlspecialchars($evento->getLatitud()) ?>" required>
                                <input type="hidden" name="longitud" id="longitud" value="<?= htmlspecialchars($evento->getLongitud()) ?>" required>
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-outline-danger text-white">Modificar Evento</button>
                        </div>
                        <div class="mt-4 text-center">
                            <a class="btn btn-outline-danger text-white" href="?controller=EventoController&action=lista_eventos_creados">Volver a mis eventos</a>
                        </div>
                    </form>

                    <?php if (!empty($data['errores'])): ?>
                        <div class="alert alert-danger mt-3 text-center">
                            <?= $data['errores'] ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </main>

    <?php include_once("footer.html"); ?>

    <script src="../js/image-preview.js"></script>
    <script src="../js/mapa.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>