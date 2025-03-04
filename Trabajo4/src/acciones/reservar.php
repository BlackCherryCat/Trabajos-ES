<?php
    include_once "../includes/conexion.php";
        $idProfe = $_SESSION["profesor"]["IdProfesor"];
        $idClase = $_POST["clase"];
        $idAsignatura = $_POST["asignatura"];
        $numAlumnos = $_POST["alumnos"];
        $tramos = $_SESSION["selectedTramos"];
        $fecha = $_SESSION["fechaReserva"];

        try{
            $query = "INSERT INTO Reservas (Fecha, NumAlumnos, IdCurso, IdAsignatura, IdProfesor)
            values ('$fecha', $numAlumnos, $idClase, $idAsignatura, $idProfe);";
            $result = mysqli_query($db, $query);
            //Sacamos el id de la reserva
            $idReserva = mysqli_insert_id($db);

            
            foreach ($tramos as $key => $value) {
                //Hacemos otro insert en la tabla reserva_tramos para cada uno de los tramos seleccionados
                $query2 = "INSERT INTO Reserva_Tramos (IdReserva, IdTramo)
                values ($idReserva, $value)";

                $resultado =  mysqli_query($db, $query2);
            }

            header("location: ../confirmacionReserva.php?id=$idReserva");
            exit();
        }catch(Exception $e){
            header("location: ../confirmacionReserva.php?id=NO");
            exit();
        }
?>