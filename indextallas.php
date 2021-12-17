<!-- <?php 
include('./php/conexion.php');
  if (isset($_GET['id'])) {
    $resultado = $conexion -> query ('SELECT * FROM productos WHERE id='.$_GET['id'])or die($conexion -> error);
    if (mysqli_num_rows($resultado) > 0) {
      $fila = mysqli_fetch_row($resultado);
    }else{
      header('Location: ./index.php');
    }
  }else{
    //redireccionar
    header('Location: ./index.php');
  }
?> -->
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

        <div class="row mb-5">
          <div class="col-md-9 order-2">
          <!-- Producto -->
            <div class="row mb-5">
              <?php
                include('./php/conexion.php');
                $limite = 20;//productos por pagina
                $totalQuery = $conexion->query("SELECT count(*) FROM det_num_calzado where id_productoFK =".$_GET['id'])or die($conexion->error);
                $totalProductos = mysqli_fetch_row($totalQuery);
                $totalBotones = round($totalProductos[0] / $limite);
                if (isset($_GET['limite'])) {
                  $resultado = $conexion -> query("SELECT det_num_calzado.*, num_calzado.numeros as numero,
                  productos.nombre as nombreP, productos.imagen as imagenP
                  FROM det_num_calzado 
                  inner join num_calzado on det_num_calzado.id_num_calzadoFK = num_calzado.id_num
                  inner join productos on det_num_calzado.id_productoFK = productos.id
                  WHERE id_productoFK =".$_GET['id']." LIMIT ".$_GET['limite'].",".$limite) or die($conexion -> error);
                }else {
                  $resultado = $conexion -> query("SELECT det_num_calzado.*, num_calzado.numeros as numero,
                  productos.nombre as nombreP, productos.imagen as imagenP
                  FROM det_num_calzado 
                  inner join num_calzado on det_num_calzado.id_num_calzadoFK = num_calzado.id_num
                  inner join productos on det_num_calzado.id_productoFK = productos.id 
                  WHERE id_productoFK =".$_GET['id']." LIMIT ".$limite) or die($conexion -> error);
                }
                while ($fila = mysqli_fetch_array($resultado)) {
                  
                
              ?>
              <div class="col-sm-3 col-lg-3 mb-3" data-aos="fade-up">
                <div class="block-4 text-center border">
                <figure class="block-4-image">
                    <a href="shop-single.php?id_det=<?php echo $fila['id_det'];?>">
                    <img src="images/referencia/img_feria/<?php echo $fila['imagenP'];?>" class="img-fluid" alt=""></a>
                  </figure>
                  <div class="">
                    <h4 class="mb-0"><strong class="black"><?php echo $fila['nombreP'] ;?></strong></h4>
                    <p class="mb-0">Talla: <?php echo $fila['numero'] ;?></p>
                    <p class="mb-0">Stock: <?php echo $fila['stock'] ;?></p>
                  </div>
                </div>
              </div>
                <?php }?>
           
            </div>
            <!-- Fin Producto -->
            <div class="row" data-aos="fade-up">
              <div class="col-md-12 text-center">
                <div class="site-block-27">
                  <ul>
                    <?php
                    if (isset($_GET['limite'])) {
                      if ($_GET['limite'] > 0) {
                        echo '<li><a href="indextallas.php?limite='.($_GET['limite'] - 10).'">&lt;</a></li>';
                      }
                    }
                      for ($k=0; $k < $totalBotones; $k++) { 
                        echo '<li><a href="indextallas.php?limite='.($k*10).'">'.($k+1).'</a></li>';
                      }
                      if (isset($_GET['limite'])) {
                          if ($_GET['limite']+10 < $totalBotones*10) {
                            echo '<li><a href="indextallas.php?limite='.($_GET['limite']+10).'">&gt;</a></li>';
                          }
                      }else {
                        echo '<li><a href="indextallas.php?limite=10">&gt;</a></li>';
                      }
                    ?>
                    
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-3 order-1 mb-5 mb-md-0">
            <div class="border p-4 rounded mb-4">
              <h3 class="mb-3 h6 text-uppercase text-black d-block">Categorias</h3>
              <ul class="list-unstyled mb-0">
               <?php 
               $re = $conexion ->query("select * from categorias");
               while($f =mysqli_fetch_array($re)){

               
                
               ?>
               <li class="mb-1">
                 <a href="./busqueda.php?texto=<?php echo $f['nombre']?>" class="d-flex">
                 <span><?php echo$f['nombre']?></span> 
                 <span class="text-black ml-auto"><?php
                 $re2 = $conexion -> query("select count(*) from productos where categoriafk = ".$f['id']);
                 $fila = mysqli_fetch_row($re2);
                 echo $fila[0];
                 ?></span>
                 </a>
               </li>
            


               <?php }?> 
            </ul>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="site-section site-blocks-2">
                <div class="row justify-content-center text-center mb-5">
                  <div class="col-md-7 site-section-heading pt-4">
                    <h2>Categorias</h2>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/women.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Colecciones</span>
                        <h3>Mujer</h3>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/children.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Colecciones</span>
                        <h3>Niños</h3>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/men.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Colecciones</span>
                        <h3>Hombre</h3>
                      </div>
                    </a>
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