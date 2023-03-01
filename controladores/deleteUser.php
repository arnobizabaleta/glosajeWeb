<?php
    if(isset($_GET['id'])){
        $id_user = $_GET['id'];
        require '../config/config.php';
        require '../config/database.php';
        $db = new Database();
        $con = $db->conectar();
        $sql = $con->prepare("UPDATE usuarios SET activo = 0 WHERE id_user = ?");
        $result =  $sql->execute([$id_user]);
        if(!$result){
            die("Error al eliminar el usuario");
        }

        $_SESSION['message'] = "Usuario inactivado exitosamente";
        $_SESSION['message_type'] = "danger";
        header("location: ../vistas/usuarios.php");
    }
?>