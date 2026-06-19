<?php
// conexion.php

$servidor = "localhost";
$usuarioDB = "root";
$clave = "";
$basedatos = "proyecto";

$Laconexion = mysqli_connect($servidor, $usuarioDB, $clave, $basedatos);

if (!$Laconexion) {
    die("La conexión ha fallado: " . mysqli_connect_error());
}
?>