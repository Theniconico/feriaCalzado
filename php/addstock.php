<?php 
include "./conexion.php";
        $num_calzado = $_POST['calzado'];
        $stockCalzado = $_POST['stock'];
        $conexion->query("delete from num_calzado where id_num =".$_POST['id']);

        for ($i=0; $i < sizeof($num_calzado); $i++) {
            $id = $i+1;
            $aux = "insert into num_calzado values(
                ".$id.",
                 ".$_POST['id'].",
                 '".$num_calzado[$i]."'
            ),";
             $conexion->query($aux);
            // echo "insert into num_calzado values(
            //     ".$id.",
            //     ".$_POST['id'].",
            //     '".$num_calzado[$i]."'
            // )<br>";
        }
        
    //   header("Location: ../admin/productos.php");
?>
