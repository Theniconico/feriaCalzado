<?php 
include "./conexion.php";
if (isset($_POST['stockEdit']) && isset($_POST['stock'])){
    $stockNew = $_POST['stockEdit']+$_POST['stock'];
        $conexion->query("update productos set
        stock=".$stockNew."
        where id=".$_POST['id']."
        ");
        echo "Stock actualizado";
    }
    header("Location: ../admin/productos.php");
?>
<!-- ver k pedo esto-->