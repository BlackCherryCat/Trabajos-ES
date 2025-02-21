<?php
    require_once './includes/header.php';

    if(isset($_SESSION["plazas"]) && isset($_SESSION["fechaReserva"])){
        $plazas = $_SESSION["plazas"];
        $disponibles = maxAlumnos($plazas);
        $idProfe = 1;
        echo "<form action='./acciones/reservar.php' method='post' id='formReserva'>
        <h2>Formulario de Reserva</h2><hr>
        <label for='clase'>Seleccione Clase</label><br>
        <select name='clase' id='clase'>";



        echo printClases($idProfe, $db);
        echo "</select><br><br>
        <label for='asignatura'>Seleccione Asignatura</label><br>
        <select name='asignatura'>
            <option>Matemáticas Avanzadas</option>
        </select><br><br>
        
        <label for='alumnos'>Seleccine el número de alumnos</label><br>
        <input type='number' id='alumnos' max='$disponibles'><br><br>
        ";

        echo "<button type='submit'>Reservar</button></form>";
    }else{
        header("location: reserva.php");
        exit();
    }

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

    //Función que me improme todos los options del select de asignaturas de un profesor
    function printAsignaturas(){

    }

    //Función que calcula el máximo de almunos en función de los tramos seleccionados
    function maxAlumnos($plazas){
        $disponibles = 100;

        for ($i=1; $i <= 6; $i++) { 
            if(isset($_GET["tramo$i"])){
                //Comprobamos el número de plazas displonibles
                if($plazas[$i-1] < $disponibles){
                    $disponibles = $plazas[$i-1];
                }
            }
        }
        return $disponibles;
    }

?>