<?php
session_start();
include "../php/conexion.php";
if (!isset($_SESSION['datos_login'])) {
  header("Location: ../index.php");
}
$arregloUsuario = $_SESSION['datos_login'];
if ($arregloUsuario['id_cargo'] != 1) {
  header("Location: ../index.php");
}
$resultado = $conexion->query("
  select productos.*, categorias.nombre as catego from 
  productos
  inner join categorias on productos.id_categoria = categorias.id where productos.estado = 1
  order by id DESC") or die($conexion->error);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de Administrador de sistema "La feria del calzado"</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./dashboard/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="./dashboard/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="./dashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="./dashboard/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dashboard/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="./dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="./dashboard/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="./dashboard/plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include "./layouts/header.php"; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Productos</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 text-right">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-plus"></i> Insertar Producto
              </button>

            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <?php
          if (isset($_GET['error'])) {

          ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?php echo $_GET['error']; ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } ?>

          <?php
          if (isset($_GET['success'])) {

          ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Se ha insertado 1 Producto
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } ?>

          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Precio de compra</th>
                <th>Stock</th>
                <th>Categoria</th>
                <th>Color</th>
                <th>estado</th>
                <th>precio de venta</th>
                <th></th>
              </tr>
            </thead>
            <tbody>

              <?php
              while ($f = mysqli_fetch_array($resultado)) {


              ?>
                <tr>
                  <td><?php echo $f['id']; ?></td>
                  <td>
                    <img src="../images/referencia/img_feria/<?php echo $f['imagen']; ?>" width="30px" height="30px" alt="">
                    <?php echo $f['nombre']; ?>
                  </td>
                  <td><?php echo $f['descripcion']; ?></td>
                  <td>$<?php echo number_format($f['precio_compra']); ?></td>
                  <td><?php echo $f['stock']; ?></td>
                  <td><?php echo $f['catego']; ?></td>
                  <td><?php echo $f['color']; ?></td>
                  <td><?php echo $f['estado']; ?></td>
                  <td>$<?php echo number_format($f['precio_venta']); ?></td>
                  <td>
                    <div class="btn-group">
                    <button class="btn btn-sm btn-primary btnEditar" 
                    data-id="<?php echo  $f['id']; ?>" 
                    data-nombre="<?php echo  $f['nombre']; ?>" 
                    data-descripcion="<?php echo  $f['descripcion']; ?>" 
                    data-precio_compra="<?php echo number_format($f['precio_compra']) ; ?>" 
                    data-stock="<?php echo  $f['stock']; ?>" 
                    data-categoria="<?php echo  $f['id_categoria']; ?>" 
                    data-color="<?php echo  $f['color']; ?>" 
                    data-precio_venta="<?php echo number_format($f['precio_venta']) ; ?>" 
                    data-toggle="modal" data-target="#modalEditar">
                      <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm btnEliminar" 
                    data-id="<?php echo  $f['id']; ?>" 
                    data-toggle="modal" data-target="#modalEliminar">
                      <i class="fa fa-trash"></i>
                    </button>
                    <button class="btn btn-success btn-sm btnAddStock" 
                    data-id="<?php echo  $f['id']; ?>" 
                    data-stock="<?php echo  $f['stock']; ?>"
                    data-toggle="modal" data-target="#modalAddStock">
                      <i class="fa fa-plus"> stock</i>
                    </button>
                    </div>
                   
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>

    <!-- Modal Insertar-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="../php/insertarProducto.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Insertar Producto</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" placeholder="NOMBRE" id="nombre" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" placeholder="DESCRIPCIÓN" id="descripcion" class="form-control" required>
              </div>

              <!-- num_calzado-->
              <div id="collapse" class="accordion" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card">
                  <div class="card-header">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse" aria-expanded="true" aria-controls="collapseOne">
                      Ver más
                    </button>

                  </div>
                  
                  <div class="card-body">
                    <div class="form-group">
                      <table class="table" style="width: 100%; border-collapse: collapse; ">
                        <tr>
                          <th>Talla</th>
                          <th>Cantidad</th>
                          <th>Añadir</th>
                        </tr>
                        <tr>
                          <td> 12</td>
                          <td> <input type="number" name="talla_12" id="talla_12" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla12" name="chk_talla12"></td>
                        </tr>
                        <tr>
                          <td> 13</td>
                          <td> <input type="number" name="talla_13" id="talla_13" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla13" name="chk_talla13"></td>
                        </tr>
                        <tr>
                          <td> 14</td>
                          <td> <input type="number" name="talla_14" id="talla_14" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla14" name="chk_talla14"></td>
                        </tr>
                        <tr>
                          <td> 15</td>
                          <td> <input type="number" name="talla_15" id="talla_15" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla15" name="chk_talla15"></td>
                        </tr>
                        <tr>
                          <td> 16</td>
                          <td> <input type="number" name="talla_16" id="talla_16" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla16" name="chk_talla16"></td>
                        </tr>
                        <tr>
                          <td> 17</td>
                          <td> <input type="number" name="talla_17" id="talla_17" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla17" name="chk_talla17"></td>
                        </tr>
                        <tr>
                          <td> 18</td>
                          <td> <input type="number" name="talla_18" id="talla_18" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla18" name="chk_talla18"></td>
                        </tr>
                        <tr>
                          <td> 19</td>
                          <td> <input type="number" name="talla_19" id="talla_19" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla19" name="chk_talla19"></td>
                        </tr>
                        <tr>
                          <td> 20</td>
                          <td> <input type="number" name="talla_20" id="talla_20" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla20" name="chk_talla20"></td>
                        </tr>
                        <tr>
                          <td> 21</td>
                          <td> <input type="number" name="talla_21" id="talla_21" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla21" name="chk_talla21"></td>
                        </tr>
                        <tr>
                          <td> 22</td>
                          <td> <input type="number" name="talla_22" id="talla_22" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla22" name="chk_talla22"></td>
                        </tr>
                        <tr>
                          <td> 23</td>
                          <td> <input type="number" name="talla_23" id="talla_23" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla23" name="chk_talla23"></td>
                        </tr>
                        <tr>
                          <td> 24</td>
                          <td> <input type="number" name="talla_24" id="talla_24" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla24" name="chk_talla24"></td>
                        </tr>
                        <tr>
                          <td> 25</td>
                          <td> <input type="number" name="talla_25" id="talla_25" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla25" name="chk_talla25"></td>
                        </tr>
                        <tr>
                          <td> 26</td>
                          <td> <input type="number" name="talla_26" id="talla_26" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla26" name="chk_talla26"></td>
                        </tr>
                        <tr>
                          <td> 27</td>
                          <td> <input type="number" name="talla_27" id="talla_27" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla27" name="chk_talla27"></td>
                        </tr>
                        <tr>
                          <td> 28</td>
                          <td> <input type="number" name="talla_28" id="talla_28" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla28" name="chk_talla28"></td>
                        </tr>
                        <tr>
                          <td> 29</td>
                          <td> <input type="number" name="talla_29" id="talla_29" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla29" name="chk_talla29"></td>
                        </tr>
                        <tr>
                          <td> 30</td>
                          <td> <input type="number" name="talla_30" id="talla_30" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla30" name="chk_talla30"></td>
                        </tr>
                        <tr>
                          <td> 31</td>
                          <td> <input type="number" name="talla_31" id="talla_31" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla31" name="chk_talla31"></td>
                        </tr>
                        <tr>
                          <td> 32</td>
                          <td> <input type="number" name="talla_32" id="talla_32" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla32" name="chk_talla32"></td>
                        </tr>
                        <tr>
                          <td> 33</td>
                          <td> <input type="number" name="talla_33" id="talla_33" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla33" name="chk_talla33"></td>
                        </tr>
                        <tr>
                          <td> 34</td>
                          <td> <input type="number" name="talla_34" id="talla_34" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla34" name="chk_talla34"></td>
                        </tr>
                        <tr>
                          <td> 35</td>
                          <td> <input type="number" name="talla_35" id="talla_35" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla35" name="chk_talla35"></td>
                        </tr>
                        <tr>
                          <td> 36</td>
                          <td> <input type="number" name="talla_36" id="talla_36" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla36" name="chk_talla36"></td>
                        </tr>
                        <tr>
                          <td> 37</td>
                          <td> <input type="number" name="talla_37" id="talla_37" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla37" name="chk_talla37"></td>
                        </tr>
                        <tr>
                          <td> 38</td>
                          <td> <input type="number" name="talla_38" id="talla_38" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla38" name="chk_talla38"></td>
                        </tr>
                        <tr>
                          <td> 39</td>
                          <td> <input type="number" name="talla_39" id="talla_39" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla39" name="chk_talla39"></td>
                        </tr>
                        <tr>
                          <td> 40</td>
                          <td> <input type="number" name="talla_40" id="talla_40" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla40" name="chk_talla40"></td>
                        </tr>
                        <tr>
                          <td> 41</td>
                          <td> <input type="number" name="talla_41" id="talla_41" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla41" name="chk_talla41"></td>
                        </tr>
                        <tr>
                          <td> 42</td>
                          <td> <input type="number" name="talla_42" id="talla_42" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla42" name="chk_talla42"></td>
                        </tr>
                        <tr>
                          <td> 43</td>
                          <td> <input type="number" name="talla_43" id="talla_43" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla43" name="chk_talla43"></td>
                        </tr>
                        <tr>
                          <td> 44</td>
                          <td> <input type="number" name="talla_44" id="talla_44" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla44" name="chk_talla44"></td>
                        </tr>
                        <tr>
                          <td> 45</td>
                          <td> <input type="number" name="talla_45" id="talla_45" class="form-control"></td>
                          <td> <input type="checkbox" id="chk_talla45" name="chk_talla45"></td>
                        </tr>
                      </table>
                    </div>





                  </div>

                </div>
              </div>
              <!-- FIN num_calzado-->



              <div class="form-group">
                <label for="precio_compra">Precio de compra</label>
                <input type="number" min="0" name="precio_compra" placeholder="Precio de compra" id="precio_compra" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" id="imagen" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="stock">stock</label>
                <input type="number" min="0" name="stock" placeholder="stock" id="stock" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="categoria">Categoria</label>
                <select name="categoria" id="categoria" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from categorias");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="color">Color</label>
                <input type="text" name="color" placeholder="COLOR" id="color" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="estado">Estado</label>
                <input type="number" min="0" name="estado" placeholder="Estado del producto" id="estado" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="precio_venta">Precio de venta</label>
                <input type="number" min="0" name="precio_venta" placeholder="Precio de venta" id="precio_venta" class="form-control" required>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal Insertar-->

    <!-- Modal Eliminar-->
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="modalEliminarLabel">Eliminar Producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            ¿Desea eliminar el producto?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-danger eliminar" data-dismiss="modal">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Eliminar-->

    <!-- Modal Editar-->
    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditar" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="../php/editarProducto.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEditar">Editar Producto</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="idEdit" name="id">

              <div class="form-group">
                <label for="nombreEdit">Nombre</label>
                <input type="text" name="nombre" placeholder="NOMBRE" id="nombreEdit" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="descripcionEdit">Descripcion</label>
                <input type="text" name="descripcion" placeholder="DESCRIPCIÓN" id="descripcionEdit" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="precio_compraEdit">Precio de compra</label>
                <input type="number" min="0" name="precio_compra" placeholder="Precio de compra" id="precio_compraEdit" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" id="imagen" class="form-control">
              </div>

              <div class="form-group">
                <label for="categoriaEdit">Categoria</label>
                <select name="categoria" id="categoriaEdit" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from categorias");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="colorEdit">Color</label>
                <input type="text" name="color" placeholder="COLOR" id="colorEdit" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="precio_ventaEdit">Precio de venta</label>
                <input type="number" min="0" name="precio_venta" placeholder="Precio de venta" id="precio_ventaEdit" class="form-control" required>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary editar">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal Editar-->

    <!-- Modal Insertar STOCK-->
    <div class="modal fade" id="modalAddStock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="../php/addstock.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Actualizar stock</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <input type="hidden" id="idEditStock" name="id">
            <div class="form-group">
                <label for="stockEdit">stock a agregar</label>
                <input type="number" min="0" name="stockEdit" placeholder="stock" id="stockEdit" class="form-control" required>
              </div>

              <div class="form-group">
                
              <label for="stockActual">Stock actual</label>
                <input type="number" id="stockActual" name="stock" class="form-control" disabled>
              </div>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary editarStock">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--FIN Modal Insertar stock-->

    <?php include "./layouts/footer.php"; ?>
  </div>

  <!-- jQuery -->
  <script src="./dashboard/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="./dashboard/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="./dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="./dashboard/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="./dashboard/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="./dashboard/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="./dashboard/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="./dashboard/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="./dashboard/plugins/moment/moment.min.js"></script>
  <script src="./dashboard/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="./dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="./dashboard/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="./dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./dashboard/dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="./dashboard/dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="./dashboard/dist/js/pages/dashboard.js"></script>
  <script>
    $(document).ready(function() {
      var idEliminar = -1;
      var idEditar = -1;
      var fila;
      $(".btnEliminar").click(function() {
        idEliminar = $(this).data('id');
        fila = $(this).parent('td').parent('tr');
      });
      $(".eliminar").click(function() {
        $.ajax({
          url: '../php/eliminarProducto.php',
          method: 'POST',
          data: {
            id: idEliminar
          }
        }).done(function(res) {
          $(fila).fadeOut(1000);
        });
      });
      $(".btnEditar").click(function() {
        idEditar = $(this).data('id');
        var nombre = $(this).data('nombre');
        var descripcion = $(this).data('descripcion');
        var precio_compra = $(this).data('precio_compra');
        var categoria = $(this).data('categoria');
        var color = $(this).data('color');
        var precio_venta = $(this).data('precio_venta');
        $("#nombreEdit").val(nombre);
        $("#descripcionEdit").val(descripcion);
        $("#precio_compraEdit").val(precio_compra);
        $("#categoriaEdit").val(categoria);
        $("#colorEdit").val(color);
        $("#precio_ventaEdit").val(precio_venta);
        $("#idEdit").val(idEditar);
      });
      $(".btnAddStock").click(function(){
        idEditStock=$(this).data('id');
        var stockActual=$(this).data('stock');
        var stockAdd = $(this).data('stockEdit');
        $("#stockActual").val(stockActual);
        $("#stockEdit").val(stockAdd);
        $("#idEditStock").val(idEditStock);
      });
    });
  </script>
</body>

</html>