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
    $conexion->query("insert into movimiento (tipo_movimiento,id_usuario_movimiento,fechahora,observaciones) values
    (
        'Producto eliminado',
        ".$_POST['id_usuario'].",
        now(),
        'Se elimino un producto del sistema'
    )");

    header("Location: ../admin/productos.php");
?>