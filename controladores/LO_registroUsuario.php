<?php
/*
    Hacemos el llamado al archivo que contiene los valores 
    parametros para conectarnos a la base de datos
*/

require '../config/conexionBasesDatos.php';

$id_user = $_POST["id_user"];
$nombre_completo = $_POST["Nombre_Completo"];
$apellidos = $_POST["Apellidos"];
$correo = $_POST["Correo"];
$contrasena = $_POST["Contrasena"];
$tel_user = $_POST["tel_user"];
//$departamento = $_POST["departamento"];
$municipio = $_POST["municipio"];
$comuna_barrio = $_POST["comuna_barrio"];
//LOGICA COMUNA_BARRIO SI NO EXISTE
if ($comuna_barrio == "Otra") {
    $comuna_barrio = $_POST["otro2"];
}

$direccion_exacta = $_POST["direccion_exacta"];
//Encryptar Contraseña
$contrasena = hash('sha512', $contrasena);

//Generar token de seguridad cada usuario
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

function generate_string($input, $strength = 16)
{
    $input_length = strlen($input);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}

$token = generate_string($permitted_chars, 8);

$query = "INSERT INTO usuarios(id_user,nombres_usuario,apellidos,correo_user,
    contrasena_user,tel_user,municipio,comuna_barrio,direccion_exacta, token) 
    VALUES('$id_user','$nombre_completo','$apellidos','$correo','$contrasena','$tel_user',
    '$municipio',' $comuna_barrio','$direccion_exacta', '$token')";

//Verificar que la ID del usuario no se repita

if (!(filter_var($correo, FILTER_VALIDATE_EMAIL))) {

    header("Content-Type: application/json");
    http_response_code(401);
    echo json_encode([
        "message" => "Intentalo de nuevo, el correo es inválido"
    ]);

    exit(); //Saliendo del script actual
}

$exec = $conexion->query($query);

$errorTypes = [
    "DUPLICATE_ENTRY" => "DUPLICATE ENTRY",
    "EMAIL" => "correo_user",
    "ID" => "PRIMARY"
];

if (!$exec) {

    $error = explode(" ", $conexion->error);
    $twoWordsError = array_slice($error, 0, 2);
    $errorMessage = implode(" ", $twoWordsError);
    $lastMessage = $error[count($error) - 1];

    if (strtoupper($errorMessage) == $errorTypes["DUPLICATE_ENTRY"]) {

        switch ($lastMessage) {
            case "'" . $errorTypes["EMAIL"] . "'":
                http_response_code(401);
                header("Content-Type: application/json");
                echo json_encode([
                    "message" => "Este correo ya esta registrado, intenta con otro diferente"
                ]);
                break;
            case "'" . $errorTypes["ID"] . "'":
                header("Content-Type: application/json");
                http_response_code(401);
                echo json_encode([
                    "message" => "La identificacion ya existe"
                ]);
                break;
            default:
                break;
        }
        exit();
    }

    http_response_code(401);
    header("Content-Type: application/json");
    echo json_encode([
        "message" => "Intentalo de nuevo, el usuario no ha sido almacenado"
    ]);
    exit();
}

//Registrar usuario inactivo
//Si se registro el usuario
//Enviar correo electronico de bienvenida y activar cuenta
require '../controladores/Mailer.php';
$mailer = new Mailer();
$url = 'http://localhost/glosajewebV2/controladores' . '/activar_cliente.php?id=' . $id_user . '&token=' . $token;
$asunto = 'Activar Cuenta - GlosajeWeb';
$cuerpo = "Estimado $nombre_completo: <br> Para continuar con el proceso de registro es indispensable de click en el siguiente 
    enlace <a href='$url'>Activar cuenta</a>";
// include "email_bienvenida.php";

if ($mailer->enviar_email($correo, $asunto, $cuerpo)) {

    http_response_code(200);
    exit();
} else {

    header("Content-Type: application/json");
    http_response_code(401);

    echo json_encode([
        "message" => "Intentalo de nuevo, el correo es inválido"
    ]);
    exit(); //Saliendo del script actual
}
//Si hay una fila o registro de la ejecucion de la consulta anterior

//Verificar que el formato de  correo sea valido

//session_start();

//$_SESSION['id'] = $id_user;
//$_SESSION['correoRegistro'] = $correo;
//session_destroy();
// mysqli_close($conexion); //Cerrando la conexión