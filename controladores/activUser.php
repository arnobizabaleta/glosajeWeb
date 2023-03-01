<?php
    if(isset($_GET['id'])){
        $id_user = $_GET['id'];
        require '../config/config.php';
        require '../config/database.php';
        $db = new Database();
        $con = $db->conectar();
        $sql = $con->prepare("UPDATE usuarios SET activo = 1 WHERE id_user = ?");
        $result =  $sql->execute([$id_user]);
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