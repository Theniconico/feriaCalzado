<?php
session_start();
include './php/conexion.php';
if (!isset($_SESSION['carrito'])) {
  header("Location: ./index.php");
}
$arreglo = $_SESSION['carrito'];
$total = 0;
for ($i = 0; $i < count($arreglo); $i++) {
  $total = $total + ($arreglo[$i]['Precio'] * $arreglo[$i]['Cantidad']);
}
$password = "";
if (isset($_POST['f_password'])) {
  if ($_POST['f_password'] != "") {
    $password = $_POST['f_password'];
  }
}
$conexion->query("INSERT INTO usuario (email,password,img_perfil,rut,nombre,estado,telefono,id_cargo) 
     values(
      '" . $_POST['f_email'] . "',
      '" . sha1($password) . "',
      'men.jpg',
      '" . $_POST['f_rut'] . "',
       '" . $_POST['f_nombre'] . " " . $_POST['f_apellido'] . "',
       1,
       '" . $_POST['f_telefono'] . "',
        2
           )
     ") or die($conexion->error);
$id_usuario = $conexion->insert_id;

$fecha = date('Y-m-d h:m:s');
$conexion->query("INSERT INTO pago(usuarioFK,medio_pago,total,fecha) VALUES($id_usuario,'efectivo',$total,'$fecha')") or die($conexion->error);
$pagoFK = $conexion->insert_id;

for ($i = 0; $i < count($arreglo); $i++) {
  $conexion->query("INSERT INTO detalle_pedido (productoFK, FKpago, cantidad, precio, subtotal)
     values(
       " . $arreglo[$i]['Id_producto'] . ",
       $pagoFK, 
       " . $arreglo[$i]['Cantidad'] . ",
       " . $arreglo[$i]['Precio'] . ",
       " . $arreglo[$i]['Cantidad'] * $arreglo[$i]['Precio'] . "
       )") or die($conexion->error);
    $conexion->query("UPDATE det_num_calzado SET stock = stock-".$arreglo[$i]['Cantidad']." WHERE id_det=".$arreglo[$i]['Id'])or die($conexion->error);
}

 $conexion->query("INSERT INTO pedido(pagoFK,direccion,ciudad,fecha) values
 (
  $pagoFK,
  '" . $_POST['f_direccion'] . "',
  '" . $_POST['f_ciudad'] . "',
   '$fecha'
 )
 ")or die($conexion->error);
// include "./php/mail.php";
unset($_SESSION['carrito']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tienda</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <div class="site-wrap">
    <?php include("./layouts/header.php"); ?>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <span class="icon-check_circle display-3 text-success"></span>
            <h2 class="display-3 text-black">Gracias!</h2>
            <p class="lead mb-5">Tu orden se ha completado con éxito.</p>
            <p><a href="verpedido.php?pagoFK=<?php echo $pagoFK; ?>" class="btn btn-sm btn-primary">Ver pedido</a></p>
          </div>
        </div>
      </div>
    </div>

    <?php include("./layouts/footer.php"); ?>

  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>

</body>

</html>