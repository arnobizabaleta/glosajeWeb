<?php
require '../config/config.php';
require '../config/database.php';
require '../config/conexionBasesDatos.php';
if(!isset($_SESSION['id'])){
    header('Location: ../vistas/login.php');
}

    if(isset($_POST['createUser'])){
        $idUser = $_POST['idUser'];
        $nombres_usuario = $_POST['nombres_usuario'];
        $apellidos_usuario = $_POST['apellidos_usuario'];
        $correo_user = $_POST['correo_user'];
        $contrasena_user = $_POST['contrasena'];
        $contrasena = hash('sha512',$contrasena_user);
        $tel_user = $_POST['tel_user'];
        $municipio = $_POST['municipio'];
        $comuna_barrio = $_POST['comuna_barrio'];
        $direccion_exacta = $_POST['direccion_exacta'];
        
       
       
        

        //Verificar que la ID del usuario no se repita
        $verificar_idUser = mysqli_query($conexion,"SELECT * FROM usuarios WHERE idUser = '$idUser'");
        //Si hay una fila o registro de la ejecucion de la consulta anterior
        if(mysqli_num_rows($verificar_idUser) > 0){
        
            $_SESSION['message'] = "El usuario con este nro de Identidad ya se encuentra registrado";
            $_SESSION['message_type'] = "danger";
        
            header("location: ../vistas/usuarios.php");
            exit();
        }   

        $verificar_correo = mysqli_query($conexion,"SELECT * FROM usuarios WHERE correo_user = '$correo_user'");
        //Si hay una fila o registro de la ejecucion de la consulta anterior
            if(mysqli_num_rows($verificar_correo) > 0){
                $_SESSION['message'] = "Este correo ya está registrado, intenta con otro diferente";
                $_SESSION['message_type'] = "danger";
        
            header("location: ../vistas/usuarios.php");
            exit();
            }

        $db = new Database();
        $con = $db->conectar();
        $sql = $con->prepare("INSERT INTO usuarios(idUser,nombres_usuario,apellidos_usuario,correo_user,contrasena, tel_user, municipio,comuna_barrio,direccion_exacta) VALUES(?,?,?,?,?,?,?,?,?)");
        $resultado =  $sql->execute([$idUser, $nombres_usuario,$apellidos_usuario,$correo_user,$contrasena,$tel_user,$municipio,$comuna_barrio,$direccion_exacta]);
       
        $id_nuevaProducto= $con->lastInsertId();
        if($resultado <= 0){
            $_SESSION['message'] = "Error al agregar el nuevo usuario";
            $_SESSION['message_type'] = "danger";
           
            header("location: ../vistas/usuarios.php");
            exit();
            //die("Error al agregar el nuevo usuario");
        }
        else{
            $_SESSION['message'] = "Usuario agregado exitosamente";
            $_SESSION['message_type'] = "success";
            header("location: ../vistas/usuarios.php");
        }

    }
?>