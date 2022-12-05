<?php
    session_start();
    require '../config/conexionBasesDatos.php';

    if(!isset($_SESSION['id'])){
        header('Location: login.php');
    }
    
    $id = $_SESSION['id'];
    $nombre = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
    
    
    if($tipo_usuario == 'Administrador'){
        $sql = "SELECT * FROM usuarios WHERE activo = 1";
        
    }else if($tipo_usuario == 'Cliente'){
        $sql = "SELECT * FROM usuarios WHERE idUser = $id";
    }

   
    
    $resultado = $conexion->query($sql);
   
//USUARIOS INACTIVOS
$sqlInact = "SELECT * FROM usuarios WHERE activo = 0";
$resultadInact = $conexion->query($sqlInact);

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
            <a class="navbar-brand ps-3" href="catalogo.php">GlosajeWeb</a>
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
                            <a class="nav-link" href="micuenta.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <?php if($tipo_usuario == 'Administrador'){ ?>
                            <a class="nav-link" href="usuarios.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Usuarios
                            </a>
                            <?php } else if($tipo_usuario == 'Cliente'){?>
                            
                            <a class="nav-link" href="usuarios.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Mis datos
                            </a>
                            <?php } ?>
                            <a class="nav-link" href="seguridad.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-lock"></i></div>
                               Seguridad
                            </a>
                             <?php if($tipo_usuario == 'Administrador'){ ?> 
                            <div class="sb-sidenav-menu-heading">Mantenimiento</div>
                            <a class="nav-link" href="categorias.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Categorias
                                
                            </a>
                            <a class="nav-link" href="productos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                                Productos
                                
                            </a>
                            
                            
                               
                    
                            
                             <?php }?> 

                            
                            <?php if($tipo_usuario == 'Administrador'){ ?>
                                <div class="sb-sidenav-menu-heading">Mis ventas</div>
                            <?php }else{ ?>
                                <div class="sb-sidenav-menu-heading">Mis compras</div>
                                <?php } ?>

                                <?php if($tipo_usuario == 'Administrador'){ ?>
                            <a class="nav-link" href="detalleCompra.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                                Detalles 
                            </a>
                            <?php } ?>
                            <a class="nav-link" href="factura.php">
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
                    <li class="breadcrumb-item"><a href="micuenta.php">Resumen</a></li>
                    <li class="breadcrumb-item active">Usuarios</li>
                </ol>
                <div class="container-fluid px-4">
                       
                       
                        
                        <div class="card mb-4">
                        <?php if($tipo_usuario == 'Administrador'){ ?>
                        <div class="card-header">
                            <i class="fas fa-users me-1"></i>Lista de Usuarios
                        </div>
                        <?php }else if($tipo_usuario == 'Cliente'){ ?>
                            <div class="card-header">
                            <i class="fas fa-user me-1"></i>Mis datos
                        </div>
                        <?php } ?>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Correo</th>
                                            <th>Telefono</th>
                                            <th>Municipio</th>
                                            <th>Comuna</th>
                                            <th>Direccion</th>
                                            <th>Tipo Usuario</th>
                                            <th>Acciones</th>
                                            
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Correo</th>
                                            <th>Telefono</th>
                                            <th>Municipio</th>
                                            <th>Comuna</th>
                                            <th>Direccion</th>
                                            <th>Tipo Usuario</th>
                                            <th>Acciones</th>
                                            
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                        <?php while($row = $resultado->fetch_assoc()) { ?>
                                       <tr>
                                        <td><?php echo $row['idUser']; ?></td>
                                        <td><?php echo $row['nombres_usuario']; ?></td>
                                        <td><?php echo $row['apellidos_usuario']; ?></td>
                                        <td><?php echo $row['correo_user']; ?></td>
                                        <td><?php echo $row['tel_user']; ?></td>
                                        <td><?php echo $row['municipio']; ?></td>
                                        <td><?php echo $row['comuna_barrio']; ?></td>
                                        <td><?php echo $row['direccion_exacta']; ?></td>
                                        <td><?php echo $row['rol']; ?></td>
                                        <td>
                                            <a href="./editUser.php?id=<?php echo  $row['idUser']; ?>" class="btn btn-primary">
                                                <i class="fas fa-marker"></i>
                                            </a>
                                           <?php if($tipo_usuario == 'Administrador'){ ?>
                                            <a href="../controladores/deleteUser.php?id=<?php echo  $row['idUser']; ?>" class="btn btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <?php }?>
                                        </td>    
                                       </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php if($tipo_usuario == 'Administrador'){ ?>
                    
                    <div class="container px-4 mx-auto">   
                       <div class="row">
                            <div class="col mb-4">
                                           <?php if(isset($_SESSION['message']) && $_SESSION['message'] != null ){ ?>
                                               <div class="alert alert-<?php echo  $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
                                                   <?php echo $_SESSION['message'] ?>
                                               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                               </div>
                                           <?php }?>
                                           <?php $_SESSION['message'] = null; ?>
                                   <div class="card-header">
                                       <i class="fas fa-users"></i>Agregar Usuario
                                   </div>
                                   <div class="card card-body">
                                       <form action="../controladores/createUser.php" method="post">
                                           
                                            <div class="form-group mb-4">
                                                <input type="number" class="form-control" placeholder="Identificación" name="idUser"  required="required" autofocus>

                                           </div>
                                            <div class="form-group mb-4">
                                           <input type="text" class="form-control" placeholder="Nombre Completo" name="nombres_usuario"  required="required" autofocus>

                                           </div>
                                           <div class="form-group mb-4">
                                           <input type="text" class="form-control" placeholder="Apellidos" name="apellidos_usuario"  required="required" autofocus> 
                                             
                                           </div>

                                           <div class="form-group mb-4">
                                                <input type="email" class="form-control" placeholder="Correo Electronico" name="correo_user"  required="required" autofocus>

                                           </div>
                                           <div class="form-group mb-4">
                                           <input type="password"  class="form-control" placeholder="Contraseña" name="contrasena"  required="required" autofocus>

                                           </div>

                                           <div class="form-group mb-4">
                                           <input type="number" placeholder="Telefono" class="form-control" name="tel_user"  required="required" autofocus> 
                                            
                                           </div>

                                         
                                           <div class="form-group mb-4">
                                          
                                           <select class="form-select" name="municipio" aria-label="Default select example" required="required">
                                          
                                                    <option selected value="Medellin">Municipio</option>
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
                                          
                                          <select class="form-select" name="comuna_barrio" aria-label="Default select example" required="required">
                                         
                                                   <option selected value="Otro(a)">Comuna</option>
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
                                            <input type="text" class="form-control" placeholder="Dirección Exacta" name="direccion_exacta"  required="required"> 
                                          </div>


                                           <input type="submit" class="btn btn-primary"value="Agregar usuario" name="createUser">
                                       </form>
                                   </div>
                           </div>
                       </div>
                       </div>
                                          <?php  }?>
                                      
                
                    <div class="container-fluid px-4">
                       
                       
                        
                       <div class="card mb-4">
                       <?php if($tipo_usuario == 'Administrador'){ ?>
                       <div class="card-header">
                           <i class="fas fa-users me-1"></i> <a href="usuariosInactivos.php" class="btn btn-danger">Lista de Usuarios Inactivos</a>
                       </div>
                       
                       
                    
                       </div>
                   </div>         
                   
                   <?php } ?>
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
