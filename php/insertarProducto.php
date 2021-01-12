<?php
    include "./conexion.php";

    if (isset($_POST['nombre']) && isset($_POST['descripcion']) 
    && isset($_POST['precio_compra'])&& isset($_POST['categoria']) 
    && isset($_POST['color']) && isset($_POST['estado']) 
    && isset($_POST['precio_venta'])) {
        
        $carpeta="../images/referencia/img_feria/";
        $nombre = $_FILES['imagen']['name'];
        //para guardar imagen
        $temp = explode('.',$nombre);
        $extension = end($temp);
        $nombreFinal = time().'.'.$extension;
        if ($extension == 'jpg' || $extension == 'png') {
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta.$nombreFinal)) {
                $conexion->query("insert into productos 
                (nombre, descripcion,precio_compra, imagen, id_categoria, color,estado,precio_venta) values
                (
                    '".$_POST['nombre']."',
                    '".$_POST['descripcion']."',
                    ".$_POST['precio_compra'].",
                    '$nombreFinal',
                    ".$_POST['categoria'].",
                    '".$_POST['color']."',
                    ".$_POST['estado'].",
                    ".$_POST['precio_venta']."
                )
                ");
                $idProd = mysqli_insert_id($conexion);
                $conexion->query("insert into movimiento (tipo_movimiento,id_usuario_movimiento,fechaHora,observaciones,id_proveedor) values
                (
                     'insertar producto',
                     '".$_POST['id_usuario']."',
                     now(),
                     'se inserto un producto',
                     ".$_POST['proveedor']."
                 )");
                $idMovimiento=mysqli_insert_id($conexion);
                $conexion->query("insert into movimiento_detalle (cantidad,observacion_por_producto,id_movimiento_fk,id_producto_movdetalle) values 
                    (
                        '0',
                        'Producto insertado en los registros',
                        '$idMovimiento',
                        '$idProd'
                    )");
                
                header("Location: ../admin/productos.php?success=producto agregado");
            
            }else {
                header("Location: ../admin/productos.php?error=No se pudo subir la imagen");
            }
        }else{
            header("Location: ../admin/productos.php?error=Favor, suba una imagen con un formato valido");
        }
    }else {
        header("Location: ../admin/productos.php?error=Favor, llene todos los campos");

    }
?>