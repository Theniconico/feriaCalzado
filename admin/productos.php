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
//join para mostrar los datos de la tabla productos y categorias por el nombre y no ID 
$resultado = $conexion->query("
  select productos.*, categorias.nombre as catego, proveedores.nombre as nombreProveedor
  from productos
  inner join categorias on productos.categoriaFK = categorias.id
  inner join proveedores on productos.proveedorFK = proveedores.id_proveedor
  order by id DESC") or die($conexion->error);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de Administrador</title>
<!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
  <!-- datatables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>

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
              <?php echo $_GET['success']; ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" header="Location: ../admin/productos.php">&times;</span>
              </button>
            </div>
          <?php } ?>

          <table class="table" id="tableProd">
          <button onclick="window.location='reporte.php'" title="PDF" class="btn btn-sm btn-danger">
                      <i class="fas fa-file-pdf" placeholder="Excel"> Reporte</i>
          </button>
          <br>
          <br>
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio de compra</th>
                <th>Categoria</th>
                <th>Color</th>
                <th>estado</th>
                <th>precio de venta</th>
                <th>Acciones</th>
                <th>Ver tallas</th>
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
                  <td>$<?php echo number_format($f['precio_compra']); ?></td>
                  <td><?php echo $f['catego']; ?></td>
                  <td><?php echo $f['color']; ?></td>
                  <td><?php if ($f['estado'] == 1) {
                        echo 'activo';
                      }else {
                        echo 'inactivo';
                      } ?></td>
                  <td>$<?php echo number_format($f['precio_venta']); ?></td>

                  <td>
                      <!-- Boton editar -->
                    <button title="Editar producto" class="btn btn-sm btn-primary btnEditar" 
                    data-id="<?php echo  $f['id']; ?>" 
                    data-nombre="<?php echo  $f['nombre']; ?>" 
                    data-descripcion="<?php echo  $f['descripcion']; ?>" 
                    data-precio_compra="<?php echo $f['precio_compra']; ?>" 
                    data-categoria="<?php echo  $f['categoriafk']; ?>"
                    data-color="<?php echo  $f['color']; ?>" 
                    data-precio_venta="<?php echo $f['precio_venta']; ?>"
                    data-proveedor="<?php echo $f['proveedorfk']; ?>" 
                    data-toggle="modal" data-target="#modalEditar">
                      <i class="fa fa-edit"></i>
                    </button><!-- Boton editar FIN-->

                    <!-- Boton dar de baja -->
                    <button title="Dar de baja" class="btn btn-danger btn-sm btnEliminar" 
                    data-id="<?php echo  $f['id']; ?>" 
                    data-id_usuario="<?php echo $arregloUsuario['id']; ?>" 
                    data-toggle="modal" data-target="#modalEliminar">
                      <i class="fa fa-trash"></i>
                    </button><!-- Boton dar de baja Fin-->

                    <!-- Boton activar -->
                    <button title="Activar" class="btn btn-success btn-sm btnActivar" 
                    data-id="<?php echo  $f['id']; ?>" 
                    data-id_usuario="<?php echo $arregloUsuario['id']; ?>" 
                    data-toggle="modal" data-target="#modalActivar">
                      <i class="fa fa-check"></i>
                    </button><!-- Boton activar Fin-->

                    <button title="Add talla/stock" class="btn btn-dark btn-sm btnAddStock" 
                    data-id="<?php echo  $f['id']; ?>" 
                    data-toggle="modal" data-target="#modalAddStock">
                      <i class="fa fa-plus"> Stock</i>
                    </button>

                  </td>
                  <td>
                    <button title="Ver tallas disponibles" class="btn btn-info btn-sm btnverNum" 
                    data-id="<?php echo  $f['id']; ?>" 
                    data-toggle="modal" data-target="#modalVerNumeros">
                      <i class="fa fa-eye"></i>
                    </button>
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
                <textarea hidden name="id_usuario" id="id_usuario"><?php echo $arregloUsuario['id']; ?></textarea>
              </div>

              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" placeholder="NOMBRE" id="nombre" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" placeholder="DESCRIPCIÓN" id="descripcion" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="precio_compra">Precio de compra</label>
                <input type="number" min="0" name="precio_compra" placeholder="Precio de compra" id="precio_compra" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="precio_venta">Precio de venta</label>
                <input type="number" min="0" name="precio_venta" placeholder="Precio de venta" id="precio_venta" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="color">Color</label>
                <input type="text" name="color" placeholder="COLOR" id="color" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" id="imagen" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="categoria">Categoria</label>
                <select name="categoria" id="categoria" class="form-control" required>
                  <option  value="">Seleccione una categoria</option>
                  <?php
                  $res = $conexion->query("select * from categorias");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option required value="' . $f['id'] . '" >' . $f['nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="proveedor">Proveedores</label>
                <select name="proveedor" id="proveedor" class="form-control" require>
                  <option  value="">Seleccione un proveedor</option>
                  <?php
                  $res = $conexion->query("select * from proveedores");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option required value="' . $f['id_proveedor'] . '" >' . $f['nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                  <option value="">Seleccione el estado</option>
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
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
        <form action="../php/eliminarProducto.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEliminarLabel">Desactivar producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="center-text form-control" hidden name="id_usuario" id="id_usuario">
            <?php echo $arregloUsuario['id']; ?>
          </div>
          <input type="hidden" id="idDelete" name="id">
          <div class="modal-body">
            ¿Desea dar de baja el producto?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-danger eliminar">Confirmar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal Eliminar-->

    <!-- Modal Activar-->
    <div class="modal fade" id="modalActivar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form action="../php/activarProducto.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEliminarLabel">Activar usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="center-text form-control" hidden name="id_usuario" id="id_usuario">
            <?php echo $arregloUsuario['id']; ?>
          </div>
          <input type="hidden" id="idOn" name="id">
          <div class="modal-body">
            ¿Desea activar usuario?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success activar">Confirmar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal Activar-->

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
              <div class="form-group" hidden>
                <label for="id_userEdit"></label>
                <textarea name="id_user" id="id_userEdit"><?php echo $arregloUsuario['id']; ?></textarea>
              </div>

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
                  <option  value="">Seleccione una categoria</option>
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

              <div class="form-group">
                <label for="proveedorEdit">Proveedores</label>
                <select name="proveedor" id="proveedorEdit" class="form-control" require>
                  <option  value="">Seleccione un proveedor</option>
                  <?php
                  $res = $conexion->query("select * from proveedores");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id_proveedor'] . '" >' . $f['nombre'] . '</option>';
                  }
                  ?>
                </select>
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
              <h5 class="modal-title" id="exampleModalLabel">Insertar numeros de calzado</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="idproducto" name="idproducto">
              <div class="form-group">
                <label for="num_calzado">Numeros de calzado</label>
                <select required name="num_calzado" id="num_calzado" class="form-control" required>
                  <option value="">Seleccione un numero disponible</option>
                  <?php
                  $res = $conexion->query("select * from num_calzado");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option required value="' . $f['id_num'] . '" >' . $f['numeros'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <br>
              <div class="form-group">
                <label for="stock">Stock</label>
                <input required type="number" min="0" name="stock" placeholder="Stock" id="stock" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary addStock">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--FIN Modal Insertar stock-->

    <!-- Modal ver Numeros disponibles-->
    <div class="modal fade" id="modalVerNumeros" tabindex="-1" role="dialog" aria-labelledby="modalVerNumerosLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEliminarLabel">Numeros disponibles</h5>
          </div>
          <div hidden class="center-text form-control" name="id_usuario" id="id_usuario">
            <?php echo $arregloUsuario['id']; ?>
          </div>
          
          <div class="modal-body">
          <table class="table">
                <thead>
                  <tr>
                    <th>Numero</th>
                    <th>stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  <?php  
                  $consulta = $conexion->query("select det_num_calzado.*, num_calzado.numeros as numero from 
                  det_num_calzado
                  inner join num_calzado on det_num_calzado.id_num_calzadoFK = num_calzado.id_num 
                  where id_productoFK = 6")or die($conexion->error);
                  while ($a = mysqli_fetch_array($consulta)) {
                  ?>
                  <td><?php echo $a['numero']?></td>
                  <td><?php echo $a['stock']?></td>
                  <td><?php if ($a['estado'] == 1) {
                        echo 'activo';
                      }else {
                        echo 'inactivo';
                      } ?></td>
                  <td>
                   <!-- Boton add stock -->
                   <button title="Editar stock" class="btn btn-sm btn-primary btnEditarStock" 
                    data-id="<?php echo  $a['id_det']; ?>" 
                    data-nombre="<?php echo  $f['nombre']; ?>"
                    data-toggle="modal" data-target="#modalEditarStock">
                      <i class="fa fa-edit"></i>
                    </button><!-- Boton editar FIN-->

                    <!-- Boton dar de baja -->
                    <button title="Dar de baja" class="btn btn-danger btn-sm btnEliminar" 
                    data-id="<?php echo  $a['id_det']; ?>" 
                    data-id_usuario="<?php echo $arregloUsuario['id']; ?>" 
                    data-toggle="modal" data-target="#modalEliminarStock">
                      <i class="fa fa-trash"></i>
                    </button><!-- Boton dar de baja Fin-->

                    <!-- Boton activar -->
                    <button title="Activar" class="btn btn-success btn-sm btnActivarStock" 
                    data-id="<?php echo  $a['id_det']; ?>"  
                    data-id_usuario="<?php echo $arregloUsuario['id']; ?>" 
                    data-toggle="modal" data-target="#modalActivar">
                      <i class="fa fa-check"></i>
                    </button><!-- Boton activar Fin-->
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal ver Numeros disponibles-->

    <!-- Modal add stock-->
    <div class="modal fade" id="modalEditarStock" tabindex="-1" role="dialog" aria-labelledby="modalEditarStock" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="../php/editarProducto.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEditar">Agregar stock</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="idEdit" name="id">
              <div class="form-group" hidden>
                <label for="id_userEdit"></label>
                <textarea name="id_user" id="id_userEdit"><?php echo $arregloUsuario['id']; ?></textarea>
              </div>

              <div class="form-group">
                <label for="nombreEdit">Numero</label>
                <input type="text" name="nombre" placeholder="NOMBRE" id="nombreEdit" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="descripcionEdit">stock</label>
                <input type="text" name="descripcion" placeholder="DESCRIPCIÓN" id="descripcionEdit" class="form-control" required>
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
    <!--FIN Modal editar stock-->

    <?php include "./layouts/footer.php"; ?>
  </div>
  <!-- datatable -->
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
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
  <script src="./datatables/Buttons-2.1.1"></script>
  <script>
    $(document).ready(function() {
      var idEliminar = -1;
      var idEditar = -1;
      var idUsuario = -1;
      var idProducto_num = -1;
      var idOn = -1;
      var fila;
      $(".btnEliminar").click(function() {
        idEliminar = $(this).data('id');
        idUsuario = $(this).data('id_usuario');
        $("#idDelete").val(idEliminar);
      });
       $(".btnActivar").click(function() {
         idOn = $(this).data('id');
         idUsuario = $(this).data('id_usuario');
         $("#idOn").val(idOn);
       });
      $(".btnEditar").click(function() {
        idEditar = $(this).data('id');
        var nombre = $(this).data('nombre');
        var descripcion = $(this).data('descripcion');
        var precio_compra = $(this).data('precio_compra');
        var categoria = $(this).data('categoria');
        var color = $(this).data('color');
        var precio_venta = $(this).data('precio_venta');
        var proveedor = $(this).data('proveedor');
        $("#nombreEdit").val(nombre);
        $("#descripcionEdit").val(descripcion);
        $("#precio_compraEdit").val(precio_compra);
        $("#categoriaEdit").val(categoria);
        $("#colorEdit").val(color);
        $("#precio_ventaEdit").val(precio_venta);
        $("#idEdit").val(idEditar);
        $("#proveedorEdit").val(proveedor);
      });
      $(".btnAddStock").click(function() {
        idProducto_num = $(this).data('id');
        var stock = $(this).data('stock');
        var num_calzado = $(this).data('num_calzado');
        $("#stock").val(stock);
        $("#idproducto").val(idProducto_num);
        $("#num_calzado").val(num_calzado);
      });
    });
  </script>
</body>

</html>