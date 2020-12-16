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
  select proveedores.* from 
  proveedores order by id_proveedor DESC") or die($conexion->error);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Administrador</title>

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
                            <h1 class="m-0 text-dark">Proveedores</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6 text-right">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus"></i> Insertar Proveedor
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
                            Error al insertar un proveedor
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>

                    <?php
                    if (isset($_GET['success'])) {

                    ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Se ha insertado 1 proveedor
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
                                <th>Rut</th>
                                <th>Telefono</th>
                                <th>Direccion</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            while ($f = mysqli_fetch_array($resultado)) {


                            ?>
                                <tr>
                                    <td><?php echo $f['id_proveedor']; ?></td>
                                    <td><?php echo $f['nombre']; ?></td>
                                    <td><?php echo $f['rut']; ?></td>
                                    <td><?php echo $f['telefono']; ?></td>
                                    <td><?php echo $f['direccion']; ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-primary btnEditar" 
                                            data-id_proveedor="<?php echo  $f['id_proveedor']; ?>" 
                                            data-nombre="<?php echo  $f['nombre']; ?>" 
                                            data-rut="<?php echo  $f['rut']; ?>" 
                                            data-telefono="<?php echo $f['telefono']; ?>" 
                                            data-direccion="<?php echo  $f['direccion']; ?>" 
                                            data-toggle="modal" data-target="#modalEditar">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm btnEliminar" 
                                            data-id_proveedor="<?php echo  $f['id_proveedor']; ?>" 
                                            data-toggle="modal" data-target="#modalEliminar">
                                                <i class="fa fa-trash"></i>
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
                    <form action="../php/insertarProveedor.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Insertar proveedor</h5>
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
                                <label for="rut">Rut</label>
                                <input type="text" name="rut" placeholder="RUT" id="rut" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="telefono">Telefono</label>
                                <input type="tel" name="telefono" placeholder="TELEFONO" id="telefono" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="direccion">Direccion</label>
                                <input type="text" name="direccion" placeholder="DIRECCION" id="direccion" class="form-control" required>
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
                        <h5 class="modal-title" id="modalEliminarLabel">Eliminar proveedor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Desea eliminar el proveedor?
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
                    <form action="../php/editarProveedor.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditar">Editar proveedor</h5>
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
                                <label for="rutEdit">Rut</label>
                                <input type="text" name="rut" placeholder="RUT" id="rutEdit" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="telefonoEdit">Telefono</label>
                                <input type="tel" name="telefono" placeholder="TELEFONO" id="telefonoEdit" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="direccionEdit">Direccion</label>
                                <input type="text" name="direccion" placeholder="DIRECCION" id="direccionEdit" class="form-control" required>
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
    $(document).ready(function(){
        var idEliminar = -1;
        var idEditar = -1;
        var fila;
        $(".btnEliminar").click(function(){
            idEliminar = $(this).data('id_proveedor');
            fila = $(this).parent('td').parent('tr');
        });
        $(".eliminar").click(function(){
            $.ajax({
                url: '../php/eliminarProveedor.php',
                method: 'POST',
                data:{
                    id_proveedor : idEliminar
                }
            }).done(function(res){
                $(fila).fadeOut(1000);
            });
        });
        $(".btnEditar").click(function(){
            idEditar = $(this).data('id_proveedor');
            var nombre = $(this).data('nombre');
            var rut = $(this).data('rut');
            var telefono = $(this).data('telefono');
            var direccion = $(this).data('direccion');

            $("#nombreEdit").val(nombre);
            $("#rutEdit").val(rut);
            $("#telefonoEdit").val(telefono);
            $("#direccionEdit").val(direccion);
        });
    });
    </script>
    
</body>

</html>