<?php
include "conexion.php";
if (isset($_POST['nombre']) && isset($_POST['descripcion']) 
    && isset($_POST['precio_compra']) && isset($_POST['stock'])
    && isset($_POST['categoria']) && isset($_POST['color']) 
    && isset($_POST['estado']) && isset($_POST['precio_venta'])) {


    
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
        }//lave si o esta vacio
    
    $conexion->query("update productos set 
    nombre='".$_POST['nombre']."',
    descripcion='".$_POST['descripcion']."',
    precio_compra=".$_POST['precio_compra'].",
    precio_=".$_POST['precio_compra'].",
    stock=".$_POST['stock'].",
    id_categoria=".$_POST['categoria'].",
    talla='".$_POST['talla']."',
    color='".$_POST['color']."'
    where id=".$_POST['id']);
    echo "Se actualizo";
}
header("Location: ../admin/productos.php");
?>
