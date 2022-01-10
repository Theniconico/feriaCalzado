<?php
include "./conexion.php";
if (isset($_POST['num_calzado']) && isset($_POST['stock'])) {
    if ($_POST['stock'] > 0) {
        $conexion->query("insert into det_num_calzado
        (stock,id_productoFK,id_num_calzadoFK) values
        (
        ". $_POST['stock'] .",
        ".$_POST['idproducto'].",
        ".$_POST['num_calzado']."
        )")or die($conexion->error);
        header("Location: ../admin/productos.php?success=numero de calzado y stock agregado");
    }else {
        echo "la cantidad de stock debe ser mayor a 0";
    }
}else {
    header("Location: ../admin/productos.php?error=Favor, llene todos los campos");
}
?>
