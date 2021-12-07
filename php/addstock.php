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
// $num_calzado = $_POST['calzado'];
// $stock = $_POST['stockTotal'];
// $conexion->query("delete from num_calzado where id_num =" . $_POST['id']);
// $conexion->query("select * from num_calzado");
// $values = '';
// for ($i = 0; $i < sizeof($num_calzado); $i++) {
//     $values .= "(
//                 '" . $num_calzado[$i] . "',
//                 '" . $_POST['id'] . "'
//        ),";
// }
// /* echo $values; */
// $consulta = "INSERT INTO num_calzado (numeros,producto_fk) VALUES ";
// $values = substr($values, 0, -1);
// /* echo $values.";"; */
// $consulta_final = $consulta . $values . ";";
// $conexion->query($consulta_final);
// $idultimoInsert = mysqli_insert_id($conexion);
// $conexion->query("insert into det_num_calzado (stock,id_productoFK,id_num_calzadoFK) values 
// (
//     '$stock',
//     " . $_POST['id'] . ",
//     '$idultimoInsert'
// )");
// $conexion->query(
//     "update productos set
//     stock='$stock'
//     where id=" . $_POST['id']
// );
// header("Location: ../admin/productos.php?success=stock agregado al producto");
