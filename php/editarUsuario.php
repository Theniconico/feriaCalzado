<?php 
    include "./conexion.php";
    if (isset($_POST['nombre']) && isset($_POST['email']) && 
    isset($_POST['telefono'])) {
        $conexion->query("update usuario set
        nombre='".$_POST['nombre']."',
        email='".$_POST['email']."',
        telefono='".$_POST['telefono']."'
        where id=".$_POST['id']);
        echo "Datos actualizados correctamente";
    }
    header("Location: ../admin/usuarios.php");
?>