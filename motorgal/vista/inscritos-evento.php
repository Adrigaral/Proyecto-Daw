<h1>Usuarios Inscritos</h1>

<?php foreach ($inscritos as $usuario): ?>
    <h3><?php echo $usuario['nombre']; ?> (<?php echo $usuario['dni']; ?>)</h3>
    <?php if (!empty($usuario['vehiculos'])): ?>
        <ul>
            <?php foreach ($usuario['vehiculos'] as $vehiculo): ?>
                <li><?php echo $vehiculo['marca'] . ' ' . $vehiculo['modelo'] . ' (' . $vehiculo['matricula'] . ')'; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Sin vehículos registrados.</p>
    <?php endif; ?>
<?php endforeach; ?>
