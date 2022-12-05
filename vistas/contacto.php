<?php

require '../config/config.php';
require '../config/database.php';
//Si no existe una session de usuario asociada un correo 





  
  $db = new Database();
  $con = $db->conectar();
  $sql = $con->prepare("SELECT codProducto,nombre_producto,precio_producto,descuento FROM productos WHERE activo=1");
  $sql->execute();
  $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);//Trae los resultados del query por nombreDeColumna
  
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
                <a href="#" class="nav-link">Contacto</a>
            </li>
            <?php if(!isset($_SESSION["usuario"])){ ?>
            <li class="nav-item">
                <a href="./login.php" class="nav-link">Iniciar Sesión</a>
            </li>
            <?php }?>
            <li class="nav-item">
                <a href="micuenta.php" class="nav-link">Mi cuenta</a>
            </li>
            <?php if(isset($_SESSION["usuario"])){ ?>
            <li class="nav-item">
                <a href="../controladores/cerrarSesion.php" class="nav-link">Cerrar Sesión</a>
            </li>
            <?php }?>
        </ul>
        <?php if(isset($_SESSION["usuario"])){ ?>
           
                <a href="checkout.php" class="btn btn-primary">
          Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>

        </a>
            }
        <?php }?>
        
      </div>
    </div>
  </div>
</header>

<main style="margin-top:2em;">
  
    <div class="loader"></div>
    <div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-address-book me-2"></i><b>Contacto</b>
        </div>
        <div class="card-body">
            <p>
                <b>Creaciones Glosaje</b> es una microempresa antioqueña con 10 años 
                de experiencia dedicada a la confección y venta de ropa interior.<br>
                Ubicada en el área metropolitana de la ciudad de <b>Medellín</b>. <br>
                <b> Dirección:</b> Cra 34#71-29. <br>
                <b>Propietaria:</b> Gloria Alcazar.<br>
                <b>Telefono de contacto:</b><i class="fas fa-phone ms-2 me-2"></i><i class="fa-brands fa-whatsapp ms-2 me-2"></i> 3104719942 <br>
                <b>Facebook:</b> <a href="#"><i class="fa-brands fa-facebook ms-2 me-2"></i> </a>  
            </p> 
        </div>
    </div>

    </div>
      
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script type="text/javascript">
          $(window).load(function() {
              $(".loader").fadeOut("slow");
          });
        </script>   
</body>
</html>