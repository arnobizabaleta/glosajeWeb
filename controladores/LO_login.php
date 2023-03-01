<?php
session_start(); //Inicializando una sessión
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
$contrasena = hash('sha512', $contrasena);
//Verificar que el usuario con ese email y password exista en la DATABASE
$query = "SELECT * FROM usuarios WHERE correo_user = '$correo' AND contrasena_user = '$contrasena' LIMIT 1";

$exec = $conexion->query($query);

//Si hay una fila o registro de la ejecucion de la consulta anterior

$user = $exec->fetch_assoc();
if ($exec && $exec->num_rows > 0 && $user["activo"] == 0) {

  http_response_code(401);
  header("Content-Type: application/json");
  echo json_encode([
    "message" => "Por favor, verifica tu cuenta"
  ]);
  exit();
  
} else if ($exec && $exec->num_rows > 0 && $user["activo"] == 1) {

  $_SESSION["usuario"] = $correo;

  $_SESSION['id'] = $user['id_user'];
  $_SESSION['nombre'] = $user['nombres_usuario'];
  $_SESSION['tipo_usuario'] = $user['rol'];

  //Redireccionando a la main page
  // header("Location: ../vistas/catalogo.php", true, 200);
  header("Content-Type: application/json");
  echo json_encode([
    "location" => "../vistas/catalogo.php"
  ]);
  exit();
}

http_response_code(401);
header("Content-Type: application/json");
echo json_encode([
  "message" => "El usuario no existe, por favor verifique los datos introducidos"
]);
exit();
