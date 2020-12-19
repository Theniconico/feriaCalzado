<?php 
    include "./conexion.php";

    // $fila = $conexion->query('select imagen from productos where id='.$_POST['id']);
    // $id = mysqli_fetch_row($fila);
    // if (file_exists('../images/'.$id[0])) {
    //     unlink('../images/'.$id[0]);
    // }
    $conexion->query("update productos set
    estado='0'
    where id=".$_POST['id']);
    header("Location: ../admin/proveedores.php");
?>