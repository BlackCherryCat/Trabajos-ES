<?php
require_once 'includes/header.php';

if ($_SESSION['profesor']['EsAdmin'] != 1) {
    header("Location: ./index.php");
    exit();
}
?>
    <h2 class="mb-4 text-center">Todas las reservas</h2>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Profesor</th>
                    <th>Nº Alumnos</th>
                    <th>Curso</th>
                    <th>Asignatura</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $reservas = obtenerReservas($db);
                
                foreach ($reservas as $reserva) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reserva['IdReserva']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['Fecha']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['Horario']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['Profesor']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['NumAlumnos']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['Curso']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['Asignatura']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php require_once './includes/footer.php'; ?>