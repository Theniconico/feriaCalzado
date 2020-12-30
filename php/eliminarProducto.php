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
        'eliminar producto',
        ".$_POST['id_usuario'].",
        now(),
        'Se elimino un producto del sistema'
    )");
     $idMovimiento=mysqli_insert_id($conexion);
      $conexion->query("insert into movimiento_detalle (cantidad,observacion_por_producto,id_movimiento_fk,id_producto_movdetalle) values 
      (
          '0',
          'Producto eliminado del sistema por no uso o sin stock',
          '$idMovimiento',
          ".$_POST['id']."
      )");

     header("Location: ../admin/productos.php");
?>