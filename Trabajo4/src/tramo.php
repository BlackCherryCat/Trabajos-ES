<?php
    require_once './includes/header.php';
    include_once './includes/conexion.php';

    if(isset($_GET["date"])){
        //Tratamiento de la fecha
        $fecha =  $_GET["date"];
 
        $tmpFecha = explode("-", $fecha);
        $fecha = implode("/", $tmpFecha);

        $today = date("Y-m-d", (time() +strtotime($fecha)));
        $day = date("d", strtotime($fecha));
        $month = monthString(date("m", strtotime($fecha)));
        $year = date("o", strtotime($fecha));

        echo "<h1>".$day." de ".$month." de ".$year."</h1>";
        //Imprimir los tramos

        echo "<table class='tramo'><tr><th>08:30-09:30</th><th>09:30-10:30</th><th>10:30-11:30</th><th>11:30-12:30</th><th>12:30-13:30</th><th>13:30-14:30</th></tr>";

        $horario = ["08:30", "09:30", "10:30", "11:30", "12:30", "12:30", "14:30"];

        $i = 0;

        //Aqui, hay que hacer sql, sacar las plazas disponibles por cada tramo y imprimir el tramo completo, por colores. Queda controlar el horario y dia
        $query = "select Reserva_Tramos.IdTramo, Reserva.Fecha, Tramo.Horario, sum(Reservas.NumAlumnos) As 'Alumnos'
                    from Reservas
                    right join Reserva_Tramos on Reservas.IdReserva = Reserva_Tramos.IdReserva
                    inner join Tramos on Reserva_Tramos.IdTramo = Tramos.IdTramo
                    where Reserva.Fecha = '.$today.' AND
                    Tramo.Horario = '.$horario[$i].'
                    group by Reserva_Tramos.IdTramo;";

        //Hay que sacar el número de alumnos

        echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr></table>";







    }else{
        header('location: reserva.php');
        exit();
    }



    require_once './includes/footer.php';


    function monthString($monthNum){
        $monthText = "";
    
        switch ($monthNum){
          case 1:
            $monthText = "Enero";
            break;
          case 2:
              $monthText = "Febrero";
              break;
          case 3:
            $monthText = "Marzo";
            break;
          case 4:
            $monthText = "Abril";
            break;
          case 5:
            $monthText = "Mayo";
            break;
          case 6:
            $monthText = "Junio";
            break;
          case 7:
            $monthText = "Julio";
            break;
          case 8:
            $monthText = "Agosto";
            break;
          case 9:
            $monthText = "Septiembre";
            break;
          case 10:              
            $monthText = "Octubre";
            break;
          case 11:
            $monthText = "Noviembre";
            break;
          case 12:
            $monthText = "Diciembre";
            break;
        }
        return $monthText;
      }
?>