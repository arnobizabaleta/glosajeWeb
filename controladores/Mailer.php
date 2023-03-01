<?php
     use PHPMailer\PHPMailer\{PHPMailer,SMTP,Exception};

     class Mailer {

        function enviar_email($email, $asunto, $cuerpo){
            require '../librerias/phpmailer/src/PHPMailer.php';
            require '../librerias/phpmailer/src/SMTP.php';
            require '../librerias/phpmailer/src/Exception.php';

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
    $mail->Subject = $asunto ;
     

    $mail->Body = utf8_decode($cuerpo) ;
   
    $mail->setLanguage('es','../librerias/phpmailer/language/phpmailer.lang-es');

    if($mail->send()){
        return true;
    }else{
        return false;
    }

  
   
    
   
} catch (Exception $e) {
    echo "Error al enviar el correo electronico de bienvenida: {$mail->ErrorInfo}";
    
    return false;
    
    
}
        }

        
     }
?>