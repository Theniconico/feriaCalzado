<?php 
session_start();
include "./conexion.php";

if(  isset($_POST['email'])  && isset($_POST['password'])   ){
    
    $resultado = $conexion->query("select * from usuario where 
        email='".$_POST['email']."' and 
        password='".sha1($_POST['password'])."' limit 1")or die($conexion->error);
    if(mysqli_num_rows($resultado)>0){
        $datos_usuario = mysqli_fetch_row($resultado); 
        $email = $datos_usuario[1];
        $id_usuario = $datos_usuario[0];
        $img_perfil = $datos_usuario[3];
        $id_cargo = $datos_usuario[8];

        $_SESSION['datos_login']= array(
            'id'=>$id_usuario,
            'email'=>$email,
            'img_perfil'=>$img_perfil,
            'id_cargo'=>$id_cargo
        );
        header("Location: ../admin/");
    }else{
        header("Location: ../login.php?error=Credenciales incorrectas");
        
    }



}else{
    header("../login.php");
}



?>