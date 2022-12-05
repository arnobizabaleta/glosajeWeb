<?php
    require '../config/config.php';
    require '../config/database.php';
    $db = new Database();
    $con = $db->conectar();

    /* if(!isset($_SESSION['id'])){
        header('Location: login.php');//Redireccionando al login
    }
     */
    $id_cliente = $_SESSION['id'];

    $json = file_get_contents('php://input');
    $datos = json_decode($json, true);

    echo '<pre>';
    print_r($datos);
    echo '/<pre>';

    if(is_array($datos)){
        $id_transaccion = $datos['detalles']['id'];
        $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
        $fecha = $datos['detalles']['update_time'];
        $fecha_nueva = date('Y-m-d H:i:s',strtotime($fecha));
        $status = $datos['detalles']['status'];
        $email = $datos['detalles']['payer']['email_address'];
        $id_titular = $datos['detalles']['payer']['payer_id'];
        
        
        $sql = $con->prepare("INSERT INTO compras(id_transaccion,fecha, status, email,id_cliente,id_titular, total) VALUES(?,?,?,?,?,?,?)");
        $sql->execute([$id_transaccion,$fecha,$status,$email,$id_cliente,$id_titular,$total]);
        $id = $con->lastInsertId();
        print_r($id);
        print_r($id_cliente);
        if($id > 0){
           
            $productos = isset($_SESSION['carrito']['productos'])? $_SESSION['carrito']['productos']: null ;
            if($productos != null){
                foreach($productos as $clave => $cantidad){
            
                    $sql = $con->prepare("SELECT codProducto,nombre_producto,precio_producto, descuento FROM productos WHERE codProducto=? AND  activo=1");
                    $sql->execute([$clave]);
                    $row_prod= $sql->fetch(PDO::FETCH_ASSOC);//Trae los resultados del query por nombreDeColumna
                    
                   
                    $precio =   $row_prod['precio_producto'];
                    $descuento=   $row_prod['descuento'];
                    $precio_desc = $precio - (($precio*$descuento)/100);

                    $sql_insert = $con->prepare("insert into detalle_compra(cod_compra,cod_producto,nombre_producto,precio_producto, cantidad) VALUES(?,?,?,?,?)");
                    $sql_insert->execute([$id, $clave,$row_prod['nombre_producto'],$precio_desc,$cantidad]);
                }
                include 'enviar_email.php';
            }
            unset($_SESSION['carrito']);//Vaciar el carrito
           // header('location:../catalogo.php');

        }
    }

  
?>

