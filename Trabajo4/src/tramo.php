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

        $horario = ["08:00", "09:00", "10:00", "11:00", "12:00", "13:00"];

        //En este array vamos a guardar las plazas disponibles de cada tramo
        $plazas = [];

        //Imprimimos la interfaz para cada tramo
        for ($i=0; $i < count($horario); $i++) { 
          echo getOccupation($horario[$i], $today, $db, $i+1, $plazas);
        }
        
        //Pasamos por la sesión el array de plazas y la fecha
        $_SESSION["plazas"] = $plazas;
        $_SESSION["fechaReserva"] = $today;

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

      function getOccupation($hora, $dia, $db, $index, &$plazas){
        $cadena = "<tr><td class='hora'>$hora";

        $groupBy = "";

        //Al agrupar la sentencia por reservas, vamos a poder imprimir los datos de forma más detallada para el admin
        if($_SESSION["profesor"]["EsAdmin"] == 1){
          $groupBy = "group by Reserva_Tramos.IdReserva;";
        }else{
          $groupBy = "group by Reserva_Tramos.IdTramo;";
        }

        

        //Contenido de td, divs con reservas y nueva reserva
        $query = "select Reservas.IdReserva, Reserva_Tramos.IdTramo, Reservas.Fecha, Tramos.Horario, sum(Reservas.NumAlumnos) As 'Alumnos', Profesores.Nombre AS 'profe', Asignaturas.Nombre
                    from Reservas
                    right join Reserva_Tramos on Reservas.IdReserva = Reserva_Tramos.IdReserva
                    inner join Tramos on Reserva_Tramos.IdTramo = Tramos.IdTramo
                    inner join Profesores on Reservas.IdProfesor = Profesores.IdProfesor
                    inner join Asignaturas on Reservas.IdAsignatura = Asignaturas.IdAsignatura
                    where Reservas.Fecha = '$dia' AND
                    Tramos.Horario = '$hora'
                    $groupBy";

        $result = mysqli_query($db, $query);

        if(mysqli_num_rows($result) == 0){
          $cadena .="<td><div class='wrapper'><label for='tramo$index'><div class='nuevo'>&#10133;<br>Añadir Tramo<br>a la Reserva</div><div class='remove-hover'>&#x2716;<br>Eliminar Tramo</div></label><div class='free'>Asientos Libres<br>100</div></div></td>";
          $plazas[] = 100;
        }else{
          //Obtenemos el número asientos ocupados de cada resultado y guardamos en una variable
          $sumatoria = 0;
          //Iniciamos la columna
          $cadena .= "<td><div class='wrapper'>";

          $contador = 1;


          if($_SESSION["profesor"]["EsAdmin"] == 1){
            while($registro = mysqli_fetch_assoc($result)){
              $cadena .= "<div class='reserva' style='width:$registro[Alumnos]%'>Reserva";
              $cadena .= "<b>Profesor: </b>";
              $cadena .= $registro["profe"]."<br>";
              $cadena .= "<b>Asignatura:</b> $registro[Nombre]";
              $sumatoria += $registro["Alumnos"];
              $cadena .= "</div>";
  
              
              //Añadimos el máximo de plazas disponibles al array
              $plazas["tramo$index"] = 100-$sumatoria;
              $contador++;
            }
          }else{
            while($registro = mysqli_fetch_assoc($result)){
              $cadena .= "<div class='reserva' style='width:$registro[Alumnos]%'>Reserva";
              $cadena .= "<b>Ocupado: </b>";
              $cadena .= $registro["Alumnos"]." plazas";
              $sumatoria += $registro["Alumnos"];
              $cadena .= "</div>";
  
              
              //Añadimos el máximo de plazas disponibles al array
              $plazas["tramo$index"] = 100-$sumatoria;
              $contador++;
            }
          }
          

          //Cerramos la columna 1
          $cadena .= "<label for='tramo$index'><div class='nuevo'>&#10133;<br>Añadir Tramo<br>a la Reserva</div><div class='remove-hover'>&#x2716;<br>Eliminar Tramo</div></label><div class='free'>Asientos Libres<br>".(100-$sumatoria)."</div></div></td>";
          $sumatoria = 0;
        }

        $cadena .= "</td></tr>";
        return $cadena;
      }
?>
<form action="form-reserva.php" class="tramos">

  <input type="checkbox" name="tramo1" id="tramo1">
  <input type="checkbox" name="tramo2" id="tramo2">
  <input type="checkbox" name="tramo3" id="tramo3">
  <input type="checkbox" name="tramo4" id="tramo4">
  <input type="checkbox" name="tramo5" id="tramo5">
  <input type="checkbox" name="tramo6" id="tramo6">
<button type="submit" id="btn-sticky">Ir al Formulario de Reserva</button>
</form>
<script src="assets/script/tramos.js"></script>


<?php 
  require_once './includes/footer.php';
?>