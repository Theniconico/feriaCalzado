<?php
include "conexion.php";
if (isset($_POST['nombre']) && isset($_POST['descripcion']) 
    && isset($_POST['precio_compra'])&& isset($_POST['categoria']) 
    && isset($_POST['color']) && isset($_POST['precio_venta'])
    && isset($_POST['proveedor'])) {


    
        if ($_FILES['imagen']['name'] != '') {
            $carpeta = "../images/referencia/img_feria/";
            $nombre = $_FILES['imagen']['name'];
            $temp = explode('.',$nombre);
            $extension = end($temp);
            $nombreFinal = time().'.'.$extension;
            if ($extension == 'jpg' || $extension == 'png') {
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta.$nombreFinal)) {
                    $fila = $conexion->query('select imagen from productos where id='.$_POST['id']);
                    $id = mysqli_fetch_row($fila);
                    if (file_exists('../images/referencia/img_feria/'.$id[0])) {
                        unlink('../images/referencia/img_feria/'.$id[0]);
                    }
                    $conexion->query("update productos set imagen='".$nombreFinal."' where id=".$_POST['id']);
                }
            }//llave tipo archivo
        } //lave si no esta vacio la entrada de imagen

    $conexion->query("update productos set 
        nombre = '" . $_POST['nombre'] . "',
        descripcion = '" . $_POST['descripcion'] . "',
        precio_compra = " . $_POST['precio_compra'] . ",
        categoriafk = " . $_POST['categoria'] . ",
        proveedorfk= " . $_POST['proveedor'] . ",
        color= '" . $_POST['color'] . "',
        precio_venta= " . $_POST['precio_venta'] . " 
                where id= " . $_POST['id']);
    $conexion->query("insert into movimiento (tipo_movimiento,id_usuario_movimiento,fechaHora,observaciones,id_proveedor) values
        (
            'editar producto',
            '".$_POST['id_user']."',
            now(),
            'se edito datos del producto',
            ".$_POST['proveedor']."
        )");
    $idMovimiento=mysqli_insert_id($conexion);
    $conexion->query("insert into movimiento_detalle (observacion_por_producto,id_movimiento_fk,id_producto_movdetalle) values 
      (
          'Producto editado por correccion de datos',
          '$idMovimiento',
          ".$_POST['id']."
      )");

}
 header("Location: ../admin/productos.php");
?>
