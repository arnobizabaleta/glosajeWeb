<?php
   
    use PHPMailer\PHPMailer\{PHPMailer,SMTP,Exception};
    
    require '../librerias/phpmailer/src/PHPMailer.php';
    require '../librerias/phpmailer/src/SMTP.php';
    require '../librerias/phpmailer/src/Exception.php';

   //include '../captura.php';
   

    //session_start();
    require '../config/conexionBasesDatos.php';
    $id_user = $_SESSION['id'];
    $correoRegistro  = $_SESSION['correoRegistro'] ;
    /* $sql = "SELECT * FROM usuarios";
    $sql = "SELECT * FROM usuarios WHERE idUser = $id_user";
    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc(); */
    $emailToClient = $correoRegistro;
    //print_r("idCliente:". $id);

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
    $mail->addAddress($emailToClient, 'Cliente');     //Add a recipient
    // $mail->addAddress('arnzabaleta@misena.edu.co');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
   
 

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Bienvenido a GlosajeWeb';
    $cuerpo = '<h4> ¡ Gracias por  registrarse en GlosajeWeb !</h4>';
    $cuerpo .= '<h3> Nos place darte la bienvenida a nuestro sitio web diseñado para tí, te esperamos.</h3>' ;
    $cuerpo .= '<p>No  olvides  tu contraseña</p>' ;
   

    $mail->Body    = utf8_decode($cuerpo) ;
    $mail->AltBody = 'Le damos la bienvenida a nuestro sistema.';
    $mail->setLanguage('es','../librerias/phpmailer/language/phpmailer.lang-es');
    $mail->send();

    session_destroy();
   
} catch (Exception $e) {
    echo "Error al enviar el correo electronico de bienvenida: {$mail->ErrorInfo}";
    //exit;
    $_SESSION['error'] = $e;
    
}
?>