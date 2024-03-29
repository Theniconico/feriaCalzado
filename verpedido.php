<?php
    include './php/conexion.php';
    if (!isset($_GET['id_pago'])) {
        header("Location: ./");

    }
    $datos = $conexion->query("SELECT detalle_pedido.*, productos.nombre as nombreP, 
    productos.imagen as imagenP, productos.color as colorP, 
    pago.medio_pago as medio_pago, pago.total as total, pago.fecha as fecha 
    from detalle_pedido
    inner join productos on detalle_pedido.productoFK = productos.id
    inner join pago on detalle_pedido.FKpago = pago.id_pago
    WHERE FKpago=".$_GET['id_pago'])or die($conexion->error);
    
     $datos2 = $conexion -> query("SELECT pago.*, usuario.telefono as telefono, usuario.nombre as nombreUser 
     FROM pago
     inner join usuario on pago.usuarioFK = usuario.id 
     WHERE id_pago=".$_GET['id_pago'])or die($conexion->error);
     $datospago = mysqli_fetch_array($datos2);

     $datos3 = $conexion -> query("SELECT pedido.* FROM pedido WHERE pagoFK=".$_GET['id_pago'])or die($conexion->error);
     $datosPedido = mysqli_fetch_array($datos3);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Feria del calzado</title>
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
          <div class="col-md-12">
            <h2 class="h3 mb-3 text-black">Mantengamonos en contacto</h2>
          </div>
          <div class="col-md-7">

            <form action="#" method="post">
              
              <div class="p-3 p-lg-5 border">

                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="c_fname" class="text-black">Venta #<?php echo $_GET['id_pago']; ?></label>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="c_fname" class="text-black">Nombre <?php echo $datospago['nombreUser']; ?></label>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="c_fname" class="text-black">Telefono <?php echo $datospago['telefono']; ?></label>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="c_fname" class="text-black">Direccion <?php echo $datosPedido['direccion']; ?></label>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="c_fname" class="text-black">Ciudad <?php echo $datosPedido['ciudad']; ?></label>
                  </div>
                </div>

              </div>
            </form>
          </div>
          <div class="col-md-5 ml-auto">
              <?php 
                while ($f = mysqli_fetch_array($datos)) {
                    
                
              ?>
            <div class="p-4 border mb-3">
                <img src="./images/referencia/img_feria/<?php echo $f['imagenP'];?>" width="50px">
              <span class="d-block text-primary h6 text-uppercase"><?php echo $f['nombreP'];?></span><br>
              <span class="d-block text-primary h6 text-uppercase">Cantidad: <?php echo $f['cantidad'];?></span>
              <span class="d-block text-primary h6 text-uppercase">Precio: <?php echo $f['precio'];?></span>
              <span class="d-block text-primary h6 text-uppercase">Subtotal: <?php echo $f['subtotal'];?></span>
            </div>
             
                <?php }?>
                   <h4>Total: <?php echo $datospago['total'];?></h4>
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