 <?php
    session_start();
    //Si  existe una session de usuario asociada un correo 
    if (isset($_SESSION["usuario"])) {

        //Redireccionando al index
        header("location: ./catalogo.php");
    }
    ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Login y Register</title>

     <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">


     <link rel="stylesheet" href="../assetsLogin/css/estilos.css">
     <link rel="stylesheet" href="../assets/css/utils.css">
     <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 </head>

 <body>

     <main>
         <div class="loader"></div>
         <div class="contenedor__todo">
             <div class="caja__trasera">
                 <div class="caja__trasera-login">
                     <h3>¿Ya tienes una cuenta?</h3>
                     <p>Inicia sesión para entrar en la página</p>
                     <button id="btn__iniciar-sesion" style="color:gray">Iniciar Sesión</button>
                 </div>
                 <div class="caja__trasera-register">
                     <h3>¿Aún no tienes una cuenta?</h3>
                     <p>Regístrate para que puedas iniciar sesión</p>
                     <button id="btn__registrarse" style="color:gray">Regístrarse</button>
                 </div>
             </div>

             <!--Formulario de Login y registro-->
             <div class="contenedor__login-register">
                 <!--Login-->
                 <form action="../controladores/LO_login.php" method="POST" class="formulario__login" data-login="true">
                     <h2>Iniciar Sesión</h2>
                     <input data-valid="false" data-field-name="email" type="email" placeholder="Correo Electronico" name="Correo" required="required">
                     <input data-valid="false" data-field-name="password" type="password" placeholder="Contraseña" name="Contrasena" required="required">
                     <div style="display:flex; justify-content: space-around; align-items:center; background-color:white;">
                         <button type="submit" style="margin-bottom:40px" disabled>Entrar</button>
                         <a href="recuperarPass.php" class="olvideMiPass" style="color:#46A2FD;">Olvidaste tu contraseña?</a>
                     </div>

                 </form>

                 <!--Register-->
                 <form action="../controladores/LO_registroUsuario.php" method="POST" class="formulario__register" data-register="true">
                     <h2 style="text-align:center;  font-size: 30px; margin-bottom: 20px;  color: #46A2FD;">Regístrarse</h2>
                     <input data-valid="false" data-field-name="id"" type="number" placeholder="Nro Identificación" name="id_user" required="required">

                     <input data-valid="false" data-field-name="name" type="text" placeholder="Nombre Completo" name="Nombre_Completo" required="required">
                     <input data-valid="false" data-field-name="lastName" type="text" placeholder="Apellidos" name="Apellidos" required="required">
                     <input data-valid="false" data-field-name="email" type="email" placeholder="Correo Electronico" name="Correo" required="required">
                     <input data-valid="false" data-field-name="password" type="password" placeholder="Contraseña" name="Contrasena" required="required">
                     <input data-valid="false" data-field-name="phoneNumber" type="number" placeholder="Telefono" name="tel_user" required="required">
                     <p style=" color:gray;margin-top: 0.7em; margin-bottom:-0.5em; margin-left:0.5em;"> <label for="municipio">Municipio</label> </p>
                     <div style="background: #F2F2F2; height:2.5em;  width:21.2em;">
                         <select name="municipio" id="municipio" required="required">

                         </select>
                     </div>
                     <p style=" color:gray;margin-top: 0.7em; margin-bottom:-0.5em; margin-left:0.5em;"> <label for="municipio">Comuna-Barrio</label> </p>
                     <div style="background: #F2F2F2; height:2.5em;  width:21.2em;">
                         <select name="comuna_barrio" id="comuna_barrio" required="required">
                             <option value="Popular">Popular</option>
                             <option value="Santa Cruz">Santa Cruz</option>
                             <option value="Manrique">Manrique</option>
                             <option value="Aranjuez">Aranjuez</option>
                             <option value="Castilla">Castilla </option>
                             <option value="Doce de Octubre">Doce de Octubre</option>
                             <option value="Robledo">Robledo</option>
                             <option value="Villa Hermosa">Villa Hermosa</option>
                             <option value="Buenos Aires">Buenos Aires</option>
                             <option value="Laureles-Estadio">Laureles-Estadio</option>
                             <option value="La América">La América</option>
                             <option value="San Javier">San Javier</option>
                             <option value="Poblado">Poblado</option>
                             <option value="Guayabal">Guayabal</option>
                             <option value="Belén">Belén</option>
                             <option value="Otra">Otro(a)</option>
                         </select>
                     </div>

                     <input data-valid="false" data-field-name="location" type="text" placeholder="Dirección Exacta" name="direccion_exacta" required="required">
                     <button disabled type="submit">Regístrarse</button>
                 </form>
             </div>
         </div>
         <?php if (isset($_SESSION['message']) && $_SESSION['message'] != null) { ?>
             <div class="alert alert-<?php echo  $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
                 <?php echo $_SESSION['message'] ?>
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
         <?php } ?>
         <?php $_SESSION['message'] = null; ?>
     </main>

     <footer>
         <?php
            //Variables parametros conexion servidor y bases de datos 


            /*
    Hacemos el llamado al archivo que contiene los valores 
    parametros para conectarnos a la base de datos
*/

            require '../config/conexionBasesDatos.php';
            $conexion = new mysqli($host, $user, $password, $dbname, $port, $socket);

            //Verificamos la conexión
            /*  if($conexion -> connect_errno){
    echo" <br> <p>Error de conexión a la base de datos </p> " . $conexion -> connect_error;
   
    exit();
}else{
    echo"<br><p> Conectados al servidor y listos para usar la base de datos </p>" . $dbname;
}  */


            ?>
     </footer>

     <script src="../assetsLogin/js/script.js"></script>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
     <script type="text/javascript">
         $(window).load(function() {
             $(".loader").fadeOut("slow");
         });
     </script>

     <script src="../assetsLogin/js/scriptAuth.js" type="module"></script>
     <script src="../example.js"></script>
 </body>

 </html>