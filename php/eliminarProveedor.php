<?php 
    include "./conexion.php";

    $conexion->query("delete from proveedores where id_proveedor=".$_POST['id_proveedor']);
    echo 'Proveedor eliminado';
?>