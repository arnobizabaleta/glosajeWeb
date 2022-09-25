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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    .fondo {
        background-color: blue;
        border: none;
        padding: 5%;
    }
</style>

<body>


    <!-- header -->
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
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="../pages/carrito.php">Productos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../PHP_Code/login.php">Iniciar Sesión</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../PHP_Code/cerrarSesion.php">Cerrar Sesión</a>
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

    <h1 class="text-center mb-3 p-3" style="background-color: #e3f2fd">Modulo de Entrega</h1>

    <div class="container h-100 border mt-5 p-5 pt-3">
        <div class="mx-auto d-flex flex-row justify-content-around w-50" id="event">

            <button id="domicilio" class="btn h2" data-envio="1" style="background-color: #e3f2fd">Envio a
                domicilio</button>

            <button class="h2 btn" id="tienda" data-envioTienda="1" style="background-color: #e3f2fd">Recoger en
                tienda</button>

        </div>

        <form action="" class="mt-3 d-none" id="metodoEnvio">

            <select name="" id="" class="form-select">

                <option value="">Belen</option>
                <option value="">Laureles</option>
                <option value="">Paris</option>
                <option value="">Pedregal</option>
                <option value="">Castilla</option>
            </select>

            <label for="direccion" class="mt-3">Direccion: </label>
            <label for="direccion">Ejemplo: <strong>Carrera 45c # 80sur - 116</strong></label>

            <div class="d-inline-flex mt-3">
                <select name="" id="" class="form-select">

                    <option value="">Avenida</option>
                    <option value="">Calle</option>
                    <option value="">Carrera</option>
                    <option value="">Circular</option>
                    <option value="">Regional</option>
                    <option value="">Manzana</option>

                </select>

                <input type="text" placeholder="Ejm 32c" class="form-control">

                <label for="#">#</label>
                <input type="text" placeholder="45" class="form-control">

                <label for="-">-</label>
                <input type="text" placeholder="116" class="form-control">
            </div>

            <label for="vivienda" class="mt-3">Piso o apartamento</label>
            <input type="text" placeholder="Ejemplo: p2" class="form-control mt-3">
        </form>

        <div class="mt-3 d-none" id="metodoDireccion">

            <h4>Recoger en direccion</h4>
            <p>Carrera 34a # 71-29 Manrrique oriental</p>

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.985178552948!2d-75.
            54896298573408!3d6.265679027846334!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e44289
            5b3a10b2b%3A0x3127b4f0a13bf24c!2sCra.%2034a%20%2371-29%2C%20Medell%C3%ADn%2C%20Manrique%2C%20M
            edell%C3%ADn%2C%20Antioquia!5e0!3m2!1sen!2sco!4v1663281333707!5m2!1sen!2sco" 
            style="border:0;" allowfullscreen="" loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade" class="w-100" height="300px"></iframe>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>

    <script>

        const e = document.getElementById("event");
        const domicilio = document.getElementById("domicilio");

        const metodoEnvio = document.getElementById("metodoEnvio");

        const metodoDireccion = document.getElementById("metodoDireccion");

        console.log("metodoEnvio: " + metodoEnvio);

        const tienda = document.getElementById("tienda");

        e.addEventListener("click", (event) => {
            console.log(event.target);

            if (event.target && event.target.hasAttribute("data-envio")) {

                domicilio.classList.toggle("btn-primary");
                metodoEnvio.classList.toggle("d-none");
                metodoDireccion.classList.toggle("d-block");

            }

            else if (event.target && event.target.hasAttribute("data-envioTienda")) {
                console.log("Tienda");

                tienda.classList.toggle("btn-primary");
                metodoDireccion.classList.toggle("d-none");
                metodoEnvio.classList.toggle("d-block");

                /*tienda.classList.toggle("btn-primary");
                metodoEnvio.classList.toggle("d-none");
                tienda.style.display = "block";*/

            }
        });

    </script>
</body>

</html>