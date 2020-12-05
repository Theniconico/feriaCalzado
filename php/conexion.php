<?php 
    $servidor = "localhost";
    $nombreBd = "feriacalzado";
    $usuario = "root";
    $password = "";
    $conexion = new mysqli($servidor,$usuario,$password,$nombreBd);
    if ($conexion -> connect_error) {
        die("No se pudo conectar");
    }
?>