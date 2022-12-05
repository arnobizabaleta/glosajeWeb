<?php
    if(isset($_GET['id'])){
        $idUser = $_GET['id'];
        require '../config/config.php';
        require '../config/database.php';
        $db = new Database();
        $con = $db->conectar();
        $sql = $con->prepare("UPDATE usuarios SET activo = 0 WHERE idUser = ?");
        $result =  $sql->execute([$idUser]);
        if(!$result){
            die("Error al eliminar el usuario");
        }

        $_SESSION['message'] = "Usuario inactivado exitosamente";
        $_SESSION['message_type'] = "danger";
        header("location: ../vistas/usuarios.php");
    }
?>