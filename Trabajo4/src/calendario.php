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
  //Controlar el número de días del mes
  $nextMonthDay = 1;
  $currentMonthDays = date("t");
  
  //Creamos la fecha para el dia 1 de ese mes y ese año
  $firstDayMonth = "$month/01/$year";
  $newDate = strtotime($firstDayMonth);

  //Obtenemos que dia de la semana es dicho dia 1
  $weekDay = date("w", $newDate) -2;

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


  //Controlar en qué dia de la semana empieza el mes, para colocar el día 1 

  for ($i=0; $i < 5; $i++) { 
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
    echo "</tr>";
  }

  //Cerramos la tabla

  echo "</table>";

  require_once './includes/footer.php';

  function monthString($monthNum){

  }
?>