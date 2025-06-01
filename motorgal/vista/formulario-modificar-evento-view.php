<h2>Modificar Evento</h2>

<?php if (!empty($errores)): ?>
    <div class="errores">
        <p><?= $errores ?></p>
    </div>
<?php endif; ?>

<?php if (!empty($evento)): ?>
    <form method="POST">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($evento->getTitulo()) ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required><?= htmlspecialchars($evento->getDescripcion()) ?></textarea>

        <label for="fecha_inicio_evento">Fecha inicio:</label>
        <input type="date" name="fecha_inicio_evento" id="fecha_inicio_evento" value="<?= $evento->getFecha_inicio_evento()->format('Y-m-d') ?>" required>

        <label for="fecha_fin_evento">Fecha fin:</label>
        <input type="date" name="fecha_fin_evento" id="fecha_fin_evento" value="<?= $evento->getFecha_fin_evento()->format('Y-m-d') ?>" required>

        <label for="lugar">Lugar:</label>
        <input type="text" name="lugar" id="lugar" value="<?= htmlspecialchars($evento->getLugar()) ?>" required>

        <button type="submit">Guardar Cambios</button>
    </form>
<?php else: ?>
    <p>No se pudo cargar el evento.</p>
<?php endif; ?>
