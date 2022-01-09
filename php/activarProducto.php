<?php 
    include "./conexion.php";
    if (isset($_POST['id'])) {
        $conexion->query("update productos set
        estado = 1 
        where id=".$_POST['id']);
       header("Location: ../admin/productos.php?success=Usuario dado de baja"); 
    }
        
        header("Location: ../admin/productos.php");
    
?>