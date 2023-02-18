<?php
    session_start();
    require '../config/conexionBasesDatos.php';

    if(!isset($_SESSION['id'])){
        header('Location: login.php');
    }
    $id = $_SESSION['id'];
    $nombre = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
    
    
    if($tipo_usuario == 2){
        $sql = "SELECT codProducto,nombre_producto, descripcion,precio_producto,descuento, c.nombre_categoria AS categoria,p.activo FROM productos p INNER JOIN categorias c ON p.cod_categoria = c.codCategoria;";
        
    }else if($tipo_usuario == 1){
        header('Location: micuenta.php');
    }

   
    
    $resultado = $conexion->query($sql);
   
$tipo_usuario = $_SESSION['tipo_usuario'];



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
        <style>
            .tableImg{
                margin:auto;
                width:450px;
                border: 2px dotted #3498DB ;
            }
            @media screen and (max-width: 350px){
                .tableImg{
                margin:auto;
                width:320px;
                border: 2px dotted #3498DB ;
            }
            }
        </style>
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
                            <a class="nav-link" href="usuarios.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Usuarios
                            </a>
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
                    <li class="breadcrumb-item"><a href="micuenta.php">Mantenimiento</a></li>
                    <li class="breadcrumb-item active">Productos</li>
                </ol>
                <div class="container-fluid px-4">
                       
                       
                        
                        <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-boxes"></i>Lista de Productos. <a href="../reportes/reProductos.php">Reporte PDF</a>
                        </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Código Producto</th>
                                            <th>Nombre</th>
                                            <th>Descripcion</th>
                                            <th>Precio</th>
                                            <th>Descuento</th>
                                            <th>Categoria</th>
                                            <th>Activo</th>
                                            <th>Acciones</th>

                                            
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Código Producto</th>
                                            <th>Nombre</th>
                                            <th>Descripcion</th>
                                            <th>Precio</th>
                                            <th>Descuento</th>
                                            <th>Categoria</th>
                                            <th>Activo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                        <?php while($row = $resultado->fetch_assoc()) { ?>
                                       <tr>
                                        <td><?php echo $row['codProducto']; ?></td>
                                        <td><?php echo $row['nombre_producto']; ?></td>
                                        <td><?php echo $row['descripcion']; ?></td>
                                        <td><?php echo $row['precio_producto']; ?></td>
                                        <td><?php echo $row['descuento']; ?></td>
                                        <td><?php echo $row['categoria']; ?></td>
                                        <td><?php echo $row['activo']; ?></td>
                                       
                                        <td>
                                            <a href="./editProduc.php?id=<?php echo $row['codProducto']; ?>" class="btn btn-primary">
                                                <i class="fas fa-marker"></i>
                                            </a>
                                            <a href="../controladores/deleteProduc.php?id=<?php echo $row['codProducto']; ?>" class="btn btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                       </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

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
                                        <i class="fas fa-boxes"></i>Agregar Productos
                                    </div>
                                    <div class="card card-body">
                                        <form action="../controladores/createProd.php" method="post">
                                            <div class="form-group mb-4">
                                              <input type="text" name="nombre" class="form-control" placeholder="Nombre"  required="" autofocus>

                                            </div>
                                            <div class="form-group mb-4">
                                              <textarea type="text" name="descripcion" rows="2" class="form-control" placeholder="Descripcion" required="">
                                              </textarea>
                                            </div>

                                            <div class="form-group mb-4">
                                              <input type="number" name="precio" class="form-control" placeholder="Precio"  required="" autofocus>

                                            </div>
                                            <div class="form-group mb-4">
                                              <input type="number" name="descuento" class="form-control" placeholder="Descuento"  required="" autofocus>

                                            </div>
                                            <div class="form-group mb-4">
                                           
                                            <select class="form-select" name="idCategoria" aria-label="Default select example">
                                           
                                                    <option selected>Categoria</option>
                                                    <option value="1"> ropa Interior</option>
                                                    <option value="2"> pijama</option>
                                                   
                                            </select>
                                            

                                            </div>


                                            <input type="submit" class="btn btn-primary"value="Agregar producto" name="createProd">
                                        </form>
                                    </div>
                            </div>
                        </div>
                    </div>

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
                                        <i class="fas fa-image"></i>Agregar Imagenes a tu producto 
                                    </div>
                                    <div class="card card-body">
                                        <p>Formato aceptado jpg o jpeg</p>
                                        <p>Si la imagen es la principal, subir con nombre "principal"</p>
                                        <p>Ejemplo "principal.jpg"</p>
                                        <form action="../controladores/agregarImgProduc.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group mb-4">
                                              <input type="number" name="codProducto" class="form-control" placeholder="Codigo del producto"  required="" autofocus>

                                            </div>
                                            <div class="form-group mb-4">
                                            <table class="tableImg">
                                                <tr>
                                                    <td>
                                                        <label for="imagen">Imagen:</label>
                                                        <td> <input type="file" name="imagen" size="20"/></td>
                                                    </td>
                                                
                                                </tr>

                                                <tr>
                                                        <td colspan="2" style="text-align:center">
                                                            <input type="submit" value="Enviar imagen">
                                                        </td>
                                                        
                                                </tr>
            
                                            </table>
                                            </div>
                                            

                                            

                                          

                                            <input type="submit" class="btn btn-primary"value="Agregar Imagen" name="addImg">
                                        </form>
                                    </div>
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
