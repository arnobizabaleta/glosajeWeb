<?php
   
    use PHPMailer\PHPMailer\{PHPMailer,SMTP,Exception};
    
    require '../librerias/phpmailer/src/PHPMailer.php';
    require '../librerias/phpmailer/src/SMTP.php';
    require '../librerias/phpmailer/src/Exception.php';

   //include '../captura.php';
   

    //session_start();
    require '../config/conexionBasesDatos.php';
    $id_user = $_SESSION['id'];
    $sql = "SELECT * FROM usuarios";
    $sql = "SELECT * FROM usuarios WHERE idUser = $id_user";
    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc();
    $emailToClient = $row['correo_user'];
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
    $mail->Subject = 'Confirmacion de su compra';
    $cuerpo = '<h4>Gracias por su compra en GlosajeWeb</h4>';
    $cuerpo .= '<p>El id de su transacción mediante Paypal es <b>' .$id_transaccion.'</b></p><br>' ;
    $cuerpo .= '<p>El codigo de su compra en nuestra base de datos es <b>' .$id.'</b></p><br>' ;
    $cuerpo .= '<p>Total de la compra: <b>'.'$' .$total.' USD</b></p><br>' ;
    $cuerpo .= '<p>Pronto nos estaremos comunicando contigo para confirmarte la fecha y hora de entrega de tu pedido. <b>';

    $mail->Body    = utf8_decode($cuerpo) ;
    $mail->AltBody = 'Le enviamos los detalles de su compra.';
    $mail->setLanguage('es','../librerias/phpmailer/language/phpmailer.lang-es');
    $mail->send();
   
} catch (Exception $e) {
    echo "Error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
    //exit;
}
?>