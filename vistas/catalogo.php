<?php

require '../config/config.php';
require '../config/database.php';
//Si no existe una session de usuario asociada un correo 
if(!isset($_SESSION["usuario"])){
 /*
  echo '
    <script>
      alert("Por favor, debes iniciar Sesión);
      window.location = "PHP_Code/login.php";
    </script>
    
  ';
*/
  //header("location: ./PHP_Code/login.php");
  session_destroy();//Destruya la sessión
   header("location: ../index.php");
  die(); // No sé ejecute el codigo siguiente
}




  
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
                <a href="#" class="nav-link active">Catalogo</a>
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
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
      <?php
      foreach($resultado as $row){
        $precioDesc = $row['precio_producto'] - (($row['precio_producto'] * $row['descuento'])/100) ;
      ?>

      
        <div class="col">
          <div class="card shadow-sm">
            <?php
              $id = $row['codProducto'];
              $imagen = "../assets/images/productos/". $id ."/principal.jpg";

              if(!file_exists($imagen)){
                $imagen = "../assets/images/no-photo.jpg";
              }
            ?>
            <a href="details.php?id=<?php echo $row['codProducto']; ?>&token=<?php echo hash_hmac('sha1',$row['codProducto'],KEY_TOKEN); ?>" title="principal">
            <img src="<?php echo $imagen ?>" class="d-block w-100" id="mainImg">
            </a>
        

            <div class="card-body">
              <h5 class="card-title"><?php echo $row['nombre_producto']; ?></h5>
              <p class="card-text"><?php echo number_format($precioDesc,2,".",","); ?> USD</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="details.php?id=<?php echo $row['codProducto']; ?>&token=<?php echo hash_hmac('sha1',$row['codProducto'],KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                </div>
                <button class="btn btn-outline-success" type="button"  onclick="addProducto(<?php echo $row['codProducto'];?>,'<?php echo hash_hmac('sha1',$row['codProducto'],KEY_TOKEN); ?>')">
                  Agregar al carrito</button>
              
            </div>
          </div>
        </div>
    </div>

    <?php 
    }
      ?>

      </div>
    </div>
      
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
  function addProducto(id, token){
    let url = '../controladores/carrito.php';
    let formData = new FormData();
    formData.append('id',id);
    formData.append('token',token);

    fetch(url,{
      method:'POST',
      body: formData,
      mode:'cors'
    }).then(response => response.json())
    .then(data =>{
      if(data.ok){
        let elemento = document.getElementById("num_cart");
        elemento.innerHTML = data.numero;
      }
    })
    
  }
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script type="text/javascript">
          $(window).load(function() {
              $(".loader").fadeOut("slow");
          });
        </script>   
</body>
</html>