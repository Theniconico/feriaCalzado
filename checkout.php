<?php 
  session_start();
  if (!isset($_SESSION['carrito'])) {
    header('Location: ./index.php');
  }
  $arreglo = $_SESSION['carrito'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Compras &mdash;</title>
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
    <form action="./thankyou.php" method="post">
    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-12">
            <div class="border p-4 rounded" role="alert">
              Cliente? <a href="#">Click aquí</a> para logearte
            </div>
          </div>
        </div>
        <!-- formulario registro-->
        <div class="row">
        
          <div class="col-md-6 mb-5 mb-md-0">
            <h2 class="h3 mb-3 text-black">Detalles del envío</h2>
            <div class="p-3 p-lg-5 border">
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="f_nombre" class="text-black">Nombres <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="f_nombre" name="f_nombre">
                </div>
                <div class="col-md-6">
                  <label for="f_apellido" class="text-black">Apellidos <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="f_apellido" name="f_apellido">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <label for="f_direccion" class="text-black">Dirección <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="f_direccion" name="f_direccion" placeholder="">
                </div>
              </div>

              <div class="form-group row mb-5">
                <div class="col-md-6">
                  <label for="f_email" class="text-black">Dirección de correo <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="f_email" name="f_email">
                </div>
                <div class="col-md-6">
                  <label for="f_telefono" class="text-black">teléfono <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="f_telefono" name="f_telefono" placeholder="">
                </div>
              </div>

              <div class="form-group">
                <label for="c_create_account" class="text-black" data-toggle="collapse" href="#create_an_account" role="button" aria-expanded="false" aria-controls="create_an_account"><input type="checkbox" value="1" id="c_create_account"> Quieres crear una cuenta?</label>
                <div class="collapse" id="create_an_account">
                  <div class="py-2">
                    <p class="mb-3">Crear la cuenta de usuario con la información proporcionada.</p>
                    <div class="form-group">
                      <label for="f_rut" class="text-black">Ingresa tu rut</label>
                      <input type="text" class="form-control" id="f_rut" name="f_rut" placeholder="">
                    </div>
                    <div class="form-group">
                      <label for="f_password" class="text-black">Contraseña de la cuenta</label>
                      <input type="password" class="form-control" id="f_password" name="f_password" placeholder="******">
                    </div>
                  </div>
                </div>
              
              </div>
                <!-- fin formulario registro-->

              <div class="form-group">
                <label for="c_ship_different_address" class="text-black" data-toggle="collapse" href="#ship_different_address" role="button" aria-expanded="false" aria-controls="ship_different_address"><input type="checkbox" value="1" id="c_ship_different_address"> Enviar a otra direccion?</label>
                <div class="collapse" id="ship_different_address">
                  <div class="py-2">

                    <div class="form-group row">
                      <div class="col-md-6">
                        <label for="opc_nombre" class="text-black">Nombres <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="opc_nombre" name="opc_nombre">
                      </div>
                      <div class="col-md-6">
                        <label for="opc_apellido" class="text-black">Apellidos <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="opc_apellido" name="opc_apellido">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-12">
                        <label for="opc_direccion" class="text-black">Dirección <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="opc_direccion" name="opc_direccion" placeholder="Dirección / calle">
                      </div>
                    </div>

                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Apartamento, suite, block, etc. (opcional)">
                    </div>

                    <div class="form-group row mb-5">
                      <div class="col-md-6">
                        <label for="opc_email" class="text-black">Dirección de correo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="opc_email" name="opc_email">
                      </div>
                      <div class="col-md-6">
                        <label for="opc_telefono" class="text-black">Teléfono <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="opc_telefono" name="opc_telefono" placeholder="Número de teléfono">
                      </div>
                    </div>

                  </div>

                </div>
              </div>

              <div class="form-group">
                <label for="f_notas" class="text-black">Notas adicionales del pedido</label>
                <textarea name="f_notas" id="f_notas" cols="30" rows="5" class="form-control" placeholder="En caso de que quieras dar una especificación adicional, escribala aquí..."></textarea>
              </div>

            </div>
          </div>
          <div class="col-md-6">

            <div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Código de cupón</h2>
                <div class="p-3 p-lg-5 border">
                  
                  <label for="c_code" class="text-black mb-3">Ingresa el código de cupón, si tienes uno.</label>
                  <div class="input-group w-75">
                    <input type="text" class="form-control" id="c_code" placeholder="Código de cupón" aria-label="Coupon Code" aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-sm" type="button" id="button-addon2">Apply</button>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            
            <div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Tu orden</h2>
                <div class="p-3 p-lg-5 border">
                  <table class="table site-block-order-table mb-5">
                    <thead>
                      <th>Producto</th>
                      <th>Total</th>
                    </thead>
                    <tbody>
                    <?php 
                    $total = 0;
                      for ($i=0; $i < count($arreglo); $i++) { 
                        $total = $total + ($arreglo[$i]['Precio']* $arreglo[$i]['Cantidad']);
                    ?>
                      <tr>
                        <td><?php echo $arreglo[$i]['Nombre']; ?></td>
                        <td>$<?php echo $arreglo[$i]['Precio']; ?></td>
                      </tr>

                      <?php 
                        }
                        ?>
                      <tr>
                        <td>Orden Total</td>
                        <td>$<?php echo $total; ?></td>
                      </tr>
                    </tbody>
                  </table>

                  <div class="border p-3 mb-3">
                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">Datos de banco para transferencias.</a></h3>

                    <div class="collapse" id="collapsebank">
                      <div class="py-2">
                        <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                      </div>
                    </div>
                  </div>

                  <div class="border p-3 mb-3">
                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsecheque" role="button" aria-expanded="false" aria-controls="collapsecheque">Pago con cheque</a></h3>

                    <div class="collapse" id="collapsecheque">
                      <div class="py-2">
                        <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                      </div>
                    </div>
                  </div>

                  <div class="border p-3 mb-5">
                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsepaypal" role="button" aria-expanded="false" aria-controls="collapsepaypal">Paypal</a></h3>

                    <div class="collapse" id="collapsepaypal">
                      <div class="py-2">
                        <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <button class="btn btn-primary btn-lg py-3 btn-block" type="submit" onclick="window.location='thankyou.php'">Finalizar compra</button>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- </form> -->
        
      </div>
    </div>
</form>
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