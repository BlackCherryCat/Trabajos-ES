<?php
    require_once './includes/header.php';
    require_once './includes/conexion.php';
?>
    <h2>Confirmación De Reserva</h2>
<?php
    if(isset($_GET["id"]) && $_GET["id"] != "NO"){
        $idReserva = $_GET["id"];
        echo "<h4>Reserva nº $idReserva</h4>";
        echo "Su reserva ha sido procesada con éxito<br>";

        echo "<embed src=\"descargar-reserva.php?I=1&id=$idReserva\" type=\"application/pdf\" width=\"100%\" height=\"600px\" />";
    }else{
        echo "Ha ocurrido un error inesperado durante el proceso de reserva. Contacte con Servicio Técnico o vuelva a intentarlo más tarde<br>";
    }
?>
<a href="mis-reservas.php">Ir a mis reservas</a>