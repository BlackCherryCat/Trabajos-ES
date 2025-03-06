<?php
session_start();

require_once 'includes/conexion.php';

// Verificar que la conexión está establecida
if (!$db) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Verificar si se pasa un ID de reserva
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("No se ha especificado un ID de reserva.");
}

$idReserva = $_GET['id'];

// Consulta para obtener los detalles de la reserva
$sql = "SELECT R.IdReserva, R.Fecha, R.NumAlumnos, C.IdCurso, C.Nombre AS Curso, A.IdAsignatura, A.Nombre AS Asignatura
        FROM Reservas R
        INNER JOIN Cursos C ON R.IdCurso = C.IdCurso
        INNER JOIN Asignaturas A ON R.IdAsignatura = A.IdAsignatura
        WHERE R.IdReserva = ?";

$stmt = $db->prepare($sql);
$stmt->bind_param("i", $idReserva);
$stmt->execute();
$result = $stmt->get_result();

// En caso de que no encuentre la reserva mostramos lo siguiente
if ($result->num_rows == 0) {
    die("Reserva no encontrada.");
}

$reserva = $result->fetch_assoc();
$stmt->close();

// Obtener los tramos asociados a esta reserva
$sqlTramos = "SELECT RT.IdTramo, T.Horario 
              FROM Reserva_Tramos RT
              INNER JOIN Tramos T ON RT.IdTramo = T.IdTramo
              WHERE RT.IdReserva = ?";

$stmtTramos = $db->prepare($sqlTramos);
$stmtTramos->bind_param("i", $idReserva);
$stmtTramos->execute();
$resultTramos = $stmtTramos->get_result();

// Si la reserva tiene más de un tramo, manejarlo
if ($resultTramos->num_rows > 1) {
    // Si hay más de un tramo, puedes decidir mostrar un error o permitir seleccionar un tramo
    die("Error: Esta reserva tiene varios tramos asignados. No se puede editar.");
} else {
    // Si tiene solo un tramo, podemos proceder normalmente
    $tramo = $resultTramos->fetch_assoc();
    $idTramo = $tramo['IdTramo'];
    $horarioTramo = $tramo['Horario'];
}

$stmtTramos->close();

// Obtener el número total de alumnos en ese tramo y fecha
$queryAlumnosTotales = "SELECT SUM(Reservas.NumAlumnos) AS TotalAlumnos 
                        FROM Reservas
                        RIGHT JOIN Reserva_Tramos ON Reservas.IdReserva = Reserva_Tramos.IdReserva
                        INNER JOIN Tramos ON Reserva_Tramos.IdTramo = Tramos.IdTramo
                        WHERE Reservas.Fecha = ? AND Tramos.IdTramo = ?";

$stmtAlumnosTotales = $db->prepare($queryAlumnosTotales);
$stmtAlumnosTotales->bind_param("si", $reserva['Fecha'], $idTramo);
$stmtAlumnosTotales->execute();
$resultAlumnosTotales = $stmtAlumnosTotales->get_result();
$rowAlumnosTotales = $resultAlumnosTotales->fetch_assoc();
$stmtAlumnosTotales->close();

$totalAlumnosTramo = $rowAlumnosTotales['TotalAlumnos'] ?? 0;

// Calcular los alumnos disponibles
$maxAlumnos = 100 - ($totalAlumnosTramo - $reserva['NumAlumnos']);

// Obtener los cursos y asignaturas disponibles
$cursosSql = "SELECT IdCurso, Nombre FROM Cursos";
$asignaturasSql = "SELECT IdAsignatura, Nombre FROM Asignaturas";

$cursosResult = $db->query($cursosSql);
$asignaturasResult = $db->query($asignaturasSql);
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Editar Reserva</h2>
    <form action="acciones/procesar-editar-reserva.php" method="POST">
        <input type="hidden" name="idReserva" value="<?= $reserva['IdReserva'] ?>">
        
        <div class="mb-3">
            <label for="numAlumnos" class="form-label">Número de Alumnos</label>
            <input type="number" name="numAlumnos" id="numAlumnos" class="form-control" min="1" max="<?= $maxAlumnos ?>" value="<?= htmlspecialchars($reserva['NumAlumnos']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="curso" class="form-label">Curso</label>
            <select name="curso" class="form-control" id="curso" required>
                <?php while ($curso = $cursosResult->fetch_assoc()): ?>
                    <option value="<?= $curso['IdCurso'] ?>" <?= $curso['IdCurso'] == $reserva['IdCurso'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($curso['Nombre']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="asignatura" class="form-label">Asignatura</label>
            <select name="asignatura" class="form-control" id="asignatura" required>
                <?php while ($asignatura = $asignaturasResult->fetch_assoc()): ?>
                    <option value="<?= $asignatura['IdAsignatura'] ?>" <?= $asignatura['IdAsignatura'] == $reserva['IdAsignatura'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($asignatura['Nombre']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Actualizar Reserva</button>
        </div>
    </form>
    <div class="text-center mt-3">
        <a href="mis-reservas.php" class="btn btn-secondary">Volver</a>
    </div>
</div>

<?php require_once './includes/footer.php'; ?>
