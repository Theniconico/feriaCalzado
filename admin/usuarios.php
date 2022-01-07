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
  select usuario.*, cargo.nombre_cargo as cargo 
  from usuario
  inner join cargo on cargo.id_cargo = usuario.id_cargo
  where usuario.id_cargo != 1
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
              <h1 class="m-0 text-dark">USUARIOS</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 text-right">
              <!-- Button trigger modal -->
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

          <table class="table">
          <button title="Excel" class="btn btn-sm btn-success" extends="excelHtml5">
                      <i class="fas fa-file-excel"></i>
          </button>
          <button title="PDF" extends="pdfHtml5" class="btn btn-sm btn-danger">
                      <i class="fas fa-file-pdf" placeholder="Excel"></i>
          </button>
          <button title="PRINT" extends="print" class="btn btn-sm btn-info">
                      <i class="fas fa-print" placeholder="Excel"></i>
          </button>
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>EMAIL</th>
                <th>RUT</th>
                <th>ESTADO</th>
                <th>TELEFONO</th>
                <th>CARGO</th>
                <th>ACCIONES</th>
              </tr>
            </thead>
            <tbody>

              <?php
              while ($f = mysqli_fetch_array($resultado)) {
              ?>
                <tr>
                  <td><?php echo $f['id']; ?></td>
                  <td>
                    <?php echo $f['nombre']; ?>
                  </td>
                  <td><?php echo $f['email']; ?></td>
                  <td><?php echo $f['rut']; ?></td>
                  <td><?php if ($f['estado'] == 1) {
                        echo 'activo';
                      } ?></td>
                    <td><?php echo $f['telefono']; ?></td>
                    <td><?php echo $f['cargo']; ?></td>
                    <td>
                      <!-- Boton editar -->
                    <button class="btn btn-sm btn-primary btnEditar" 
                    data-id="<?php echo  $f['id']; ?>" 
                    data-nombre="<?php echo  $f['nombre']; ?>"
                    data-email="<?php echo  $f['email']; ?>"
                    data-telefono="<?php echo  $f['telefono']; ?>"
                    data-toggle="modal" data-target="#modalEditar">
                      <i class="fa fa-edit"></i>
                    </button><!-- Boton editar FIN-->

                    <!-- Boton dar de baja -->
                    <button class="btn btn-danger btn-sm btnEliminar" 
                    data-id="<?php echo  $f['id']; ?>" 
                    data-id_usuario="<?php echo $arregloUsuario['id']; ?>" 
                    data-toggle="modal" data-target="#modalEliminar">
                      <i class="fa fa-trash"></i>
                    </button><!-- Boton dar de baja Fin-->

                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
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
          <div class="center-text form-control" hidden name="id_usuario" id="id_usuario">
            <?php echo $arregloUsuario['id']; ?>
          </div>
          <div class="modal-body">
            ¿Desea dar de baja al usuario?
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
          <form action="../php/editarUsuario.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEditar">Editar datos usuario</h5>
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
                <input type="text" name="nombre" placeholder="Nombre" id="nombreEdit" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="emailEdit">Email</label>
                <input type="text" name="email" placeholder="Email" id="emailEdit" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="telefonoEdit">Telefono</label>
                <input type="text" min="0" name="telefono" placeholder="Telefono" id="telefonoEdit" class="form-control" required>
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
      var fila;
      $(".btnEliminar").click(function() {
        idEliminar = $(this).data('id');
        idUsuario = $(this).data('id_usuario');
        fila = $(this).parent('td').parent('tr');
      });
      $(".eliminar").click(function() {
        $.ajax({
          url: '../php/eliminarUsuario.php',
          method: 'POST',
          data: {
            id: idEliminar,
            id_usuario: idUsuario
          }
        }).done(function(res) {
          $(fila).fadeOut(1000);
        });
      });
      $(".btnEditar").click(function() {
        idEditar = $(this).data('id');
        var nombre = $(this).data('nombre');
        var email = $(this).data('email');
        var telefono = $(this).data('telefono');
        $("#nombreEdit").val(nombre);
        $("#emailEdit").val(email);
        $("#telefonoEdit").val(telefono);
        $("#idEdit").val(idEditar);
      });
    });
  </script>