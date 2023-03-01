<?php
require '../config/config.php';
require '../config/database.php';
  $db = new Database();
  $con = $db->conectar();

  if(!isset($_SESSION['id'])){
    header('Location: login.php');//Redireccionando al login
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' || $token == ''){
    echo 'Error al procesar la petición';
    exit;
}else{
    $token_tmp = hash_hmac('sha1',$id,KEY_TOKEN);
    if($token == $token_tmp){
        $sql = $con->prepare("SELECT count(cod_producto)  FROM productos WHERE cod_producto=? AND activo = 1");
        $sql->execute([$id]);
  
        if($sql->fetchColumn() > 0){
            $sql = $con->prepare("SELECT nombre_producto,descripcion,precio_producto,descuento FROM productos WHERE cod_producto=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre_producto'];
            $precio = $row['precio_producto'];
            $descripcion = $row['descripcion'];
            $descuento = $row['descuento'];
            $precio_desc =  $precio - (($precio*$descuento)/100);
            $dir_images = '../assets/images/productos/'.$id.'/';
            
           //Creando la carpeta de imagenes del producto si no existe
            if (!file_exists($dir_images)) {
                mkdir($dir_images, 0777, true);
            }

            $ruta_img = $dir_images . 'principal.jpg';
            if(!file_exists($ruta_img)){
                $ruta_img = '../assets/images/no-photo.jpg';
            }
            $imagenes = array();
            if(file_exists($dir_images)){

            
            $dir = dir($dir_images);
            while(($archivo = $dir->read()) != false){
                if($archivo != 'principal.jpg' && (strpos($archivo,'jpg') || strpos($archivo,'jpeg'))){
                    
                    $imagenes[] = $dir_images . $archivo;
                }
            }
            $dir->close();
          }
        }
        
  
    }else{
        echo 'Error al procesar la petición';
        exit;
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
    <div class="container">
        <div class="row">
            <div class="col-md-6 order-md-1">
            <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    
                    <img src="<?php echo $ruta_img ?>" class="d-block w-100" alt="">
                    </div>
                    <?php foreach($imagenes as $img){ ?>
                        <div class="carousel-item">
                        
                        <img src="<?php echo $img ?>" class="d-block w-100" alt="">
                        </div>
                    <?php } ?>
                   
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                </div>
                
            </div>
            <div class="col-md-6 order-md-2">
               <h2><?php echo $nombre ?> </h2>
               <?php if($descuento>0) {?>
                <p><del><?php echo MONEDA . number_format($precio,2,'.',','); ?> </del></p>
                <h2>
                  <?php echo MONEDA . number_format($precio_desc,2,'.',','); ?> 
                  <small class="text-success"><?php echo $descuento; ?>% descuento</small>
                </h2>
                <?php }  else{?>
                  <h2><?php echo MONEDA . number_format($precio,2,'.',','); ?> </h2>
                <?php }?>
              
               <p class="lead">
                    <?php echo $descripcion ?>
               </p>
               
               <div class="d-grid gap-3 col-10 mx-auto">
              
              
               <a href="pago.php" class="btn btn-primary btn-lg"><button class="btn btn-primary" type="button" onclick="addProducto(<?php echo $id;?>,'<?php echo $token_tmp;  ?>')">
                  Comprar ahora</button></a>
                <button class="btn btn-outline-primary" type="button"  onclick="addProducto(<?php echo $id;?>,'<?php echo $token_tmp; ?>')">
                  Agregar al carrito</button>
               </div>
               
            </div>
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