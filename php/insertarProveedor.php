<?php 
    include "./conexion.php";
    if (isset($_POST['nombre']) && isset($_POST['rut']) && isset($_POST['telefono']) && isset($_POST['direccion'])) {
        $conexion->query("insert into proveedores
        (nombre,rut,telefono,direccion) values
        (
            '".$_POST['nombre']."',
            '".$_POST['rut']."',
            '".$_POST['telefono']."',
            '".$_POST['direccion']."'
        )
        ")or die($conexion->error);
        header("Location: ../admin/proveedores.php?success");
    }else {
        header("Location: ../admin/proveedores.php?error=Favor, llene todos los campos solicitados");
    }
?>