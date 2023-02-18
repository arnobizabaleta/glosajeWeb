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


    $query = "INSERT INTO usuarios(idUser,nombres_usuario,apellidos_usuario,correo_user,
    contrasena,tel_user,municipio,comuna_barrio,direccion_exacta) 
    VALUES('$idUser','$nombre_completo','$apellidos','$correo','$contrasena','$tel_user',
    '$municipio',' $comuna_barrio','$direccion_exacta')";

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

session_start();
    $_SESSION['error'] == null;
    $_SESSION['id'] = $idUser;
    $_SESSION['correoRegistro'] = $correo;
    include "email_bienvenida.php";

if(($_SESSION['error'] == null)){
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
}else{
    echo '
    <script>
        alert("Intentalo de nuevo, el correo es inválido");
        window.location = "../vistas/login.php";
    </script>
';
}



$_SESSION['error'] = null;
mysqli_close($conexion); //Cerrando la conexión

?>