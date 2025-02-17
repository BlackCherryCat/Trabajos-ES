<?php
  
  require_once './includes/header.php'; 
  //Imprimir el calendario, en una tabla
  echo "<table><tr><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th><th>Sábado</th><th>Domingo</th></tr>";

  //Sacamos en qué dia de la semana cae el día 1 del mes, así como cuantos dias tiene el mes actual


  $month;
  if(isset($_GET["month"]) && isset($_GET["year"])){
    $month = $_GET["month"];
    $year = $_GET["year"];
  }else{
    //Si no hay una fecha en el get, lo controlamos sacando el mes de la fecha actual
    $month = date("m");
    $year = date("Y");
  }
  
  //Creamos la fecha para el dia 1 de ese mes y ese año
  $firstDayMonth = "$month/01/$year";
  $newDate = strtotime($firstDayMonth);

  //Controlar el número de días del mes
  $nextMonthDay = 1;
  $currentMonthDays = date("t", $newDate);

  //Obtenemos que dia de la semana es dicho dia 1
  $weekDay = date("w", $newDate) -2;
  if($weekDay < 0){
    $weekDay = 5;
  }

  //Obtenemos el número de dias del mes anterior
  if($month >= 1){
    $lastMonth = $month -1;
    $lastYear = $year;
  }else{
    $lastMonth = 12;
    $lastYear = $year-1;
  }

  $lastMonthNumDays = date("t", strtotime("$lastMonth/01/$lastYear"));

  $dia = 1;

  
  //Enlace al mes anterior
  if($month > 1){
    $previoustMonthLink = "<a href='reserva.php?month=".($month-1)."&year=".$year."'>&lt;&lt;Mes Anterior</a>";
  }else{
    $previoustMonthLink = "<a href='reserva.php?month=".(12)."&year=".($year-1)."'>&lt;&lt;Mes Anterior</a>";
  }

  //Enlace al siguiente mes
  if($month < 12){
    $nextMonthLink = "<a href='reserva.php?month=".($month+1)."&year=".$year."'>Siguiente Mes&gt;&gt;</a>";
  }else{
    $nextMonthLink = "<a href='reserva.php?month=".(1)."&year=".($year+1)."'>Siguiente Mes&gt;&gt;</a>";
  }

  echo "<div class='calendar-header'>";
  echo $previoustMonthLink;
  //Asignamos la cadena de texto al mes
  $monthName = monthString($month);
  echo "<h1>".$monthName." ".$year."</h1>";
  echo $nextMonthLink;
  echo "</div>";

  //Controlar en qué dia de la semana empieza el mes, para colocar el día 1 

  for ($i=0; $i < 5; $i++) { 
    echo "<tr>";
    for ($x=1; $x <= 7; $x++) {

        if($weekDay >= 0){
            echo "<td class='cal disabled'>".($lastMonthNumDays - $weekDay)."</td>";
            $weekDay--;
        }else{
            if($dia <= $currentMonthDays){
                $getDay = $year."-".$month."-".$dia;
                echo "<td class='cal'><a href='tramo.php?date=".$getDay."'>$dia</a></td>";
                $dia++;
            }else{
                echo "<td class='cal disabled'>$nextMonthDay</td>";
                $nextMonthDay++;
            }
        }
    }
    echo "</tr>";
  }
  if($currentMonthDays >= $dia){
    echo "<tr>";
    for ($x=1; $x <= 7; $x++) {

      if($weekDay >= 0){
          echo "<td class='cal disabled'>".($lastMonthNumDays - $weekDay)."</td>";
          $weekDay--;
      }else{
          if($dia <= $currentMonthDays){
              echo "<td class='cal'>$dia</td>";
              $dia++;
          }else{
              echo "<td class='cal disabled'>$nextMonthDay</td>";
              $nextMonthDay++;
          }
      }
  }
    echo "<tr>";
  }

  //Cerramos la tabla

  echo "</table>";

  require_once './includes/footer.php';

  function monthString($monthNum){
    $monthText = "";

    switch ($monthNum){
      case 1:
        $monthText = "ENERO";
        break;
      case 2:
          $monthText = "FEBRERO";
          break;
      case 3:
        $monthText = "MARZO";
        break;
      case 4:
        $monthText = "ABRIL";
        break;
      case 5:
        $monthText = "MAYO";
        break;
      case 6:
        $monthText = "JUNIO";
        break;
      case 7:
        $monthText = "JULIO";
        break;
      case 8:
        $monthText = "AGOSTO";
        break;
      case 9:
        $monthText = "SEPTIEMBRE";
        break;
      case 10:              
        $monthText = "OCTUBRE";
        break;
      case 11:
        $monthText = "NOVIEMBRE";
        break;
      case 12:
        $monthText = "DICIEMBRE";
        break;
    }
    return $monthText;
  }
?>