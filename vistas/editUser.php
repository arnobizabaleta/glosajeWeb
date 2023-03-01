<?php
    require '../config/conexionBasesDatos.php';
    require '../config/config.php';
    require '../config/database.php';

    if(!isset($_SESSION['id'])){
        header('Location: ./ login.php');
    } 
        $id_userNaving = $_SESSION['id'];
        $contrasenaDesencryptada =  $_SESSION['Contrasena'] ;
        $nombre = $_SESSION['nombre'];
        $tipo_usuario = $_SESSION['tipo_usuario'];

        if(isset($_GET['id'])){
            $id_user = $_GET['id'];
            

            $db = new Database();
            $con = $db->conectar();
            $sql = $con->prepare("SELECT id_user,nombres_usuario,apellidos_usuario,correo_user,contrasena, tel_user, municipio,comuna_barrio,direccion_exacta,rol,activo FROM usuarios WHERE id_user = ?");
            $result =  $sql->execute([$id_user]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            
            if($row > 0){
                //echo "Puedes editar el producto: " . $row['cod_producto'];
                //echo "Puedes editar el producto: " . $row['cod_producto'];
                $id_user = $row['id_user'];
                $nombres_usuario = $row['nombres_usuario'];
                $apellidos_usuario = $row['apellidos_usuario'];
                $correo_user = $row['correo_user'];
                $contrasena_user = $row['contrasena'];
                $contrasena = $row['contrasena'];
                $tel_user = $row['tel_user'];
                $municipio = $row['municipio'];
                $comuna_barrio = $row['comuna_barrio'];
                
                $direccion_exacta = $row['direccion_exacta'];
                $rol = $row['rol'];
                $activo = $row['activo'];
    
            }
           
    
           

    
        }
        $_SESSION['message'] = "Estas a punto de editar un usuario";

   
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Glosaje Web</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../assets/css/admin.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="./catalogo.php">GlosajeWeb</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form> -->
            <!-- Navbar--> 
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $nombre ?><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Ajustes</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="../controladores/cerrarSesion.php">Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Resumen</div>
                            <a class="nav-link" href="./micuenta.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <?php if($tipo_usuario == 2){ ?>
                            <a class="nav-link" href="./usuarios.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Usuarios
                            </a>
                            <?php } else if($tipo_usuario == 1){?>
                            
                            <a class="nav-link" href="./usuarios.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Mis datos
                            </a>

                            <?php }?>

                            <a class="nav-link" href="seguridad.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-lock"></i></div>
                               Seguridad
                            </a>
                            
                            <?php if($tipo_usuario == 2){ ?> 
                            <div class="sb-sidenav-menu-heading">Mantenimiento</div>
                            <a class="nav-link" href="./categorias.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Categorias
                                
                            </a>
                            <a class="nav-link" href="./productos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                                Productos
                                
                            </a>
                               
                            <?php }?>
                            
                            

                            
                            
                            <?php if($tipo_usuario == 2){ ?>
                                <div class="sb-sidenav-menu-heading">Mis ventas</div>
                            <?php }else{ ?>
                                <div class="sb-sidenav-menu-heading">Mis compras</div>
                                <?php } ?>

                                <?php if($tipo_usuario == 2){ ?>
                            <a class="nav-link" href="./detalleCompra.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                                Detalles 
                            </a>
                            <?php } ?>
                            

                                
                          
                            
                            <a class="nav-link" href="./vistas//factura.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-dollar-sign"></i></div>
                                Facturas
                            </a>
                           
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                       <?php echo"$nombre"; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                <div class="loader"></div>
                <ol class="breadcrumb mb-4 mt-4 ms-4">
                    <li class="breadcrumb-item"><a href="./micuenta.php">Mantenimiento</a></li>
                    <li class="breadcrumb-item active">Usuarios</li>
                </ol>
                <div class="container px-4 mx-auto">
                       
                       <div class="row">
                            <div class="col mb-4">
                           
                                            
                            <div class="card-header">
                                       <i class="fas fa-users"></i>Editar Usuario
                                   </div>
                                   <div class="card card-body">
                                       <form action="./editUser.php?id=<?php echo  $id_user; ?>" method="post">
                                           
             
                                            <div class="form-group mb-4">
                                           <input type="text" class="form-control" placeholder="Nombre Completo" name="nombres_usuarioUp" value="<?php echo $nombres_usuario; ?>"  required="required" autofocus>

                                           </div>
                                           <div class="form-group mb-4">
                                           <input type="text" class="form-control" placeholder="Apellidos" name="apellidos_usuarioUp" value="<?php echo $apellidos_usuario; ?>"  required="required" autofocus> 
                                             
                                           </div>

                                           <div class="form-group mb-4">
                                                <input type="email" class="form-control" placeholder="Correo Electronico" name="correo_userUp" value="<?php echo $correo_user; ?>"  required="required" autofocus>

                                           </div>
                                           <!-- <?php if($id_userNaving == $id_user){?>
                                           <div class="form-group mb-4">
                                           <input type="password"  class="form-control" placeholder="Contraseña" name="contrasenaUp"  value="<?php echo $contrasena; ?>" required="required" autofocus>

                                           </div>
                                           <?php } ?> -->
                                           <div class="form-group mb-4">
                                           <input type="number" placeholder="Telefono" class="form-control" name="tel_userUp" value="<?php echo $tel_user; ?>"  required="required" autofocus> 
                                            
                                           </div>

                                         
                                           <div class="form-group mb-4">
                                          
                                           <select class="form-select" name="municipioUp" aria-label="Default select example"  value="<?php echo $municipio; ?>" required="required">
                                          
                                                    <option selected value="<?php echo $municipio; ?>"><?php echo $municipio; ?></option>
                                                    <option value="Caldas">Caldas</option>
                                                    <option value="La Estrella">La Estrella</option>
                                                    <option value="Sabaneta">Sabaneta</option>
                                                    <option value="Envigado">Envigado</option>
                                                    <option value="Itagui">Itagüí </option>
                                                    <option value="Medellin">Medellín</option>
                                                    <option value="Bello">Bello</option>
                                                    <option value="Copacabana">Copacabana</option>
                                                    <option value="Girardota">Girardota</option>
                                                    <option value="Barbosa">Barbosa</option>
                                                  
                                           </select>
                                           

                                           </div>

                                           <div class="form-group mb-4">
                                          
                                          <select class="form-select" name="comuna_barrioUp" aria-label="Default select example" value="<?php echo $comuna_barrio; ?>"  required="required">
                                         
                                                   <option selected value="<?php echo $comuna_barrio; ?>"><?php echo $comuna_barrio; ?></option>
                                                   <option value="Popular">Popular</option>
                                                    <option value="Santa Cruz">Santa Cruz</option>
                                                    <option value="Manrique">Manrique</option>
                                                    <option value="Aranjuez">Aranjuez</option>
                                                    <option value="Castilla">Castilla </option>
                                                    <option value="Doce de Octubre">Doce de Octubre</option>
                                                    <option value="Robledo">Robledo</option>
                                                    <option value="Villa Hermosa">Villa Hermosa</option>
                                                    <option value="Buenos Aires">Buenos Aires</option>
                                                    <option value="Laureles-Estadio">Laureles-Estadio</option>
                                                    <option value="La América">La América</option>
                                                    <option value="San Javier">San Javier</option>
                                                    <option value="Poblado">Poblado</option>
                                                    <option value="Guayabal">Guayabal</option>
                                                    <option value="Belén">Belén</option>
                                                    <option value="Otra">Otro(a)</option>
                                                 
                                          </select>
                                          

                                          </div>
                                          <div class="form-group mb-4">
                                            <input type="text" class="form-control" placeholder="Dirección Exacta" name="direccion_exactaUp" value="<?php echo $direccion_exacta; ?>" required="required"> 
                                          </div>
                                            <?php if($tipo_usuario == 2){ ?>
                                          <div class="form-group mb-4">
                                            <select class="form-select" name="rolUp" aria-label="Default select example" value="<?php echo $rol; ?>"  required="required">
                                                <option selected value="<?php echo $rol; ?>"> <?php if($rol == 1){ echo "Cliente";}else{echo"Administrador";}; ?></option>
                                                <option  value="1">Cliente</option>
                                                <option  value="2">Administrador</option>
                                            </select>
                                        </div>  
                                        <?php }?>
                                           <input type="submit" class="btn btn-primary"value="Editar Usuario" name="update">
                                           <a href="./usuarios.php" class="btn btn-secondary" >Regresar al menu</a>
                                       </form>
                                   </div>
                                <?php if(isset($_POST['update'])){ ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            Usuario editado exitosamente
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php }?>
                                <?php $_SESSION['message'] = null ?>
                           </div>
                       </div>
                   </div>

                    
              

                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; GlosajeWeb 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../assets/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json"></script>
       
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../assets/js/datatables-simple-demo.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script type="text/javascript">
          $(window).load(function() {
              $(".loader").fadeOut("slow");
          });
        </script>  
    </body>
