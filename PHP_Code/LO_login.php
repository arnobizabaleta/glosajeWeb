<?php
      session_start();//Inicializando una sessión
      //Session queda guardada en la memoria caché del browser
      //cookies
      /*
    Hacemos el llamado al archivo que contiene los valores 
    parametros para conectarnos a la base de datos
*/

require './conexionBasesDatos.php';
//Traemos los datos del formulario de Login
$correo = $_POST["Correo"];
$contrasena = $_POST["Contrasena"];
//Encryptar Contraseña
$contrasena = hash('sha512',$contrasena);
//Verificar que el usuario con ese email y password exista en la DATABASE
$query = "SELECT * FROM usuarios WHERE correo_user = '$correo' AND contrasena = '$contrasena'";
$validar_Login = mysqli_query($conexion,$query);

//Si hay una fila o registro de la ejecucion de la consulta anterior
if(mysqli_num_rows($validar_Login) > 0){
    
    $_SESSION["usuario"] = $correo;
    //Redireccionando a la main page
  header("Location: ../pages/carrito.php");
  exit();
}
else{
    echo '
    <script>
        alert("El usuario no existe, por favor verifique los datos introducidos");
        window.location = "./login.php";
    </script>
    ';
    exit();
}
?>