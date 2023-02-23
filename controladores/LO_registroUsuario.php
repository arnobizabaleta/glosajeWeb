<?php
     /*
    Hacemos el llamado al archivo que contiene los valores 
    parametros para conectarnos a la base de datos
*/

require '../config/conexionBasesDatos.php';

    
    $idUser = $_POST["idUser"];
    $nombre_completo = $_POST["Nombre_Completo"];
    $apellidos = $_POST["Apellidos"];
    $correo = $_POST["Correo"];
    $contrasena = $_POST["Contrasena"];
    $tel_user = $_POST["tel_user"];
    //$departamento = $_POST["departamento"];
    $municipio = $_POST["municipio"];
    $comuna_barrio = $_POST["comuna_barrio"];
    //LOGICA COMUNA_BARRIO SI NO EXISTE
    if($comuna_barrio == "Otra"){
        $comuna_barrio = $_POST["otro2"];
    }
    
    $direccion_exacta = $_POST["direccion_exacta"];
    //Encryptar Contraseña
    $contrasena = hash('sha512',$contrasena);

     //Generar token de seguridad cada usuario
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

    $token = generate_string($permitted_chars, 8);

    $query = "INSERT INTO usuarios(idUser,nombres_usuario,apellidos_usuario,correo_user,
    contrasena,tel_user,municipio,comuna_barrio,direccion_exacta, token) 
    VALUES('$idUser','$nombre_completo','$apellidos','$correo','$contrasena','$tel_user',
    '$municipio',' $comuna_barrio','$direccion_exacta', '$token')";

//Verificar que la ID del usuario no se repita
$verificar_idUser = mysqli_query($conexion,"SELECT * FROM usuarios WHERE idUser = '$idUser'");
//Si hay una fila o registro de la ejecucion de la consulta anterior
if(mysqli_num_rows($verificar_idUser) > 0){
  
    echo '
    <script>
        alert("El usuario con este nro de Identidad ya se encuentra registrado");
        window.location = "../vistas/login.php";
        </script>
    ';
    exit();//Saliendo del script actual 
}   

//Verificar que el correo no se repita
$verificar_correo = mysqli_query($conexion,"SELECT * FROM usuarios WHERE correo_user = '$correo'");
//Si hay una fila o registro de la ejecucion de la consulta anterior
if(mysqli_num_rows($verificar_correo) > 0){
    echo '
        <script>
        alert("Este correo ya está registrado, intenta con otro diferente");
        window.location = "../vistas/login.php";
        </script>
    ';
    exit();//Saliendo del script actual 
}

//Verificar que el formato de  correo sea valido

if (!(filter_var($correo, FILTER_VALIDATE_EMAIL))) {
    echo '
    <script>
        alert("Intentalo de nuevo, el correo es inválido");
        window.location = "../vistas/login.php";
    </script>
';
exit();//Saliendo del script actual
}

    //session_start();
    
    //$_SESSION['id'] = $idUser;
    //$_SESSION['correoRegistro'] = $correo;

   
     
   

    //Registrar usuario inactivo
    $ejecutar = mysqli_query($conexion,$query);

    if($ejecutar){
//Si se registro el usuario
        //Enviar correo electronico de bienvenida y activar cuenta

    require '../controladores/Mailer.php';
    $mailer = new Mailer();
    $url = 'http://localhost/glosajeweb/controladores' . '/activar_cliente.php?id=' . $idUser . '&token=' . $token;
    $asunto = 'Activar Cuenta - GlosajeWeb';
    $cuerpo = "Estimado $nombre_completo: <br> Para continuar con el proceso de registro es indispensable de click en el siguiente 
    enlace <a href='$url'>Activar cuenta</a>" ;
   // include "email_bienvenida.php";


   if($mailer->enviar_email($correo,$asunto,$cuerpo)){
    echo '
    <script>
    alert("Para terminar el proceso de inscripción, siga las instrucciones que le hemos enviado en el correo registrado");
    window.location = "../vistas/login.php";
    </script>
';

exit();//Saliendo del script actual 
    
   }else{

    echo '
    <script>
        alert("Intentalo de nuevo, el correo es inválido");
        window.location = "../vistas/login.php";
    </script>
';
exit();//Saliendo del script actual
   }
    }else{
        echo '
        <script>
            alert("Intentalo de nuevo, el usuario no ha sido almacenado");
            window.location = "../vistas/login.php";
        </script>';
        exit();

    }
    
   

   

/*

    $ejecutar = mysqli_query($conexion,$query);

    if($ejecutar){
        
        echo '
            <script>
                alert("Ususario Almacenado exitosamente");
                window.location = "../vistas/login.php";
            </script>
        ';
    }
    else{
        echo '
        <script>
            alert("Intentalo de nuevo, el usuario no ha sido almacenado");
            window.location = "../vistas/login.php";
        </script>
    ';
    }

   

*/


//session_destroy();
mysqli_close($conexion); //Cerrando la conexión

?>