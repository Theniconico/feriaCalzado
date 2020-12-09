<?php 
include "./conexion.php";
if (isset($_POST['nombre']) && isset($_POST['descripcion'])){
    $conexion->query("update productos set
    stock=");
    }
    header("Location: ../admin/productos.php");
?>