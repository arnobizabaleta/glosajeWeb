<?php
  session_start();
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
     header("location: ../PHP_Code/login.php");
    die(); // No sé ejecute el codigo siguiente
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Productos</title>
    <!-- Latest compiled and minified CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"
    />
    <link
      rel="shortcut icon"
      href="../assets/images/favicon.ico"
      type="image/x-icon"
    />
    <link rel="stylesheet" href="../assets/css/carrito.css" />
    <link rel="stylesheet" href="../assets/css/index.css" />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"
    />
    
    <script src="https://kit.fontawesome.com/c2ff389525.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <header>
      <nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd">
        <div class="container-fluid">
          <img
            class="nav-logo"
            src="../assets/images/favicon.ico"
            style="margin: 0 0.5em"
          />
          <a class="navbar-brand" href="../index.php">GlosajeWeb</a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">

              <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item">
                  <a
                    class="nav-link"
                    aria-current="page"
                    href="#"
                    >Productos</a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"
                    >Iniciar Sesión</a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../PHP_Code/cerrarSesion.php"
                    >Cerrar Sesión</a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="bi bi-cart2 float-end h2" id="iconoCarrito"></i>
                    <p
                      id="compras"
                      class="float-end h-100 bg-dark rounded-circle p-1 text-white"

                    ></p>
                  </a>
                </li>
                <!-- <li class="nav-item">
                      <a class="nav-link disabled">Disabled</a>
                    </li> -->
              </ul>
            <form class="d-flex" role="search">
              <input
                class="form-control me-2"
                type="search"
                placeholder="Buscar"
                aria-label="Search"
              />
              <button class="btn btn-outline-info" type="submit">Buscar</button>
            </form>
          </div>
        </div>
      </nav>
    </header>

    <h2 class="h1 text-center fw-bolder m-5">Productos</h2>

    <div class="container-fluid w-100" id="eventos">
      <main class="row float-start mx-auto w-100 mb-5" id="item"></main>

      <div
        id="botonVaciar"
        class="row w-50 h-50 overflow-auto shadow-lg d-none bg bg-white"
        style="
          position: absolute;
          position: fixed;
          top: 12%;
          right: 3%;
          z-index: 1;
        "
      >
        <div class="sticky-top mb-3 bg bg-dark text-white h-25 overflow-auto d-flex justify-content-around align-items-center">
          <p>Total: <span id="totalItem"></span>$</p>
          <button data-void class="btn btn-danger">Eliminar todo</button>
          <button data-selection class="btn btn-warning text-white">
            Eliminar seleccion
          </button>
          <button class="btn btn-success">
            <a href="../pages/metodoPago.php" class="text-white">Comprar todo</a>
          </button>
        </div>
        <div id="carrito" class="row"></div>
      </div>
    </div>

    <!-- Footer -->
<footer class="bg-dark text-center text-white" style="margin-top: 1em; height: fit-content">
    <!-- Grid container -->
    <div class="container p-4">
      <!-- Section: Social media -->
      <section class="mb-4">
        <!-- Facebook -->
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
          ><i class="fa-brands fa-facebook"></i>
        </a>
  
        <!-- Twitter -->
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
          ><i class="fa fa-twitter" aria-hidden="true"></i>
        </a>
  
        <!-- Whatsapp -->
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
          >
   
   
   <i class="fa-brands fa-whatsapp"></i> </a>
  
        <!-- Instagram -->
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
          ><i class="fab fa-instagram"></i
        ></a>
  
        <!-- Linkedin -->
        <!-- <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
          ><i class="fab fa-linkedin-in"></i
        ></a> -->
  
        <!-- Github -->
        <!-- <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
          ><i class="fab fa-github"></i
        ></a> -->
      </section>
      <!-- Section: Social media -->
  
      
  
      <!-- Section: Text -->
      <section class="mb-4">
        <p>
        Creaciones Glosaje es una microempresa antioqueña con 10 años de experiencia dedicada a la confección y venta de ropa interior.
        Ubicada en el área metropolitana de la ciudad de Medellín. <strong>Dirección:</strong>  Cra 34#71-29.  <strong>Propietaria:</strong> Gloria Alcazar.
        </p>
      </section>
      <!-- Section: Text -->
  
      <!-- Section: Links -->
      <section class="">
        <!--Grid row-->
        
  
        
  
         
  
         
       
        <!--Grid row-->
      </section>
      <!-- Section: Links -->
    </div>
    <!-- Grid container -->
  
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2022 Copyright:
      <a class="text-white" href="#">GlosaweWeb</a>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->
   <script src="../assets/js/carrito.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
   
  </body>
</html>
