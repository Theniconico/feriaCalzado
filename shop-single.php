<?php 
session_start();
include('./php/conexion.php');
  if (isset($_GET['id_det'])) {
    $resultado = $conexion -> query ('SELECT det_num_calzado.*, num_calzado.numeros as numero, num_calzado.id_num as id_numero,
    productos.nombre as nombreP, productos.descripcion as descripcionP, productos.precio_venta as precio,
    productos.imagen as imagen 
    FROM det_num_calzado
    inner join num_calzado on det_num_calzado.id_num_calzadoFK = num_calzado.id_num
    inner join productos on det_num_calzado.id_productoFK = productos.id
    WHERE id_det='.$_GET['id_det'])or die($conexion -> error);
    if (mysqli_num_rows($resultado) > 0) {
      $fila = mysqli_fetch_array($resultado);
    }else{
      header('Location: ./index.php');
    }
  }else{
    //redireccionar
    header('Location: ./index.php');
  }
?>

<!DOCTYPE html>
<html lang="es">
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
          <div class="col-md-5">
            <img src="images/referencia/img_feria/<?php echo $fila['imagen'];?>" alt="<?php echo $fila['nombreP'];?>" class="img-fluid"><!--llama a dato por la posicion en el arreglo de la bd -->
          </div>
          <div class="col-md-4">
            <h2 class="text-black"><?php echo $fila['nombreP'];?></h2>
            <p><?php echo $fila['descripcionP'];?></p>
            <h5 class="text-black">Talla: <?php echo $fila['numero'];?></h5>
            <h5 class="text-black">Stock: <?php echo $fila['stock'];?></h5>
            <h5 hidden class="text-black">id_numero: <?php echo $fila['id_numero'];?></h5>
            <p><strong class="text-primary h4">$<?php echo $fila['precio'];?></strong></p>
              <br>
              <div class="mb-5">
              <div class="input-group mb-3" style="max-width: 120px;">
              <div class="input-group-prepend">
                <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
              </div>
              <input type="text" class="form-control text-center" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
              <div class="input-group-append">
                <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
              </div>
            </div>
            </div>
            <p><a href="cart.php?id_det=<?php echo $fila['id_det'];?>"class="buy-now btn btn-sm btn-primary">Agregar al carro</a></p>

          </div>
        </div>
      </div>
    </div>

    <div class="site-section block-3 site-blocks-2 bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 site-section-heading text-center pt-4">
            <h2>Productos destacados</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="nonloop-block-3 owl-carousel">
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/cloth_1.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Ranking top</a></h3>
                    <p class="mb-0">Encuentra tu producto perfecto</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/shoe_1.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Zapatos de fiesta</a></h3>
                    <p class="mb-0">Encuentra tus favoritas</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/cloth_2.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Zapatillas</a></h3>
                    <p class="mb-0">Encuentra tus favoritas</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/cloth_3.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Sanfalias</a></h3>
                    <p class="mb-0">Encuentra tus favoritas</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/shoe_1.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Corater</a></h3>
                    <p class="mb-0">Finding perfect products</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
            </div>
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