<?php 
    include "./conexion.php";
    if (isset($_POST['id'])) {
        $conexion->query("update productos set
        estado = 0 
        where id=".$_POST['id']);
       header("Location: ../admin/productos.php?success=Producto dado de baja"); 
    }
        
        header("Location: ../admin/productos.php");
    
?>