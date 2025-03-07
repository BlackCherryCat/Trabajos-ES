<?php
require_once 'includes/header.php';

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
//if ($resultTramos->num_rows > 1) {
    // Si hay más de un tramo, puedes decidir mostrar un error o permitir seleccionar un tramo
  //  die("Error: Esta reserva tiene varios tramos asignados. No se puede editar.");
//} else {
    // Si tiene solo un tramo, podemos proceder normalmente
    $tramo = $resultTramos->fetch_assoc();
    $idTramo = $tramo['IdTramo'];
    $horarioTramo = $tramo['Horario'];
//}

$stmtTramos->close();

// Obtener el número total de alumnos en ese tramo y fecha
$queryAlumnosTotales = "SELECT MAX(TotalAlumnos) AS MaxTotalAlumnos 
                            FROM (
                                SELECT SUM(Reservas.NumAlumnos) AS TotalAlumnos
                                FROM Reservas
                                RIGHT JOIN Reserva_Tramos ON Reservas.IdReserva = Reserva_Tramos.IdReserva
                                INNER JOIN Tramos ON Reserva_Tramos.IdTramo = Tramos.IdTramo
                                WHERE Reservas.Fecha = ?
                                GROUP BY Tramos.IdTramo
                            ) AS Subconsulta;";

$stmtAlumnosTotales = $db->prepare($queryAlumnosTotales);
$stmtAlumnosTotales->bind_param("s", $reserva['Fecha']);
$stmtAlumnosTotales->execute();
$resultAlumnosTotales = $stmtAlumnosTotales->get_result();
$rowAlumnosTotales = $resultAlumnosTotales->fetch_assoc();
$stmtAlumnosTotales->close();

$totalAlumnosTramo = $rowAlumnosTotales['MaxTotalAlumnos'] ?? 0;

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
        <input type='hidden' name='profe' value='<?php echo $_SESSION["profesor"]["IdProfesor"]?>' id='idProfesor'>
        <input type="hidden" name="idReserva" value="<?= $reserva['IdReserva'] ?>">
        
        <div class="mb-3">
            <label for="numAlumnos" class="form-label">Número de Alumnos<span style="color: red;">*</span></label>
            <input type="number" name="numAlumnos" id="numAlumnos" class="form-control" min="1" max="<?= $maxAlumnos ?>" value="<?= htmlspecialchars($reserva['NumAlumnos']) ?>" required>
        </div>
        <div style='width: 80%'>
            <input type='checkbox' id='excederAlumnos' style='display:inline-block;'> 
            <label for='excederAlumnos' style='display:inline'> Quiero reservar para una cantidad mayor de alumnos</label>
        </div><br><br>

        <div class="mb-3">
            <label for="curso" class="form-label">Curso<span style="color: red;">*</span></label>
            <select name="curso" class="form-control" id="curso" required>
                <option value="">Seleccione una opción</option>
                <?php echo printClases($_SESSION["profesor"]["IdProfesor"], $db) ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="asignatura" class="form-label">Asignatura<span style="color: red;">*</span></label>
            <select name="asignatura" class="form-control" id="asignatura" required>
                <option value="">Seleccione un curso para mostrar sus asignaturas</option>
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

<script>

    const clase = document.getElementById("curso");

    console.log(clase);

    //Obtenemos el input number de alumnos
    let input = document.getElementById("numAlumnos");

    //Obtenemos el número máximo de alumnos que permite el tramo
    let maxAlumnos = parseInt(input.getAttribute('max'));
    let alumnosClase = 0;

    clase.addEventListener("change", cargarAsignaturas);

    //Evento de checkbox para saltar el límite de alumnos
    let check = document.getElementById('excederAlumnos');
    check.addEventListener("change", saltarLimiteAlumnos)

    function cargarAsignaturas(){
        let idClase = document.getElementById("curso").value;

        let idProfe = document.getElementById("idProfesor").value;

        console.log("IdClase:" +idClase)
        console.log("IdProfe" +idProfe)
        if(idClase == "Seleccione un opción"){
            return
        }
        let listaAsignaturas = document.getElementById("asignatura");

        listaAsignaturas.innerHTML = "<option>Seleccione asignatura</option>";

        let data = new FormData();

        data.append('curso', idClase);
        data.append('profe', idProfe);

        fetch("./acciones/opt-asignaturas.php",{
            method: "POST",
            body: data
        })
        .then(respuesta => respuesta.text())
        .then(data => {
            console.log(`Data `+ data);
            listaAsignaturas.innerHTML += data}
        )
        .catch(error => {
            console.log("Ha habido un error, vuelva a intentarlo");
        })


        //Fetch para los números de alumnos, solo lo hacemos si el número es menor y si el check está desactivado
        if(!check.checked){
            /* FETCH PARA HACERLO PERSONILIZADO SEGÜN LAS ASIGNATURAS
            let claseData = new FormData();

            claseData.append('clase', idClase);

            fetch("./acciones/getAlumnosClase.php", {
                method: "POST",
                body: claseData
            })
            .then(respuesta => respuesta.text())
            .then(numAlumnos => {
                alumnosClase = parseInt(numAlumnos);


                if(numAlumnos < maxAlumnos){
                    input.setAttribute('max', alumnosClase)
                    input.setAttribute('value', alumnosClase)
                }
                
            })*/
            if(maxAlumnos > 30){
                input.setAttribute('max', 30)
                input.setAttribute('value', 30)
            }
        }
        
    }

    function saltarLimiteAlumnos(e){
        if(e.target.checked){
            input.setAttribute('max', maxAlumnos)
        }else{
            input.setAttribute('max', alumnosClase)
            input.setAttribute('value', alumnosClase)
        }
    }
</script>

<?php 
    require_once './includes/footer.php'; 
    //Función que imprime options de las clases a las que imparte un profesor
    function printClases($idPro, $db){
        $query = "select Cursos.IdCurso, Cursos.Nombre from Cursos
                    inner join Profesor_Curso_Asignatura on Cursos.IdCurso = Profesor_Curso_Asignatura.IdCurso
                    where Profesor_Curso_Asignatura.IdProfesor = $idPro
                    group by Cursos.IdCurso";

        $result = mysqli_query($db, $query);

        $cadena = "";

        while($registro = mysqli_fetch_assoc($result)){
            $cadena .= "<option value='$registro[IdCurso]'>$registro[Nombre]</option>";
        }
        return $cadena;
    }
?>
