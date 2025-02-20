<?php
// Conexión
$server = 'db';
$user = 'root';
$passwd = 'root';
$bd = 'GestionReservas';
$db = mysqli_connect($server, $user, $passwd, $bd);

mysqli_query($db, "SET NAMES 'utf8'");

// Iniciar la sesión
if(!isset($_SESSION)){
	session_start();
}