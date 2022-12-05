<?php
   
    //session_start();
    require '../config/conexionBasesDatos.php';

    use PHPMailer\PHPMailer\{PHPMailer,SMTP,Exception};
    
    require '../librerias/phpmailer/src/PHPMailer.php';
    require '../librerias/phpmailer/src/SMTP.php';
    require '../librerias/phpmailer/src/Exception.php';

   //include '../captura.php';
   if(isset($_POST['recuperarPassword'])){
    $email = $_POST['Correo'];
    //$id_user = $_SESSION['id'];
    
    $sql = "SELECT * FROM usuarios WHERE correo_user  = '$email'";
    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc();
    if($row<=0){
        echo '
    <script>
        alert("El correo ingresado no está registrado en nuestra base de datos");
        window.location = "../vistas/login.php";
    </script>
    ';
   
    exit();
    }else{
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 
        function generate_string($input, $strength = 16) {
            $input_length = strlen($input);
            $random_string = '';
            for($i = 0; $i < $strength; $i++) {
                $random_character = $input[mt_rand(0, $input_length - 1)];
                $random_string .= $random_character;
            }
         
            return $random_string;
        }
         
        // Output: iNCHNGzByPjhApvn7XBD
         $password = generate_string($permitted_chars, 8);
         $contrasena = hash('sha512',$password);
         
         $sqlInsert = "UPDATE usuarios SET contrasena = '$contrasena' WHERE correo_user  = '$email'";
         $resultadoInsert = $conexion->query($sqlInsert);
         if($resultadoInsert <= 0){
            echo '
            <script>
                alert("Error al generar su nueva contraseña");
                window.location = "../vistas/login.php";
            </script>
            '; 
            
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
                $cuerpo = '<h4>El sistema la ha generado una nueva contraseña</h4>';
                $cuerpo .= '<p>Su nueva contraseña es <b>' .$password.'</b></p><br>' ;
                
                $cuerpo .= '<p>Recuerde que su contraseña es confidencial<b>';

                $mail->Body    = utf8_decode($cuerpo) ;
                $mail->AltBody = 'Le enviamos su nueva contraseña.';
                $mail->setLanguage('es','../librerias/phpmailer/language/phpmailer.lang-es');
                $mail->send();
                echo '
                <script>
                    alert("Revise su correo electronico");
                    window.location = "../vistas/login.php";
                </script>
                '; 
                
                exit();
            
            } catch (Exception $e) {
                //echo "Error al enviar el correo electronico: {$mail->ErrorInfo}";
                //print_r($mail->ErrorInfo);
                 echo '
                <script>
                    alert("Error al enviar el email, intente más tarde");
                    window.location = "../vistas/login.php";
                </script>
                '; 
                
                exit();
                
            }
                }

                
            }

                
                

   
?>