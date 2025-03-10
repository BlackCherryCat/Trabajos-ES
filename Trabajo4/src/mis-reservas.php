<?php
require_once 'includes/header.php';
// Comprobar que la conexión se realizo sin problema
if (!$db) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Cogemos el id del profesor
$idProfesor = $_SESSION['profesor']['IdProfesor'];

// Consulta SQL para obtener las reservas, sus horarios y más
$sql = "SELECT R.IdReserva, RT.IdTramo, R.Fecha, R.NumAlumnos, C.Nombre AS Curso, A.Nombre AS Asignatura, T.Horario
        FROM Reservas R
        INNER JOIN Cursos C ON R.IdCurso = C.IdCurso
        INNER JOIN Asignaturas A ON R.IdAsignatura = A.IdAsignatura
        LEFT JOIN Reserva_Tramos RT ON R.IdReserva = RT.IdReserva
        LEFT JOIN Tramos T ON RT.IdTramo = T.IdTramo
        WHERE R.IdProfesor = ?
        AND R.Fecha >= CURDATE()
        ORDER BY R.Fecha";

$stmt = $db->prepare($sql);
$stmt->bind_param("i", $idProfesor);
$stmt->execute();
$result = $stmt->get_result();
?>
<h2 class="mb-4 text-center">Mis Reservas</h2>

<?php
// Verificar si hay mensajes de error o éxito
if (isset($_SESSION['error_general']) && !empty($_SESSION['error_general'])) {
    echo "<p class='error'>" . $_SESSION['error_general'] . "</p>";
    unset($_SESSION['error_general']);
}

if (isset($_SESSION['correcto']) && !empty($_SESSION['correcto'])) {
    echo "<p class='correcto'>" . $_SESSION['correcto'] . "</p>";
    unset($_SESSION['correcto']);
}
?>

<!-- Comprobamos si hay resultados en la consulta, si es así los pintamos en forma de tabla -->
<?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Nº Alumnos</th>
                    <th>Curso</th>
                    <th>Asignatura</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Convertimos las filas en arrays y mostramos-->
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Fecha']) ?></td>
                        <td><?= htmlspecialchars($row['Horario']) ?></td>
                        <td><?= htmlspecialchars($row['NumAlumnos']) ?></td>
                        <td><?= htmlspecialchars($row['Curso']) ?></td>
                        <td><?= htmlspecialchars($row['Asignatura']) ?></td>
                        <td>
                            <a href="editar-reserva.php?id=<?= $row['IdReserva'] ?>" title="Editar" class="me-2">
                                <img src="assets/img/editar.png" alt="Editar" width="28">
                            </a>
                            <a href="acciones/borrar-reserva.php?id=<?= $row['IdReserva'] ?>&idTramo=<?= $row['IdTramo'] ?>" title="Borrar" class="me-2" onclick="return confirm('¿Estás seguro de que deseas eliminar este tramo?');">
                                <img src="assets/img/borrar.png" alt="Borrar" width="28">
                            </a>
                            <a href="descargar-reserva.php?id=<?= $row['IdReserva'] ?>&op=D" title="Descargar PDF">
                                <img src="assets/img/descargar.png" alt="Descargar PDF" width="28">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- En caso de no haber resultados mostramos que no hay reservas registradas -->
<?php else: ?>
    <p class="alert alert-warning text-center">No tienes reservas registradas.</p>
<?php endif; ?>

<!-- Boton para volcer a las reservas -->
<div class="text-center mt-4">
    <a href="./index.php" class="btn btn-primary">Volver</a>
</div>

<?php
// cerramos el statement
$stmt->close();
?>
<?php require_once './includes/footer.php'; ?>
