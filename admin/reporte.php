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
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./dashboard/plugins/fontawesome-free/css/all.min.css">
</head>
<body>
<?php 
include "../php/conexion.php";
$resultado = $conexion->query("
  select productos.*, categorias.nombre as catego, proveedores.nombre as nombreProveedor
  from productos
  inner join categorias on productos.categoriaFK = categorias.id
  inner join proveedores on productos.proveedorFK = proveedores.id_proveedor
  order by id DESC") or die($conexion->error);
?>
<h2>Reporte de productos</h2>
<table class="table table-dark" id="tableProd">
          <br>
          <br>
            <thead>
              <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio de compra</th>
                <th>Categoria</th>
                <th>Color</th>
                <th>estado</th>
                <th>precio de venta</th>
              </tr>
            </thead>
            <tbody>

              <?php
              while ($f = mysqli_fetch_array($resultado)) {
              ?>
                <tr>
                  <td><?php echo $f['id']; ?></td>

                  <td>
                  <img src="../images/referencia/img_feria/<?php echo $f['imagen']; ?>" width="50px" height="40px" alt="" class="">
                  </td>

                  <td>
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

                </tr>
              <?php } ?>
            </tbody>
          </table>

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
</body>
</html>

<?php
$html = ob_get_clean();

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$domPDF = new Dompdf();

$opt = $domPDF->getOptions();
$opt -> set(array('isremoteEnabled' => true));
$domPDF->setOptions($opt);

$domPDF->loadHtml(utf8_decode($html));

$domPDF->setPaper('letter');

$domPDF->render();

$domPDF->stream("reporte.pdf", array("Attachment" => false));

?>
