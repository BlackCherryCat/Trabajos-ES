<?php
    include_once "../includes/conexion.php";

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["clase"]) && isset($_POST["asignatura"]) && isset($_POST["alumnos"]) && isset($_SESSION["profesor"])){
        $idProfe = $_SESSION["profesor"]["IdProfesor"];
        $idClase = $_POST["clase"];
        $idAsignatura = $_POST["asignatura"];
        $numAlumnos = $_POST["alumnos"];

        $query = "";
        
    }else{
        header("location: ../reserva.php");
        exit();
    }

?>