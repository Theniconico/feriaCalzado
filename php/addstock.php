<?php
include "./conexion.php";
$num_calzado = $_POST['calzado'];
$stock = $_POST['stockTotal'];
$conexion->query("delete from num_calzado where id_num =" . $_POST['id']);
$conexion->query("select * from num_calzado");
$values = '';
for ($i = 0; $i < sizeof($num_calzado); $i++) {
    $values .= "(
                '" . $num_calzado[$i] . "',
                '" . $_POST['id'] . "'
       ),";
}
/* echo $values; */
$consulta = "INSERT INTO num_calzado (numeros,producto_fk) VALUES ";
$values = substr($values, 0, -1);
/* echo $values.";"; */
$consulta_final = $consulta . $values . ";";
$conexion->query($consulta_final);
$idultimoInsert=mysqli_insert_id($conexion);
$conexion->query("insert into det_num_calzado (stock,id_productoFK,id_num_calzadoFK) values 
(
    '$stock',
    ". $_POST['id'] .",
    '$idultimoInsert'
)");
$conexion->query("update productos set
    stock='$stock'
    where id=" . $_POST['id']
);
header("Location: ../admin/productos.php?success=stock agregado al producto");
?>