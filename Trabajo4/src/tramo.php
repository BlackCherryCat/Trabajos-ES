<?php
    require_once './includes/header.php';

    if(isset($_GET["date"])){
        //Tratamiento de la fecha
        $fecha =  $_GET["date"];
 
        $tmpFecha = explode("-", $fecha);
        $fecha = implode("/", $tmpFecha);

        $today = date("d-m-Y", (time() +strtotime($fecha)));
        $day = date("d", strtotime($fecha));
        $month = monthString(date("m", strtotime($fecha)));
        $year = date("o", strtotime($fecha));

        echo $day." de ".$month." de ".$year;
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