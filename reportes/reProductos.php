<?php
//pdf
ob_start();

?>

<?php
    session_start();
    require '../config/conexionBasesDatos.php';

    if(!isset($_SESSION['id'])){
        header('Location: ../login.php');
    }
    $id = $_SESSION['id'];
    $nombre = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
    
    
    if($tipo_usuario == 'Administrador'){
        $sql = "SELECT codProducto,nombre_producto, descripcion,precio_producto,descuento, c.nombre_categoria AS categoria,p.activo FROM productos p INNER JOIN categorias c ON p.cod_categoria = c.codCategoria;";
        
    }else if($tipo_usuario == 'Cliente'){
        header('Location: micuenta.php');
    }

   
    
    $resultado = $conexion->query($sql);
   
$tipo_usuario = $_SESSION['tipo_usuario'];

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Glosaje Web</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/admin.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        
    </head>
    <body class="sb-nav-fixed" style="display:flex; text-align:center; justify-content:center">
  
        
                <main style="margin-top:2em;">
                

                <div class="container-fluid">
                       
                       
                        
                        <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-boxes"></i>Lista de Productos
                        </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Código Producto</th>
                                            <th>Nombre</th>
                                            <th>Descripcion</th>
                                            <th>Precio</th>
                                            <th>Descuento</th>
                                            <th>Categoria</th>
                                            <th>Activo</th>
                                            

                                            
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        
                                        <?php while($row = $resultado->fetch_assoc()) { ?>
                                       <tr>
                                        <td><?php echo $row['codProducto']; ?></td>
                                        <td><?php echo $row['nombre_producto']; ?></td>
                                        <td><?php echo $row['descripcion']; ?></td>
                                        <td><?php echo $row['precio_producto']; ?></td>
                                        <td><?php echo $row['descuento']; ?></td>
                                        <td><?php echo $row['categoria']; ?></td>
                                        <td><?php echo $row['activo']; ?></td>
                                       
                                       
                                       </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    
                

                   
                                      
                                           
              

                </main>
                
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        
        
        
        <script src="../js/datatables-simple-demo.js"></script>

       
    </body>
</html>
<?php
    $html = ob_get_clean();//Contenido pdf
    //echo $html;
    require_once '../librerias/dompdf/autoload.inc.php'; //Crear objeto
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnabled' => true));
    $dompdf->setOptions($options);
    $dompdf->loadHtml($html);

    $dompdf->setPaper("letter"); //Formato carta             
    //$dompdf->setPaper("A4","landscape");    //Formato horizontal
    $dompdf->render();
    $dompdf->stream("productos.pdf",array("Attachment" =>true));

    
            
?>
