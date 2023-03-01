<?php
    require '../config/conexionBasesDatos.php';
    require '../config/config.php';
    require '../config/database.php';

    if(!isset($_SESSION['id'])){
        header('Location: ../vistas/login.php');
    } 

        $nombre = $_SESSION['nombre'];
        if(isset($_POST['changePass'])){
            
            $id_user = $_SESSION['id'];
            $contrasena = $_POST["contrasenaActual"];
            $_SESSION['Contrasena'] = $_POST["contrasenaActual"];
            $contrasenaNueva= $_POST["contrasenaNueva"];
            $contrasenaNueva2 = $_POST["contrasenaNueva2"];
            
           
            //Encryptar Contraseña
            $contrasena = hash('sha512',$contrasena);
            $contrasenaNueva =  hash('sha512',$contrasenaNueva);
            $contrasenaNueva2 = hash('sha512',$contrasenaNueva2);
            //Verificar que el usuario con ese email y password exista en la DATABASE
            $query = "SELECT * FROM usuarios WHERE  id_user = '$id_user' AND contrasena = '$contrasena'";
            $validar_Contrasena = mysqli_query($conexion,$query);



//Si hay una fila o registro de la ejecucion de la consulta anterior
            if(mysqli_num_rows($validar_Contrasena) <= 0){    
                $_SESSION['message'] = "Contraseña incorrecta";
                $_SESSION['message_type'] = "danger";

                header("location: ../vistas/seguridad.php");
                exit();
                die();
            } else if($contrasenaNueva != $contrasenaNueva2){
                $_SESSION['message'] = "Las nuevas contraseñas no coinciden";
                $_SESSION['message_type'] = "danger";

                header("location: ../vistas/seguridad.php");
                exit();
                die();
            }else if(($contrasena == $contrasenaNueva) || ($contrasena == $contrasenaNueva2) ){
                $_SESSION['message'] = "Las nueva contraseña debe ser diferente a la actual";
                $_SESSION['message_type'] = "danger";

                header("location: ../vistas/seguridad.php");
                exit();
                die();
            }else{
                $db = new Database();
                        $con = $db->conectar();
                        $sql = $con->prepare("UPDATE usuarios SET contrasena = ? WHERE id_user = ?");
                        $result =  $sql->execute([$contrasenaNueva,$id_user]);
                        $row = $sql->fetch(PDO::FETCH_ASSOC);
                        
                        
                            
                            $_SESSION['message'] = "Contraseña cambiada exitosamente";
                            $_SESSION['message_type'] = "success";

                            header("location: ../vistas/seguridad.php");
                            exit();
                            
                            
                
                        
            }     
            
           
    
           

    
        }
       

   
?>

