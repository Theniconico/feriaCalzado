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
        ".$arregloUsuario['id'].",
        now(),
        'Se elimino un producto del sistema'
    )")or die($conexion->error);

    header("Location: ../admin/proveedores.php");
?>