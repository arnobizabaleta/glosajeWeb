<?php
       require '../config/config.php';
       require '../config/database.php';
       require '../config/conexionBasesDatos.php';
        if(!isset($_SESSION['id'])){
            header('Location: ../vistas/login.php');
        }
        $cod_producto = $_POST['cod_producto'];
        $db = new Database();
        $con = $db->conectar();
        $sql = $con->prepare("SELECT * FROM  productos WHERE cod_producto = ?");
        $resultado =  $sql->execute([$cod_producto]);
        $row =  $sql->fetchAll(PDO::FETCH_ASSOC);
        
        //Verificando que el cod_producto introducido corresponda a uno registrado
        if($row > 0){
          $nombre_imagen = $_FILES['imagen']['name'];
          $tipo_imagen = $_FILES['imagen']['type'];
          $tamanho = $_FILES['imagen']['size'];
          if($tamanho <= 1000000){
          
              if($tipo_imagen == "image/jpeg"  || $tipo_imagen == "image/jpg"){
                  
          
                  $nombre_imagen = $_FILES['imagen']['name'];
                
                  $tipo_imagen = $_FILES['imagen']['type'];
                  
                  $tamanho = $_FILES['imagen']['size'];
                 
                 
                  //Ruta de la carpeta_destino en el servidor
                 $carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/glosajeWeb/assets/images/productos/' . $cod_producto . '/' ;
                 
                 
                 $carpetaTemporal = $_FILES['imagen']['tmp_name'];
                 
          
                 move_uploaded_file($_FILES['imagen']['tmp_name'],$carpeta_destino.$nombre_imagen);
                 $_SESSION['message'] = 'Imagen cargada exitosamente';
                 $_SESSION['message_type'] = 'success';
                header("Location: ../vistas/productos.php");
                exit();
  
              }else{
                  $_SESSION['message'] = "Tipo de imagen no permitida";
                  $_SESSION['message_type'] = 'danger';
                  header("Location: ../vistas/productos.php");
                exit();
              }
          }else{
              $_SESSION['message'] = "La img es muy grande";
              $_SESSION['message_type'] = 'danger';
              header("Location: ../vistas/productos.php");
                exit();
          }
          
        }else{
              $_SESSION['message'] = "No existe un producto asociado a ese codigo";
              $_SESSION['message_type'] = 'danger';
              header("Location: ../vistas/productos.php");
                exit();
        }
        
       
?>