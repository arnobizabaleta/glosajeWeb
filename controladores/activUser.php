<?php
    if(isset($_GET['id'])){
        $idUser = $_GET['id'];
        require '../config/config.php';
        require '../config/database.php';
        $db = new Database();
        $con = $db->conectar();
        $sql = $con->prepare("UPDATE usuarios SET activo = 1 WHERE idUser = ?");
        $result =  $sql->execute([$idUser]);
        if(!$result){
            $_SESSION['message'] = "Error al activar el usuario";
            $_SESSION['message_type'] = "danger";
            header("location: ../vistas/usuariosInactivos.php");
            exit();
            die();
        }

        $_SESSION['message'] = "Usuario activado exitosamente";
        $_SESSION['message_type'] = "success";
        header("location: ../vistas/usuariosInactivos.php");
    }
?>