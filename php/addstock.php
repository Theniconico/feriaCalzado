<?php
include "./conexion.php";
$num_calzado = $_POST['calzado'];
$stockCalzado = $_POST['stock'];
$conexion->query("delete from num_calzado where id_num =" . $_POST['id']);
$values = '';
for ($i = 0; $i < sizeof($num_calzado); $i++) {
    $id = $i + 1;

    $values .= "(" . $id . ",
            " . $id  . ",
            '" . $num_calzado[$i] . "',
            '" . $_POST['id'] . "'
       ),";
}
/* echo $values; */
$consulta = "INSERT INTO num_calzado (id, id_num, numeros, producto_fk) VALUES ";
$values = substr($values, 0, -1);
/* echo $values.";"; */
$consulta_final = $consulta . $values . ";";
echo $consulta_final;
$conexion->query($consulta_final);
?>