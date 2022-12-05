<?php
     require '../config/config.php';
     require '../config/database.php';
    
     require '../config/conexionBasesDatos.php';
 
     if(!isset($_SESSION['id'])){
         header('Location: login.php');
     }

     $idCliente = $_SESSION['id'];
     $db = new Database();
     $con = $db->conectar();

     $id_transaccion = isset($_GET['key']) ? $_GET['key'] : 0;
     $_SESSION['id_transaccion'] = $id_transaccion;
     $error = '';
     if($id_transaccion == 0){
        $error = 'error al procesar la petición';
     }else{
        $sql = $con->prepare("SELECT count(cod_compra)  FROM compras WHERE id_transaccion =? AND status = ?");
        $sql->execute([$id_transaccion,'COMPLETED']);
  
        if($sql->fetchColumn() > 0){
            $sql = $con->prepare("SELECT cod_compra,fecha,email,total FROM compras WHERE id_transaccion =? AND status = ? LIMIT 1");
            $sql->execute([$id_transaccion,'COMPLETED']);
            $row = $sql->fetch(PDO::FETCH_ASSOC);

            $idCompra = $row['cod_compra'];
            $total = $row['total'];
            $fecha = $row['fecha'];

            $_SESSION['idCompra'] = $idCompra;
            $_SESSION['total'] = $total;
            $_SESSION['fecha'] = $fecha;

            $sqlDet = $con->prepare('SELECT nombre_producto,precio_producto,cantidad FROM detalle_compra WHERE cod_compra = ?');
            $sqlDet->execute([$idCompra]);
            //$row_detalle = $sqlDet->fetch(PDO::FETCH_ASSOC);
            

           // $sqlDet->fetch(PDO::FETCH_ASSOC);
          /*   print_r($sqlDet['cantidad']);
            print_r($sqlDet['nombre_producto']) ; */
           

        }else{
            $error = 'Error al verificar la compra';
        }
     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlosajeWeb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="../assets/css/admin.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
<header>
  <div class="collapse bg-dark" id="navbarHeader">
    <div class="container">
      <div class="row">
        <!-- <div class="col-sm-8 col-md-7 py-4">
          <h4 class="text-white">About</h4>
          <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
        </div>
        <div class="col-sm-4 offset-md-1 py-4">
          <h4 class="text-white">Contact</h4>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white">Follow on Twitter</a></li>
            <li><a href="#" class="text-white">Like on Facebook</a></li>
            <li><a href="#" class="text-white">Email me</a></li>
          </ul>
        </div> -->
      </div>
    </div>
  </div>
  <div class="navbar navbar-expand-lg   navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a href="catalogo.php" class="navbar-brand">
        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg> -->
        <strong>GlosajeWeb</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarHeader">
        <ul class="nav navbar-nav me-auto md-2 mb-lg-0">
            <li class="nav-item">
                <a href="catalogo.php" class="nav-link active">Catalogo</a>
            </li>
            <li class="nav-item">
                <a href="contacto.php" class="nav-link">Contacto</a>
            </li>
            <?php if(!isset($_SESSION["usuario"])){ ?>
            <li class="nav-item">
                <a href="./login.php" class="nav-link">Iniciar Sesión</a>
            </li>
            <?php }?>
            <li class="nav-item">
                <a href="micuenta.php" class="nav-link">Mi cuenta</a>
            </li>
            <li class="nav-item">
                <a href="../controladores/cerrarSesion.php" class="nav-link">Cerrar Sesión</a>
            </li>
        </ul>
        <a href="checkout.php" class="btn btn-primary">
          Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>

        </a>
      </div>
    </div>
  </div>
</header>
<main>
 
    <div class="loader"></div>
    <div class="container-fluid px-4 mt-4">
    <div class="card mb-4">
    <div class="card-header">
                            <i class="fas fa-dollar-sign"></i>Información de Compra
    </div>
    <?php if(strlen($error)> 0){ ?>
            <div class="row">
                <div class="col">
                    <h3><?php echo $error; ?></h3>
                </div>
            </div>
        <?php }  else{?>
        
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
                       <?php } ?>
              </div>
              <a href="../reportes//reFacturas.php">Descargar PDF</a>
              </div>
</main>
  
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
       
       
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script type="text/javascript">
          $(window).load(function() {
              $(".loader").fadeOut("slow");
          });
        </script>                                  
</body>

</html>

