<?php
  require '../config/config.php';
  require '../config/database.php';
  $db = new Database();
  $con = $db->conectar();

  if(!isset($_SESSION['id'])){
    header('Location: login.php');//Redireccionando al login
}

  $productos = isset($_SESSION['carrito']['productos'])? $_SESSION['carrito']['productos']: null ;
  
  $lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad){

        $sql = $con->prepare("SELECT cod_producto,nombre_producto,precio_producto, $cantidad AS cantidad,descuento FROM productos WHERE cod_producto=? AND  activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);//Trae los resultados del query por nombreDeColumna
    }
}else{
    header("Location: catalogo.php");
    exit;
}

 
 // session_destroy();
  //print_r($_SESSION);
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
                <a href="./catalogo.php" class="nav-link active">Catalogo</a>
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
    <div class="container">
        <div class="row">
                
            <div class="col-6">
                <h4> Detalles de pago</h4>
                <div id="paypal-button-container"></div>
            </div>
        <div class="col-6">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                       
                        <th>Subtotal</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if($lista_carrito == null){
                        echo '<tr><td colspan="5" class="text-center"><b>Lista vacía</b></td></tr>';
                    }else{
                        $total = 0;
                        foreach($lista_carrito as $producto){
                            $_id = $producto['cod_producto'];
                            $nombre = $producto['nombre_producto'];
                            $cantidad = $producto['cantidad'];
                            $precio =  $producto['precio_producto'];
                            $descuento=  $producto['descuento'];
                            $precio_desc = $precio - (($precio*$descuento)/100);
                            $subtotal = $cantidad * $precio_desc;
                            $total += $subtotal;
                            ?>
                    
                    <tr>
                        <td><?php echo $nombre; ?></td>
                       
                        <td>
                            <div id="subtotal_<?php echo $_id ?>" name="subtotal[]">
                            <?php echo MONEDA . number_format($precio_desc,2,'.',',') ; ?>
                            </div>
                        </td>
                       
                    </tr>
                    <?php } ?>
                    <tr>
                        
                        <td colspan="2">
                            <p class="h3 text-end" id="total"><?php echo MONEDA . number_format($total,2,'.',',') ; ?></p>
                        </td>
                    </tr>        

                </tbody>
            <?php } ?>

            </table>
        </div>
       
    </div>
</div>
      
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&components=buttons&currency=<?php echo CURRENCY; ?>"></script>


<script>
                paypal.Buttons({
        style: {
            layout: 'vertical',
            color:  'blue',
            shape:  'rect',
            label:  'pay'
        },
        createOrder: function(data,actions) {
            return actions.order.create({
                purchase_units:[{
                    amount:{
                       
                        value:<?php echo $total; ?>
                    }
                }]
            });
        },
        onApprove: function(data,actions){
            actions.order.capture().then(function(detalles){
                //alert('Pago realizado');
                console.log(detalles);
                let url = '../controladores/captura.php';
                return fetch(url,{
                    method:'POST',
                    headers:{
                        'content-type':'application/json'
                    },
                    body:JSON.stringify({
                        detalles:detalles
                    })
                }).then(function(response){
                    window.location.href = 'completado.php?key=' + detalles['id'];//$datos['detalles']['id']
                })  
            });
        },
        onCancel: function(data) {
            alert('Pago cancelado');
            console.log(data);
        }
        }).render('#paypal-button-container');
    </script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script type="text/javascript">
          $(window).load(function() {
              $(".loader").fadeOut("slow");
          });
        </script>   
</body>
</html>