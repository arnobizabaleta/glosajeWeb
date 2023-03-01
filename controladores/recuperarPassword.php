<?php

//session_start();
require '../config/conexionBasesDatos.php';

use FontLib\Table\Type\head;
use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

require '../librerias/phpmailer/src/PHPMailer.php';
require '../librerias/phpmailer/src/SMTP.php';
require '../librerias/phpmailer/src/Exception.php';

$email = $_POST["Correo"];
//include '../captura.php';
//$id_user = $_SESSION['id'];

$query = "SELECT * FROM usuarios WHERE correo_user = '$email'";
$exec = $conexion->query($query);
$user = $exec->fetch_assoc();

if ($exec->num_rows <= 0) {
    http_response_code(401);
    header("Content-Type: application/json");
    echo json_encode([
        "message" => "El correo ingresado no está registrado en nuestra base de datos"
    ]);
    exit();
}

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

// Output: iNCHNGzByPjhApvn7XBD
$token = generate_string($permitted_chars, 8);

$sqlInsert = "UPDATE usuarios SET token = '$token' WHERE correo_user  = '$email'";
$resultadoInsert = $conexion->query($sqlInsert);

if (!$resultadoInsert) {

    http_response_code(401);
    header("Content-Type: application/json");
    echo json_encode([
        "message" => "Error al generar su nueva contraseña"
    ]);
    exit();
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // SMTP:: DEBUG_OFF                    //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'glosajeweb@gmail.com';                     //SMTP username
    $mail->Password   = 'zvoezbsnwincnrtz';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('glosajeweb@gmail.com', 'glosajeWeb');
    $mail->addAddress($email, 'Cliente');     //Add a recipient
    // $mail->addAddress('arnzabaleta@misena.edu.co');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');



    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Recuperacion de contrasena';
    $cuerpo .= '<p>Recuerde que su contraseña es confidencial<b>';
    $cuerpo .= '<p>Puedes cambiarla<a href='."http://localhost/glosajewebV2/vistas/newPassword.php?email=".$email."&token=".$token."> aqui</a></p>";

    $mail->Body    = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos su nueva contraseña.';
    $mail->setLanguage('es', '../librerias/phpmailer/language/phpmailer.lang-es');
    $mail->send();
    http_response_code(200);

    exit();
} catch (Exception $e) {
    //echo "Error al enviar el correo electronico: {$mail->ErrorInfo}";
    //print_r($mail->ErrorInfo);

    http_response_code(401);
    header("Content-Type: application/json");
    echo json_encode([
        "message" => "Error al enviar el email, intente más tarde"
    ]);
    exit();
}
