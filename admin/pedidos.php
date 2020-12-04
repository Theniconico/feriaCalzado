<?php
session_start();
include "../php/conexion.php";
if (!isset($_SESSION['datos_login'])) {
    header("Location: ../index.php");
}
$arregloUsuario = $_SESSION['datos_login'];
if ($arregloUsuario['nivel'] != 'admin') {
    header("Location: ../index.php");
}
$resultado = $conexion->query("
select ventas.*, usuario.nombre, usuario.telefono, usuario.email from ventas
inner join usuario on ventas.id_usuario = usuario.id

") or die($conexion->error);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PEDIDOS</title>

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
                            <h1 class="m-0 text-dark">Pedidos</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6 text-right">

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

                    <!-- collapse -->
                    <div id="accordionExample" class="accordion">
                        <?php
                        while ($f = mysqli_fetch_array($resultado)) {


                        ?>
                            <div class="card">
                                <div class="card-header" id="heading<?php echo $f['id']; ?>">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $f['id']; ?>" aria-expanded="true" aria-controls="collapseOne">
                                            <?php echo $f['fecha'] . ' - ' . $f['nombre']; ?>
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapse<?php echo $f['id']; ?>" class="collapse" aria-labelledby="heading<?php echo $f['id']; ?>" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p><strong>Datos del Cliente</strong></p>
                                        <p>Nombre cliente: <?php echo $f['nombre']; ?></p>
                                        <p>Correo cliente: <?php echo $f['email']; ?></p>
                                        <p>Telefono cliente: <?php echo $f['telefono']; ?></p>
                                        <p>Status pedido: <strong><?php echo $f['status']; ?></strong></p>
                                        <p class="h6"><strong>Datos de envio</strong></p>
                                        <?php
                                        $re = $conexion->query("select * from envios where id_venta=" . $f['id']) or die($conexion->error);
                                        $fila = mysqli_fetch_row($re);
                                        ?>
                                        <p>Direccion cliente: <?php echo $fila[3]; ?></p>
                                        <p>Estado cliente: <?php echo $fila[4]; ?></p>
                                        <p>Codigo postal: <?php echo $fila[5]; ?></p>
                                        <!-- tabla -->
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nombre</th>
                                                    <th>Precio</th>
                                                    <th>Talla</th>
                                                    <th>Color</th>
                                                    <th>Cantidad</th>
                                                    <th>SubTotal</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $re = $conexion->query("select productos_venta.*, productos.nombre, productos.talla, productos.color
                                                    from productos_venta inner join productos on productos_venta.id_producto = productos.id
                                                    where productos_venta.id_producto = productos.id")or die($conexion->error);
                                                while ($f2 = mysqli_fetch_array($re)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $f['id']; ?></td>
                                                        <td><?php echo $f2['nombre']; ?></td>
                                                        <td>$<?php echo $f2['precio']; ?></td>
                                                        <td><?php echo $f2['talla']; ?></td>
                                                        <td><?php echo $f2['color']; ?></td>
                                                        <td><?php echo $f2['cantidad']; ?></td>
                                                        <td><?php echo $f2['subtotal']; ?></td>
                                                        
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <!--FIN tabla -->
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- fin collapse-->

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
                                <label for="descripcion">Descripcion</label>
                                <input type="text" name="descripcion" placeholder="DESCRIPCIÓN" id="descripcion" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="imagen">Imagen</label>
                                <input type="file" name="imagen" id="imagen" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" min="0" name="precio" placeholder="PRECIO" id="precio" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="inventario">Inventario</label>
                                <input type="number" min="0" name="inventario" placeholder="INVENTARIO" id="inventario" class="form-control" required>
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
                                <label for="talla">Talla</label>
                                <input type="text" name="talla" placeholder="TALLA" id="talla" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" name="color" placeholder="COLOR" id="color" class="form-control" required>
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
                                <label for="imagen">Imagen</label>
                                <input type="file" name="imagen" id="imagen" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="precioEdit">Precio</label>
                                <input type="number" min="0" name="precio" placeholder="PRECIO" id="precioEdit" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="inventarioEdit">Inventario</label>
                                <input type="number" min="0" name="inventario" placeholder="INVENTARIO" id="inventarioEdit" class="form-control" required>
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
                                <label for="tallaEdit">Talla</label>
                                <input type="text" name="talla" placeholder="TALLA" id="tallaEdit" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="colorEdit">Color</label>
                                <input type="text" name="color" placeholder="COLOR" id="colorEdit" class="form-control" required>
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
                var precio = $(this).data('precio');
                var inventario = $(this).data('inventario');
                var categoria = $(this).data('categoria');
                var talla = $(this).data('talla');
                var color = $(this).data('color');
                $("#nombreEdit").val(nombre);
                $("#descripcionEdit").val(descripcion);
                $("#precioEdit").val(precio);
                $("#inventarioEdit").val(inventario);
                $("#categoriaEdit").val(categoria);
                $("#tallaEdit").val(talla);
                $("#colorEdit").val(color);
                $("#idEdit").val(idEditar);
            });
        });
    </script>
</body>

</html>