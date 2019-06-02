<?php
require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../dao/class-categoryDAO.php");
require_once(__DIR__ . "/../model/class-category.php");

/* Insert new category*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_dao = new CategoryDAO();
    $name = $_POST['name'] ?? '';
    $error = false;
    if (empty($name)) {
        $name_error = "Name is required!";
        $error = true;
    }
    if (!$error) {
        $category = new Category();
        $category->set_name($name);
        $category_dao->insert_category($category);
        $_COOKIE['exitAdd'] = ' Nueva categoria borrada en la base de datos con éxito';
    }


}

/*Delete a category*/

if(isset($_POST['delete_category']) == 'eliminar'){
    $category_id=(int)$_POST['delete_category'];
    if($category_dao->delete_category_by_id($category_id)){
        $_COOKIE['exitDelete'] = ' Nueva categoria borrada en la base de datos con éxito';
        //echo "<h3 style='color: green'> Nueva categoria borrada en la base de datos con éxito</h3>" . "<br>";
    }else{
        echo "<h3 style='color: red'> No se ha podido borrar la categoría</h3>" . "<br>";
    }
   }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - New category</title>
    <!-- Custom fonts for this template-->
    <link href="../views/templates/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="../views/templates/admin/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../views/templates/admin/css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="admin_index.php">Administrador</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Buscar..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">Ajustes</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
        </li>
    </ul>

</nav>

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-users"></i>
                <span>Usuarios</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Gestionar usuarios:</h6>
                <a class="dropdown-item" href="userProfile.php">Listado de usuarios</a>
                <a class="dropdown-item" href="userProfile.php">Modificaciones/Bajas</a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">Feedback:</h6>
                <a class="dropdown-item" href="punctuations.php">Valoraciones</a>
                <a class="dropdown-item" href="comments.php">Comentarios</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-puzzle-piece"></i>
                <span>Juegos</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Gestionar juegos:</h6>
                <a class="dropdown-item" href="game_search.php">Buscar</a>
                <a class="dropdown-item" href="game_form.php">Añadir</a>
                <a class="dropdown-item" href="game_update.php">Actualizar/Eliminar</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-ellipsis-h"></i>
                <span>Categorías</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Gestionar categorías:</h6>
                <a class="dropdown-item" href="category_form.php">Añadir/Eliminar</a>
            </div>
        </li>
    </ul>

    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="admin_index.php">Admin</a>
                </li>
                <li class="breadcrumb-item active">Añadir o Eliminar categoría</li>
            </ol>

            <!-- Page Content -->
            <h1>Añadir o Eliminar categoría</h1>
            <hr>
            <?php
            if (isset($_COOKIE['exitDelete'])){
                echo "<div style='color: green'>Categoria borrada en la base de datos con éxito</div>";
            }
            ?>
            <?php
            if (isset($_COOKIE['exitAdd'])){
                echo "<div style='color: green'>Nueva categoria añadida en la base de datos con éxito</div>";
            }
            ?>
            <!-- DataTables -->
            <!-- The list returns all the DB categories -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Listado de categorías</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Categoría</th>
                                <th>Acción</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $category_dao = new CategoryDAO();
                            $categories = $category_dao->list_categories();
                            foreach ($categories as $category) {
                                ?>
                                <tr>
                                    <td><?= $category->get_id()?> </td>
                                    <td><?= $category->get_name()?> </td>
                                    <td>
                                        <form name="delete-form" method="post" action="category_form.php">
                                            <button class="btn btn-danger" type="submit" name="delete_category" value="<?=  $category->get_id(); ?>" >Eliminar</button>

                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">
                    <form method="post" action="category_form.php">

                    <div class="form-group input-group">
                            <div class="form-label-group">
                                <input type="text" id="category" name="name" class="form-control" placeholder="Categoría" required="required">
                                <label for="category">Categoría</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © Rotten Board Games 2019</span>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Seleccione "Logout" a continuación si está listo para finalizar su sesión actual</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Seguro que desea eliminar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Seleccione "Eliminar" si desea eliminar definitivamente</div>
            <form method="post" action="category_form.php" id="delete-form">
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-danger" type="submit" name="delete_category" value="eliminar" form="delete-form" >Eliminar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript--><!--/var/www/html/boardgames/views/templates/admin/vendor-->
<script src="../views/templates/admin/vendor/jquery/jquery.min.js"></script>
<script src="../views/templates/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../views/templates/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../views/templates/admin/js/sb-admin.min.js"></script>

</body>

</html>

