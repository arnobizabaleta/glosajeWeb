<?php 
	
    require '../config/config.php';
    require '../config/database.php';
    require '../config/conexionBasesDatos.php';
    if(!isset($_SESSION['id'])){
        header('Location: login.php');//Redireccionando al login
    }
    $nombre= $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];

    //INFORME DE VENTAS
    $db = new Database();
    $con = $db->conectar();
    $sql = $con->prepare('SELECT cod_producto,nombre_producto,
    SUM(precio_producto * cantidad) AS total FROM
     detalle_compra');
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $totalVentas =  $row['total'];
    $_SESSION['totalVentas'] = $totalVentas;
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
                            <?php if($tipo_usuario == 2){ ?>
                            <a class="nav-link" href="usuarios.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Usuarios
                            </a>
                            <?php } else if($tipo_usuario == 1){?>
                            
                            <a class="nav-link" href="usuarios.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Mis datos
                            </a>
                            <?php } ?>
                            <a class="nav-link" href="seguridad.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-lock"></i></div>
                               Seguridad
                            </a>
                             <?php if($tipo_usuario == 2){ ?> 
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

                            
                            <?php if($tipo_usuario == 2){ ?>
                                <div class="sb-sidenav-menu-heading">Mis ventas</div>
                            <?php }else{ ?>
                                <div class="sb-sidenav-menu-heading">Mis compras</div>
                                <?php } ?>

                                <?php if($tipo_usuario == 2){ ?>
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
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="container-fluid px-4">
                    <div class="card mb-4">
                        <div class="card-header">
                                <i class="fas fa-user"></i> <strong><?php echo"$nombre"; ?> </strong>, Bienvenido a GlosajeWeb
                        </div>
                        <?php if($tipo_usuario == 2){ ?>
                                <p class="mb-4 mt-4 ms-4">Tú eres administrador en nuestro sistema</p>
                        <?php }else{ ?>
                        
                            <p class="mb-4 mt-4 ms-4">Tú eres cliente en nuestro sistema</p>
                        <?php } ?>
                    </div>
                </div>

                <?php if($tipo_usuario == 2){ ?>
                    <div class="container-fluid px-4">
                    <div class="card mb-4">
                        <div class="card-header">
                        <i class="fas fa-dollar-sign me-2"></i> Informe de Ventas
                        </div>
                        <div class="card-body">
                        
                        <i class="fas fa-dollar-sign me-2"></i> Total Vendido:<b> <?php echo '$' . number_format($totalVentas,2,'.',',') ; ?> USD </b> 
                        <p>Bucar las ventas de un producto por su código</p>
                        <form action="./infoVentaProduc.php" method="post">
                            <div class="form-group mb-4">
                                <input type="number" class="form-control" placeholder="codigo Producto" name="cod_producto"  required="required" autofocus>

                            </div>
                            <input type="submit" class="btn btn-primary"value="Consultar" name="InfoProduct">
                        <form>
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
