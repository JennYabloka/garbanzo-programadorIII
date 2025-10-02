<?php

$HostName = "localhost";
$UserName = "root";
$Password = "";
$DataBaseName = "tenedor_salvaje";

$conexion = mysqli_connect($HostName, $UserName, $Password, $DataBaseName);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>