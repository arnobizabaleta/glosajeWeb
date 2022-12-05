<?php
//pdf
ob_start();

?>
<?php
     require '../config/config.php';
     require '../config/database.php';
    
     require '../config/conexionBasesDatos.php';
 
     if(!isset($_SESSION['id'])){
         header('Location: login.php');
     }

     $idCliente = $_SESSION['id'];
   

     $id_transaccion = $_SESSION['id_transaccion'];
     $idCompra =  $_SESSION['idCompra'] ;
     $total = $_SESSION['total'] ;
     $fecha = $_SESSION['fecha'];
   
        
        
            $db = new Database();
            $con = $db->conectar();

            $sqlDet = $con->prepare('SELECT nombre_producto,precio_producto,cantidad FROM detalle_compra WHERE cod_compra = ?');
            $sqlDet->execute([$idCompra]);
            //$row_detalle = $sqlDet->fetch(PDO::FETCH_ASSOC);
            

           // $sqlDet->fetch(PDO::FETCH_ASSOC);
          /*   print_r($sqlDet['cantidad']);
            print_r($sqlDet['nombre_producto']) ; */
           

        
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlosajeWeb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
  
   
   
</head>
<body style="display:flex; text-align:center; justify-content:center">

<main style="margin-top:2em;">
 
    
    <div class="container-fluid">
    <div class="card mb-4">
    <div class="card-header">
                            <i class="fas fa-dollar-sign"></i>Información de Compra GlosajeWeb
    </div>
   
        
          <div class="row">
                <div class="col">
                   <b class="ms-4">Id Compra:</b><?php echo $idCompra ?><br>
                   <b class="ms-4">Id Transacción:</b><?php echo $id_transaccion ?><br>
                   <b class="ms-4">Id Cliente:</b><?php echo $idCliente ?><br>
                   <b class="ms-4">Fecha  compra:</b><?php echo $fecha ?><br>
                   <b class="ms-4">Total: </b><?php echo '$' . number_format($total,2,'.',',') . ' USD' ;   ?><br>
                </div>
            </div>
                        
                       <div class="card mb-4">
                       
                           <div class="card-body">
                               <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Producto</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                   
                                   <tbody>
                                       
                                    <?php while($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)) { 
                                        $subtotal = $row_det['precio_producto'] * $row_det['cantidad'];
                                        ?>
                                        <tr>
                                            <td> <?php echo $row_det['cantidad']?></td>
                                            <td> <?php echo $row_det['nombre_producto']?></td>
                                            <td> <?php  echo '$' . number_format($subtotal,2,'.',',') ; ?></td>
                                        </tr>
                                      <?php }?>
                                   </tbody>
                               </table>
                           </div>
                       </div>
                      
              </div>
              </div>
</main>
  
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
       
        
       
       
       
        
                                    
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
    $dompdf->stream("factura" .$idCompra ."GlosajeWeb.pdf",array("Attachment" =>true));

    
            
?>
