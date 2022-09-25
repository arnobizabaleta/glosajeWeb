<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GlosajeWeb</title>
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon" />
    <link
      
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./assets/css/index.css" />
    
  </head>
  <body>
    <!-- header -->
    <header>
      <nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd">
        <div class="container-fluid">
          <img
            class="nav-logo"
            src="./assets/images/favicon.ico"
            style="margin: 0 0.5em"
          />
          <a class="navbar-brand" href="#">GlosajeWeb</a>
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
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="pages/carrito.php">Productos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./PHP_Code/login.php">Iniciar Sesión</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./PHP_Code/cerrarSesion.php">Cerrar Sesión</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./pages/carrito.php">
                  <i class="fa-solid fa-cart-shopping"></i>

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

    <!-- /header -->
    <!--main -->
    <main>
      <div
        id="carouselExampleIndicators"
        class="carousel slide size"
        data-bs-ride="true"
      >
        <div class="carousel-indicators">
          <button
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide-to="0"
            class="active"
            aria-current="true"
            aria-label="Slide 1"
          ></button>
          <button
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide-to="1"
            aria-label="Slide 2"
          ></button>
          <button
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide-to="2"
            aria-label="Slide 3"
          ></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="./assets/images/B1.jpg" class="d-block w-100" alt="..." />
          </div>
          <div class="carousel-item">
            <img src="./assets/images/p1.jpg" class="d-block w-100" alt="..." />
          </div>
          <div class="carousel-item">
            <img src="./assets/images/B2.jpg" class="d-block w-100" alt="..." />
          </div>
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#carouselExampleIndicators"
          data-bs-slide="prev"
        >
          <span
            class="carousel-control-prev-icon bg-dark"
            aria-hidden="true"
          ></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#carouselExampleIndicators"
          data-bs-slide="next"
        >
          <span
            class="carousel-control-next-icon bg-dark"
            aria-hidden="true"
          ></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </main>
    <!--/main -->
    <section style="margin-bottom: 2em;">
      <h1 style="margin: 2em 0; font-weight:bolder">Creaciones Glosaje</h1>
      <div class="container-fluid">
        <div class="row">
          <div class="col-6 col-sm-3">
            <div class="card">
              <div
                id="carouselExampleControls"
                class="carousel slide"
                data-bs-ride="carousel"
              >
                <div class="carousel-inner">
                  <div class="carousel-item active" style="height:fit-content;">
                    <img src="./assets/images/B1.jpg" height="269px" class="d-block w-100" alt="..." />
                  </div>
                  <div class="carousel-item" style="height:fit-content;">
                    <img src="./assets/images/B3.jpg" height="269px" class="d-block w-100" alt="..." />
                  </div>
                  <div class="carousel-item" style="height:fit-content;">
                    <img src="./assets/images/B2.jpg" height="269px" class="d-block w-100" alt="..." />
                  </div>
                </div>
                <button
                  class="carousel-control-prev"
                  type="button"
                  data-bs-target="#carouselExampleControls"
                  data-bs-slide="prev"
                >
                  <span
                    class="carousel-control-prev-icon"
                    aria-hidden="true"
                  ></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button
                  class="carousel-control-next"
                  type="button"
                  data-bs-target="#carouselExampleControls"
                  data-bs-slide="next"
                >
                  <span
                    class="carousel-control-next-icon"
                    aria-hidden="true"
                  ></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>

              <div class="card-body">
                <h5 class="card-title">Hombres</h5>
                <p class="card-text">
                  Prendas para hombres
                </p>
                <a href="./pages/carrito.php" class="btn btn-primary">Ver más</a>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-3">
            <div class="card">
              <div
                id="carouselExampleFade"
                class="carousel slide carousel-fade"
                data-bs-ride="carousel"
              >
                <div class="carousel-inner">
                  <div class="carousel-item active" style="height:fit-content;">
                    <img src="./assets/images/p2.jpg"  height="269px" class="d-block w-100" alt="..." />
                  </div>
                  <div class="carousel-item" style="height:fit-content;">
                    <img src="./assets/images/p1.jpg" height="269px" class="d-block w-100" alt="..." />
                  </div>
                  <div class="carousel-item" style="height:fit-content;">
                    <img src="./assets/images/p3.jpg" height="269px" class="d-block w-100" alt="..." />
                  </div>
                </div>
                <button
                  class="carousel-control-prev"
                  type="button"
                  data-bs-target="#carouselExampleFade"
                  data-bs-slide="prev"
                >
                  <span
                    class="carousel-control-prev-icon"
                    aria-hidden="true"
                  ></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button
                  class="carousel-control-next"
                  type="button"
                  data-bs-target="#carouselExampleFade"
                  data-bs-slide="next"
                >
                  <span
                    class="carousel-control-next-icon"
                    aria-hidden="true"
                  ></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
              <div class="card-body">
                <h5 class="card-title">Mujeres</h5>
                <p class="card-text">
                  Prendas para damas 
                </p>
                <a href="./pages/carrito.php" class="btn btn-primary">Ver más</a>
              </div>
            </div>
          </div>

          <div class="col-6 col-sm-3">
            <div class="card">
              <!--Carousel-->

              <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false">
                <div class="carousel-inner">
                  <div class="carousel-item active" style="height:fit-content;">
                    <img src="./assets/images/B1.jpg" height="269px" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item" style="height:fit-content;">
                    <img src="./assets/images/B2.jpg" height="269px" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item" style="height:fit-content;">
                    <img src="./assets/images/n1.jpg" height="269px" class="d-block w-100" alt="...">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
             
              <div class="card-body">
                <h5 class="card-title">Niños</h5>
                <p class="card-text">
                 Prendas para niños
                </p>
                <a href="./pages/carrito.php" class="btn btn-primary">Ver más</a>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-3">
            <div class="card">

              <!--Carrousel-->

              <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active" data-bs-interval="10000" style="height:fit-content;">
                    <img src="./assets/images/pijama1.jpg"  height="269px" class="d-block w-100" alt="...">
                    
                  </div>
                  <div class="carousel-item" data-bs-interval="2000" style="height:fit-content;">
                    <img src="./assets/images/pijama1.jpg" height="269px" class="d-block w-100" alt="...">
                   
                  </div>
                  <div class="carousel-item" style="height:fit-content;">
                    <img src="./assets/images/pijama1.jpg"  height="269px" class="d-block w-100" alt="...">
                    
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
 
              <div class="card-body">
                <h5 class="card-title">Niñas</h5>
                <p class="card-text">
                  Prendas para niñas
                </p>
                <a href="./pages/carrito.php" class="btn btn-primary">Ver más</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
<footer class="bg-dark text-center text-white">
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
    
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
      integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
      integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK"
      crossorigin="anonymous"
    ></script>
   <!--  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
      <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </svg> -->
    <script src="https://kit.fontawesome.com/c2ff389525.js" crossorigin="anonymous"></script>
  </body>
</html>
