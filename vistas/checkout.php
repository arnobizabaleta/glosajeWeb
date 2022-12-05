<?php
       
  require '../config/config.php';
  require '../config/database.php';

  $db = new Database();
  $con = $db->conectar();

  if(!isset($_SESSION['id'])){
    header('Location: login.php');//Redireccionando al login
}

     
  $productos = isset($_SESSION['carrito']['productos'])? $_SESSION['carrito']['productos']: null ;
  //print_r($_SESSION);
  $lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad){

        $sql = $con->prepare("SELECT codProducto,nombre_producto,precio_producto, $cantidad AS cantidad,descuento FROM productos WHERE codProducto=? AND  activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);//Trae los resultados del query por nombreDeColumna
    }
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
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if($lista_carrito == null){
                        echo '<tr><td colspan="5" class="text-center"><b>Lista vacía</b></td></tr>';
                    }else{
                        $total = 0;
                        foreach($lista_carrito as $producto){
                            $_id = $producto['codProducto'];
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
                        <td><?php echo MONEDA . number_format($precio_desc,2,'.',',') ; ?></td>
                        <td>
                            <input type="number" min="1" max="100" step="1" 
                            value="<?php echo $cantidad ?>"  size="5" id="cantidad_<?php echo $_id ?>" 
                            onchange="actualizaCantidad(this.value,<?php echo $_id ?>)">
                           
                        </td>
                        <td>
                            <div id="subtotal_<?php echo $_id ?>" name="subtotal[]">
                            <?php echo MONEDA . number_format($precio_desc,2,'.',',') ; ?>
                            </div>
                        </td>
                        <td>
                            <a href="#" id="eliminar" class="btn btn-warning btn-sm" 
                            data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal"
                            data-bs-target = "#eliminaModal"
                            >
                           Eliminar
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">
                            <p class="h3" id="total"><?php echo MONEDA . number_format($total,2,'.',',') ; ?></p>
                        </td>
                    </tr>        

                </tbody>
            <?php } ?>

            </table>
        </div>

        <?php if($lista_carrito != null){ ?>
        <div class="row">
            <div class="col-md-5 offset-md-7 d-grip gap-2">
                <a href="pago.php" class="btn btn-primary btn-lg">Realizar pago</a>
            </div>
        </div>
        <?php } ?>
    </div>
      
</main>

<!-- Modal -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eliminaModalLabel">Alerta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Desea eliminar el producto de la lista?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="btn-elimina" class="btn btn-danger" onclick="eliminar()">
          Eliminar</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>

  let eliminaModal = document.getElementById('eliminaModal');
  eliminaModal.addEventListener('show.bs.modal',function(event){
    let button =  event.relatedTarget;
    let id = button.getAttribute('data-bs-id');//Obteniendo el ID pasado atraves del botón
    let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina');
    buttonElimina.value = id;
  })
  function actualizaCantidad(cantidad, id){
    let url = '../controladores/actualizar_carrito.php';
    let formData = new FormData();
    formData.append('action','agregar');
    formData.append('id',id);
    formData.append('cantidad',cantidad);

    fetch(url,{
      method:'POST',
      body: formData,
      mode:'cors'
    }).then(response => response.json())
    .then(data =>{
      if(data.ok){
        let divsubtotal = document.getElementById('subtotal_'+ id);
        divsubtotal.innerHTML = data.sub;
        let total = 0.00;
        let lista = document.getElementsByName('subtotal[]');

        for(let i=0; i<lista.length; i++){
           total += parseFloat(lista[i].innerHTML.replace(/[$,]/g,''));

        }
        total = new Intl.NumberFormat('en-US',{ 
          minimumFractionDigits:2
        }).format(total);

        document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total;
      }
    })
    
  }

  function eliminar(){

    let buttonElimina = document.getElementById('btn-elimina');
    let id = buttonElimina.value;

    let url = '../controladores/actualizar_carrito.php';
    let formData = new FormData();
    formData.append('action','eliminar');
    formData.append('id',id);
   

    fetch(url,{
      method:'POST',
      body: formData,
      mode:'cors'
    }).then(response => response.json())
    .then(data =>{
      if(data.ok){
        location.reload(); // Recargar la pagina
                
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