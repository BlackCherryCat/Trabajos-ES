<?php
// Conexión
$server = 'localhost';
$user = 'root';
$passwd = '';
$bd = 'GestionReservas';
$db = mysqli_connect($server, $user, $passwd, $bd);

mysqli_query($db, "SET NAMES 'utf8'");

// Iniciar la sesión
if(!isset($_SESSION)){
	session_start();
}