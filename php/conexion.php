<?php 
    $servidor = "localhost";
    $nombreBd = "feria2";
    $usuario = "root";
    $password = "";
    $conexion = new mysqli($servidor,$usuario,$password,$nombreBd);
    if ($conexion -> connect_error) {
        die("No se pudo conectar");
    }
?>