<?php
    require '../config/config.php';
    require '../config/database.php';
    if(!isset($_SESSION['id'])){
        header('Location: login.php');
    }
    
   if(isset($_POST['createProd'])){
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $descuento = $_POST['descuento'];
        $idCategoria = (int)$_POST['idCategoria'];
       
       
       
        $db = new Database();
        $con = $db->conectar();
        $sql = $con->prepare("INSERT INTO productos(nombre_producto,descripcion,precio_producto,descuento, cod_categoria) VALUES(?,?,?,?,?)");
        $sql->execute([$nombre, $descripcion,$precio,$descuento,$idCategoria]);
        $id_nuevaProducto= $con->lastInsertId();
        if($id_nuevaProducto  <= 0){
            die("Error al agregar el nuevo producto");
        }
        $dir_images = '../assets/images/productos/'.$id_nuevaProducto.'/';
            
        //Creando la carpeta de imagenes del producto si no existe
         if (!file_exists($dir_images)) {
             mkdir($dir_images, 0777, true);
         }
        $_SESSION['message'] = "Producto agregado exitosamente";
        $_SESSION['message_type'] = "success";
        header("location: ../vistas/productos.php");

    }
?>