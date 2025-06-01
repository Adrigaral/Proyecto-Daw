<h2>Crear Evento</h2>

<?php if (!empty($errores)): ?>
    <div class="errores">
        <?php echo htmlspecialchars($errores); ?>
    </div>
<?php endif; ?>

<form action="" method="post">
    <label for="titulo">Título:</label>
    <input type="text" name="titulo" required>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" required></textarea>

    <label for="fecha_inicio_evento">Fecha y hora inicial del evento:</label>
    <input type="datetime-local" name="fecha_inicio_evento" required>

    <label for="fecha_fin_evento">Fecha y hora final del evento:</label>
    <input type="datetime-local" name="fecha_fin_evento" required>

    <label for="limite_plazas">Límite de plazas:</label>
    <input type="number" name="limite_plazas" min="0">

    <label for="requisitos">Requisitos (modelo de coche):</label>
    <input type="text" name="requisitos">

    <label for="lugar">Lugar:</label>
    <input type="text" name="lugar" required>

    <button type="submit">Crear Evento</button>
</form>
