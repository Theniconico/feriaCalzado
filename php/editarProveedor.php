<?php 
    include "./conexion.php";
    if (isset($_POST['nombre']) && isset($_POST['rut']) && isset($_POST['telefono']) && isset($_POST['direccion'])) {
        $conexion->query("update proveedores set
        nombre='".$_POST['nombre']."',
        rut='".$_POST['rut']."',
        telefono='".$_POST['telefono']."',
        direccion='".$_POST['direccion']."'
        where id_proveedor=".$_POST['id_proveedor']);
        echo "Datos actualizados correctamente";
    }
    header("Location: ../admin/proveedores.php");
?>