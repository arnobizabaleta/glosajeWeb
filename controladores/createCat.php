<?php
    
    require '../config/config.php';
    require '../config/database.php';
    if(!isset($_SESSION['id'])){
        header('Location: ../vistas/login.php');
    }
    if(isset($_POST['createCat'])){
        $nombre = $_POST['nombre'];
       
       
       
       
        $db = new Database();
        $con = $db->conectar();

        $sql = $con->prepare("INSERT INTO categorias(nombre_categoria) VALUES(?)");
        $sql->execute([$nombre]);
        $id_categoria= $con->lastInsertId();
        if($id_categoria  <= 0){
            die("Error al agregar el nuevo producto");
        }
        $_SESSION['message'] = "Categoria agregada exitosamente";
        $_SESSION['message_type'] = "success";
        header("location: ../vistas/categorias.php");

    }
?>