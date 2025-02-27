<?php
    include_once "../includes/conexion.php";

    $idClase = $_POST["clase"];

    $query = "
    select NumAlumnos from Cursos
    where IdCurso = $idClase;
    ";

    $result = mysqli_query($db, $query);

    echo mysqli_fetch_assoc($result)["NumAlumnos"];
?>