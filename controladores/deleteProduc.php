<?php
    require '../config/conexionBasesDatos.php';

    if(!isset($_SESSION['id'])){
        header('Location: ../vistas/login.php');
    }

    if(isset($_GET['id'])){
        $idProducto = $_GET['id'];
        require '../config/config.php';
        require '../config/database.php';
        $db = new Database();
        $con = $db->conectar();
        $sql = $con->prepare("UPDATE productos SET activo = 0 WHERE cod_producto = ?");
        $result =  $sql->execute([$idProducto]);
        if(!$result){
            die("Error al eliminar el producto");
        }

        $_SESSION['message'] = "Producto inactivado exitosamente";
        $_SESSION['message_type'] = "danger";
        header("location: ../vistas/productos.php");
    }
?>