<?php
    include "./conexion.php";

    if (isset($_POST['nombre']) && isset($_POST['descripcion']) 
    && isset($_POST['precio_compra']) && isset($_POST['stock'])
    && isset($_POST['categoria']) && isset($_POST['color']) 
    && isset($_POST['estado']) && isset($_POST['precio_venta'])) {
        
        $carpeta="../images/referencia/img_feria/";
        $nombre = $_FILES['imagen']['name'];
        //para guardar imagen
        $temp = explode('.',$nombre);
        $extension = end($temp);
        $nombreFinal = time().'.'.$extension;
        if ($extension == 'jpg' || $extension == 'png') {
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta.$nombreFinal)) {
                $conexion->query("insert into productos 
                (nombre, descripcion,precio_compra, imagen, stock, id_categoria, color,estado,precio_venta) values
                (
                    '".$_POST['nombre']."',
                    '".$_POST['descripcion']."',
                    ".$_POST['precio_compra'].",
                    '$nombreFinal',
                    ".$_POST['stock'].",
                    ".$_POST['categoria'].",
                    '".$_POST['color']."',
                    ".$_POST['estado'].",
                    ".$_POST['precio_venta']."
                )
                ")or die($conexion->error);
                
                header("Location: ../admin/productos.php?success");
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