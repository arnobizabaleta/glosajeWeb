<?php
    require '../config/config.php';
    require '../config/database.php';
    if(!isset($_SESSION['id'])){
        header('Location: ../vistas/login.php');
    }
    if(isset($_GET['id'])){
        $idCategoria = $_GET['id'];
       
        $db = new Database();
        $con = $db->conectar();
        $sql = $con->prepare("DELETE FROM categorias  WHERE codCategoria = ?");
        $result =  $sql->execute([$idCategoria ]);
        if(!$result){
            die("Error al eliminar La categoria");
        }

        $_SESSION['message'] = "Caregoria eliminada exitosamente";
        $_SESSION['message_type'] = "danger";
        header("location: ../vistas/categorias.php");
    }
?>