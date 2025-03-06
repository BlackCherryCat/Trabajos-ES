<?php
require_once 'includes/header.php';
require_once 'includes/conexion.php';

// Verificar conexión
if (!$db) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Verificar ID de reserva
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("No se ha especificado un ID de reserva.");
}

$idReserva = $_GET['id'];

// Obtener datos de la reserva
$sql = "SELECT R.IdReserva, R.Fecha, R.NumAlumnos, C.IdCurso, C.Nombre AS Curso, 
               A.IdAsignatura, A.Nombre AS Asignatura
        FROM Reservas R
        INNER JOIN Cursos C ON R.IdCurso = C.IdCurso
        INNER JOIN Asignaturas A ON R.IdAsignatura = A.IdAsignatura
        WHERE R.IdReserva = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $idReserva);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Reserva no encontrada.");
}
$reserva = $result->fetch_assoc();
$stmt->close();

// Obtener fecha y tramo
$sqlReserva = "SELECT R.Fecha, RT.IdTramo 
               FROM Reservas R
               INNER JOIN Reserva_Tramos RT ON R.IdReserva = RT.IdReserva
               WHERE R.IdReserva = ?";
$stmtReserva = $db->prepare($sqlReserva);
$stmtReserva->bind_param("i", $idReserva);
$stmtReserva->execute();
$resultReserva = $stmtReserva->get_result();
$reservaDatos = $resultReserva->fetch_assoc();
$stmtReserva->close();

$fecha = $reservaDatos['Fecha'];
$idTramo = $reservaDatos['IdTramo'];
$numAlumnosActual = $reserva['NumAlumnos'];

// Obtener el total de alumnos permitidos en el tramo
$sqlMax = "SELECT COALESCE(MAX(TotalAlumnosPermitidos), 0) AS MaxPermitidos
           FROM Tramos
           WHERE IdTramo = ?";
$stmtMax = $db->prepare($sqlMax);
$stmtMax->bind_param("i", $idTramo);
$stmtMax->execute();
$resultMax = $stmtMax->get_result();
$rowMax = $resultMax->fetch_assoc();
$stmtMax->close();

$maxPermitidos = $rowMax['MaxPermitidos'];

// Obtener alumnos ya reservados en ese tramo y fecha
$sqlReservados = "SELECT SUM(NumAlumnos) AS AlumnosReservados
                  FROM Reservas
                  INNER JOIN Reserva_Tramos ON Reservas.IdReserva = Reserva_Tramos.IdReserva
                  WHERE Reservas.Fecha = ? AND Reserva_Tramos.IdTramo = ?";
$stmtReservados = $db->prepare($sqlReservados);
$stmtReservados->bind_param("si", $fecha, $idTramo);
$stmtReservados->execute();
$resultReservados = $stmtReservados->get_result();
$rowReservados = $resultReservados->fetch_assoc();
$stmtReservados->close();

$alumnosReservados = $rowReservados['AlumnosReservados'] ?? 0;

// Calcular máximo de alumnos que se pueden agregar
$maxAlumnos = $maxPermitidos - $alumnosReservados + $numAlumnosActual;

// Obtener cursos y asignaturas
$cursosResult = $db->query("SELECT IdCurso, Nombre FROM Cursos");
$asignaturasResult = $db->query("SELECT IdAsignatura, Nombre FROM Asignaturas");
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Editar Reserva</h2>
    <form action="acciones/procesar-editar-reserva.php" method="POST">
        <input type="hidden" name="idReserva" value="<?= $reserva['IdReserva'] ?>">
        
        <div class="mb-3">
            <label for="numAlumnos" class="form-label">Número de Alumnos</label>
            <input type="number" name="numAlumnos" id="numAlumnos" class="form-control" 
                   min="1" max="<?= $maxAlumnos ?>" value="<?= htmlspecialchars($reserva['NumAlumnos']) ?>" required>
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
