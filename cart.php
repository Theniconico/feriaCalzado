<?php 
  session_start();
  include './php/conexion.php';
  if (isset($_SESSION['carrito'])) {
    //si existe, se busca si esta agregado el producto
    if(isset($_GET['id_det'])){
      $arreglo = $_SESSION['carrito'];
      $encontro = false;
      $numero = 0;
      for ($i=0; $i < count($arreglo); $i++) {
        if ($arreglo[$i]['Id'] == $_GET['id_det']) {
          $encontro = true;
          $numero = $i;
        }
      }
      if ($encontro == true) {
        $arreglo[$numero]['Cantidad']=$arreglo[$numero]['Cantidad']+1;
        $_SESSION['carrito'] = $arreglo;
        header('Location: ./cart.php');
      }else{
        //No estaba el registro
        $nombre = "";
        $precio = "";
        $imagen = "";
        $talla = "";
        $id_producto="";
        $resultado = $conexion -> query ('SELECT det_num_calzado.*, num_calzado.numeros as numero, num_calzado.id_num as id_numero,
        productos.nombre as nombreP, productos.descripcion as descripcionP, productos.precio_venta as precio,
        productos.imagen as imagen 
        FROM det_num_calzado
        inner join num_calzado on det_num_calzado.id_num_calzadoFK = num_calzado.id_num
        inner join productos on det_num_calzado.id_productoFK = productos.id
        WHERE id_det='.$_GET['id_det'])or die($conexion -> error);
        $fila = mysqli_fetch_array($resultado);
        $nombre = $fila['nombreP'];
        $precio = $fila['precio'];
        $imagen = $fila['imagen'];
        $talla = $fila['numero'];
        $id_producto = $fila['id_productoFK'];
        $arregloNuevo = array(
                    'Id' => $_GET['id_det'],
                    'Nombre' => $nombre,
                    'Precio' => $precio,
                    'Imagen' => $imagen,
                    'Numero' => $talla,
                    'Id_producto' => $id_producto,
                    'Cantidad' => 1
        );
        array_push($arreglo, $arregloNuevo);
        $_SESSION['carrito'] = $arreglo;
        header('Location: ./cart.php');
      }
    }
  }else{
    //creamos la variable de sesion
    if (isset($_GET['id_det'])) {
      $nombre = "";
      $precio = "";
      $imagen = "";
      $talla = "";
      $id_producto="";
      $resultado = $conexion -> query ('SELECT det_num_calzado.*, num_calzado.numeros as numero, num_calzado.id_num as id_numero,
      productos.nombre as nombreP, productos.descripcion as descripcionP, productos.precio_venta as precio,
      productos.imagen as imagen 
      FROM det_num_calzado
      inner join num_calzado on det_num_calzado.id_num_calzadoFK = num_calzado.id_num
      inner join productos on det_num_calzado.id_productoFK = productos.id
      WHERE id_det='.$_GET['id_det'])or die($conexion -> error);
      $fila = mysqli_fetch_array($resultado);
      $nombre = $fila['nombreP'];
      $precio = $fila['precio'];
      $imagen = $fila['imagen'];
      $talla = $fila['numero'];
      $id_producto = $fila['id_productoFK'];
      $arreglo[] = array(
                  'Id' => $_GET['id_det'],
                  'Nombre' => $nombre,
                  'Precio' => $precio,
                  'Imagen' => $imagen,
                  'Numero' => $talla,
                  'Id_producto' => $id_producto,
                  'Cantidad' => 1
      );
      $_SESSION['carrito'] = $arreglo;
      header('Location: ./cart.php');
    }
  }
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Tienda </title>
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
        <div class="row mb-5">
          <form class="col-md-12" method="post">
          <!-- tabla de producto en el carro -->
            <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Imagen</th>
                    <th class="product-name">Producto</th>
                    <th class="product-price">Precio</th>
                    <th class="product-price">Talla</th>
                    <th class="product-quantity">Cantidad</th>
                    <th class="product-total">Total</th>
                    <th class="product-remove">Quitar</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $total = 0;
                  if(isset($_SESSION['carrito'])){
                    $arregloCarrito = $_SESSION['carrito'];
                    for($i = 0; $i<count($arregloCarrito); $i++){
                      $total = $total + ($arregloCarrito[$i]['Precio'] * $arregloCarrito[$i]['Cantidad']);
                ?>
                  <tr>
                    <td class="product-thumbnail">
                      <img src="images/referencia/img_feria/<?php echo $arregloCarrito[$i]['Imagen'];?>" alt="Image" class="img-fluid">
                    </td>
                    <td class="product-name">
                      <h2 class="h5 text-black"><?php echo $arregloCarrito[$i]['Nombre'];?></h2>
                    </td>
                    <td>$<?php echo $arregloCarrito[$i]['Precio'];?></td>
                    <td><?php echo $arregloCarrito[$i]['Numero'];?></td>
                    <td>
                      <div class="input-group mb-3" style="max-width: 120px;">
                        <div class="input-group-prepend">
                          <button class="btn btn-outline-primary js-btn-minus btnIncrementar" type="button">&minus;</button>
                        </div>
                        <input type="text" class="form-control text-center txtCantidad" 
                        data-precio="<?php echo $arregloCarrito[$i]['Precio'];?>"
                        data-id= "<?php echo $arregloCarrito[$i]['Id'];?>"
                        value="<?php echo $arregloCarrito[$i]['Cantidad'];?>" 
                        placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <div class="input-group-append">
                          <button class="btn btn-outline-primary js-btn-plus btnIncrementar" type="button">&plus;</button>
                        </div>
                      </div>

                    </td>
                    <td class="cant<?php echo $arregloCarrito[$i]['Id'];?>">
                    $<?php echo $arregloCarrito[$i]['Precio'] * $arregloCarrito[$i]['Cantidad'];?></td>
                    <td><a href="#" class="btn btn-primary btn-sm btnEliminar" data-id="<?php echo $arregloCarrito[$i]['Id'];?>">X</a></td>
                  </tr>
                  <?php } }?>
                 
                </tbody>
              </table>
              <!-- fin de tabla --> 
            </div>
          </form>
        </div>
          <!-- total a pagar-->
        <div class="row">
          <div class="col-md-6">
            <div class="row mb-5">
              <div class="col-md-6 mb-3 mb-md-0">
                <button onclick="window.location='cart.php'" class="btn btn-primary btn-sm btn-block">Actualizar Carrito</button>
              </div>
              <div class="col-md-6">
                <button onclick="window.location='index.php'" class="btn btn-outline-primary btn-sm btn-block">Continue Comprando</button>
              </div>
            </div>
          </div>
          <div class="col-md-6 pl-5">
            <div class="row justify-content-end">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-12 text-right border-bottom mb-5">
                    <h3 class="text-black h4 text-uppercase">Total en carro</h3>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <span class="text-black">Subtotal</span>
                  </div>
                  <div class="col-md-6 text-right">
                    <strong class="text-black">$<?php echo $total; ?></strong>
                  </div>
                </div>
                <div class="row mb-5">
                  <div class="col-md-6">
                    <span class="text-black">Total</span>
                  </div>
                  <div class="col-md-6 text-right">
                    <strong class="text-black">$<?php echo $total; ?></strong>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-primary btn-lg py-3 btn-block" onclick="window.location='checkout.php'">Continuar al pago</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
                  <!--FIN total a pagar-->
      </div>
    </div>

    <?php include("./layouts/footer.php"); ?> 
  </div>

<!--FIN tabla de producto en el carro -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
  <script>
    $(document).ready(function () {
      $(".btnEliminar").click(function(event){
        event.preventDefault();
        var id = $(this).data('id');
        var boton = $(this);
        $.ajax({
          method: 'POST',
          url: './php/eliminarCarrito.php',
          data:{
            id:id
          }
        }).done(function(respuesta){
          boton.parent('td').parent('tr').remove();
        });
      });
      $(".txtCantidad").keyup(function() {
        var cantidad = $(this).val();
        var precio = $(this).data('precio');
        var id = $(this).data('id');
        incrementar(cantidad, precio, id);
      });
      $(".btnIncrementar").click(function(){
        var precio = $(this).parent('div').parent('div').find('input').data('precio');
        var id = $(this).parent('div').parent('div').find('input').data('id');
        var cantidad = $(this).parent('div').parent('div').find('input').val();
        incrementar(cantidad, precio, id);
      });
      function incrementar(cantidad, precio, id){
        var mult = parseFloat(cantidad) * parseFloat(precio);
        $(".cant"+id).text("$"+mult);
        $.ajax({
          method: 'POST',
          url: './php/actualizar.php',
          data:{
            id:id,
            cantidad:cantidad
          }
        }).done(function(respuesta){
          
        });
      }
    });
  </script>


  </body>
</html>