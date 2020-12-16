<?php 
    include "./conexion.php";
    if (isset($_POST['id_proveedor'])) {
        $conexion->query("delete from proveedores where id_proveedor=".$_POST['id_proveedor']);
        echo 'Proveedor eliminado';
    }
    header("Location: ../admin/proveedores.php");
?>