</html>



<?php 

      
    
    
       
//ACTUALIZAR 
if(isset($_POST['update'])){
    //echo 'Actualizando';
    
                $nombres_usuarioUp = $_POST['nombres_usuarioUp'];
                $apellidos_usuarioUp = $_POST['apellidos_usuarioUp'];
                $correo_userUp = $_POST['correo_userUp'];
                //$contrasena_userUp = $_POST['contrasenaUp'];
               // $contrasenaUp = hash('sha512',$contrasena_userUp);
                $tel_userUp = $_POST['tel_userUp'];
                $municipioUp = $_POST['municipioUp'];
                $comuna_barrioUp = $_POST['comuna_barrioUp'];
                $direccion_exactaUp = $_POST['direccion_exactaUp'];
                $rolUp = $_POST['rolUp'];
    
                if($tipo_usuario == 2){
                    $sql_update = $con->prepare("UPDATE usuarios SET nombres_usuario = ?, apellidos_usuario = ?,correo_user = ?, tel_user = ? , municipio = ?, comuna_barrio = ?, direccion_exacta = ?, rol = ?  WHERE id_user = ?");
                    $result_update =  $sql_update->execute([$nombres_usuarioUp,$apellidos_usuarioUp,$correo_userUp,$tel_userUp,$municipioUp ,$comuna_barrioUp,$direccion_exactaUp,$rolUp,$row['id_user']]);
                    $row_uptate = $sql_update->fetch(PDO::FETCH_ASSOC);
                }else if($tipo_usuario == 1){
                    $sql_update = $con->prepare("UPDATE usuarios SET nombres_usuario = ?, apellidos_usuario = ?,correo_user = ?, tel_user = ? , municipio = ?, comuna_barrio = ?, direccion_exacta = ?  WHERE id_user = ?");
                    $result_update =  $sql_update->execute([$nombres_usuarioUp,$apellidos_usuarioUp,$correo_userUp,$tel_userUp,$municipioUp ,$comuna_barrioUp,$direccion_exactaUp,$row['id_user']]);
                    $row_uptate = $sql_update->fetch(PDO::FETCH_ASSOC);

                }
    
    if($result_update){
        $_SESSION['message'] = "Usuario editado exitosamente";
        $_SESSION['message_type'] = "success";
        //header("location: ../productos.php");
        
        exit();
    }else{
        die("Error al actualizar el producto");
    } 
} 





?>


