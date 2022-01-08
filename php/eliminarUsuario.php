<?php 
    include "./conexion.php";
    if (isset($_POST['id'])) {
        $conexion->query("update usuario set
        estado = 0 
        where id=".$_POST['id']);
       header("Location: ../admin/usuarios.php?success=Usuario dado de baja"); 
    }
        
        header("Location: ../admin/usuarios.php");
    
?>