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
    <!-- Formulario Alta Vehículo -->
    <main class="flex-fill">
        <h2 class="section-title mb-4">¡Añadir Vehículo!</h2>
        <article class="d-flex flex-column justify-content-center align-items-center pb-4">
            <form class="border p-4 rounded shadow-sm" action="?controller=VehiculoController&action=insertarVehiculo" method="post">
                <div class="mb-3">
                    <label for="matricula" class="form-label text-white">Matrícula</label>
                    <input type="text" class="form-control" id="matricula" name="matricula" value="<?= htmlspecialchars($_POST['matricula'] ?? '') ?>" required pattern="[0-9]{4}[A-Z]{3}" placeholder="1234ABC">
                </div>

                <div class="mb-3">
                    <label for="marca" class="form-label text-white">Marca:</label>
                    <select name="marca" class="form-select form-select-sm">
                        <?php foreach ($data['marcas'] as $m): ?>
                            <option value="<?= htmlspecialchars($m) ?>" <?= (isset($data['marca']) && $data['marca'] == $m) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="modelo" class="form-label text-white">Modelo</label>
                    <input type="text" class="form-control" id="modelo" name="modelo" value="<?= htmlspecialchars($_POST['modelo'] ?? '') ?>" required maxlength="30" placeholder="TDI">
                </div>

                <div class="mb-3">
                    <label for="anio" class="form-label text-white">Año</label>
                    <input type="number" class="form-control" id="anio" name="anio" value="<?= isset($_POST['anio']) ? htmlspecialchars($_POST['anio']) : '' ?>" required min="1900" max="<?= date('Y') ?>" placeholder="2018">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-outline-danger text-white">Insertar</button>
                    <a href="?controller=VehiculoController&action=listarVehiculos" class="border border-light px-2 py-2 rounded-1 btn-inset">Cancelar</a>
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

    <?php include_once("footer.html"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>