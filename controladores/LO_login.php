<?php
      session_start();//Inicializando una sessión
      //Session queda guardada en la memoria caché del browser
      //cookies
      /*
    Hacemos el llamado al archivo que contiene los valores 
    parametros para conectarnos a la base de datos
*/

require '../config/conexionBasesDatos.php';
//Traemos los datos del formulario de Login
$correo = $_POST["Correo"];
$contrasena = $_POST["Contrasena"];
$_SESSION['Contrasena'] = $_POST["Contrasena"];

//Encryptar Contraseña
$contrasena = hash('sha512',$contrasena);
//Verificar que el usuario con ese email y password exista en la DATABASE
$query = "SELECT * FROM usuarios WHERE correo_user = '$correo' AND contrasena = '$contrasena' AND activo = 1";

$validar_Login = mysqli_query($conexion,$query);



//Si hay una fila o registro de la ejecucion de la consulta anterior
if(mysqli_num_rows($validar_Login) > 0){
    
    $_SESSION["usuario"] = $correo;

    $resultado = $conexion->query($query);
    $num = $resultado->num_rows;
    $row = $resultado->fetch_assoc();
    $_SESSION['id']= $row['idUser'];
    $_SESSION['nombre']= $row['nombres_usuario'];
    $_SESSION['tipo_usuario']= $row['rol'];

    //Redireccionando a la main page
  header("Location: ../vistas/catalogo.php");
  exit();
}
else{
    echo '
    <script>
        alert("El usuario no existe, por favor verifique los datos introducidos");
        window.location = "../vistas/login.php";
    </script>
    ';
    exit();
}
?>