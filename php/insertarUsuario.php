<?php 
    include "./conexion.php";
    if (isset($_POST['nombre']) && isset($_POST['apellidos']) 
    && isset($_POST['email']) && isset($_POST['password']) 
    && isset($_POST['rut']) && isset($_POST['telefono']) 
    && isset($_POST['cargo']) && isset($_POST['estado'])) {
        $password = "";
        $password = $_POST['password'];
        $conexion->query("insert into usuario
        (nombre,email,password,rut,telefono,id_cargo,estado) values
        (
            '" . $_POST['nombre'] . " " . $_POST['apellidos'] . "',
            '".$_POST['email']."',
            '" . sha1($password) . "',
            '".$_POST['rut']."',
            '".$_POST['telefono']."',
            '".$_POST['cargo']."',
            '".$_POST['estado']."'
        )
        ")or die($conexion->error);
        header("Location: ../admin/usuarios.php?success=Usuario creado exitosamente");
    }else {
        header("Location: ../admin/usuarios.php?error=Favor, llene todos los campos solicitados");
    }
?>