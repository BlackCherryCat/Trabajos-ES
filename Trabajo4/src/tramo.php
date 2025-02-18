<?php
    require_once './includes/header.php';

    if(isset($_GET["date"])){
        //Tratamiento de la fecha
        $fecha =  $_GET["date"];
 
        $tmpFecha = explode("-", $fecha);
        $fecha = implode("/", $tmpFecha);

        $today = date("Y-m-d", strtotime($fecha));
        $day = date("d", strtotime($fecha));
        $month = monthString(date("m", strtotime($fecha)));
        $year = date("o", strtotime($fecha));

        echo "<h1>".$day." de ".$month." de ".$year."</h1>";
        //Imprimir los tramos

        echo "<table class='tramo'><tr><th colspan='2'>Salón de Actos</th></tr>";

        $horario = ["08:30", "09:30", "10:30", "11:30", "12:30", "13:30"];

        $i = 0;
        

        //Hay que sacar el número de alumnos

        foreach($horario as $hora){
          echo getOccupation($hora, $today, $db);
        }
        
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

      function getOccupation($hora, $dia, $db){
        $cadena = "<tr><td class='hora'>$hora";

        //Contenido de td, divs con reservas y nueva reserva
        $query = "select Reservas.IdReserva, Reserva_Tramos.IdTramo, Reservas.Fecha, Tramos.Horario, sum(Reservas.NumAlumnos) As 'Alumnos'
                    from Reservas
                    right join Reserva_Tramos on Reservas.IdReserva = Reserva_Tramos.IdReserva
                    inner join Tramos on Reserva_Tramos.IdTramo = Tramos.IdTramo
                    where Reservas.Fecha = '.$dia.' AND
                    Tramos.Horario = '.$hora.'
                    group by Reserva_Tramos.IdTramo;";

        $result = mysqli_query($db, $query);

        if(mysqli_num_rows($result) == 0){
          $cadena .="<td><div class='wrapper'><a href='#'><div class='nuevo'><span class='add'>&#43;</span>Añadir Reserva</div></a><div class='free'>Asientos Libres<br>100</div></div></td>";
        }else{
          //Obtenemos el número asientos ocupados de cada resultado y guardamos en una variable
          $sumatoria = 0;
        }

        $cadena .= "</td></tr>";
        return $cadena;
      }
?>