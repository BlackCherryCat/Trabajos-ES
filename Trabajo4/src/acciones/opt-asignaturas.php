<?php
    include_once "../includes/conexion.php";


        //$prof = $_SESSION["profesor"]["IdProfesor"];
        $profe = $_POST["profe"];
        $curso = $_POST["curso"];
        
        echo $curso;
        //Sacamos todas las asignaturas que imparte el profesor en dicho curso
        $query = 
        "Select Asignaturas.IdAsignatura, Asignaturas.Nombre
        FROM Asignaturas
        INNER JOIN Curso_Asignatura on Curso_Asignatura.IdAsignatura = Asignaturas.IdAsignatura
        INNER JOIN Profesor_Curso_Asignatura on Profesor_Curso_Asignatura.IdAsignatura = Curso_Asignatura.IdAsignatura
        AND Profesor_Curso_Asignatura.IdCurso = Curso_Asignatura.IdCurso
        WHERE Profesor_Curso_Asignatura.IdCurso = $curso
        AND Profesor_Curso_Asignatura.IdProfesor = $profe;
        ";


        $result = mysqli_query($db, $query);

        while($registro = mysqli_fetch_assoc($result)){
            echo "<option value='$registro[IdAsignatura]'>$registro[Nombre]</option>";
        }

?>
