<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../dao/class-userDAO.php");
require_once(__DIR__ . "/../dao/class-roleDAO.php");
require_once(__DIR__ . "/../model/class-role.php");
require_once(__DIR__ . "/../model/class-user.php");


$userDAO = new userDAO();
$rolDAO = new roleDAO();
$roles = $rolDAO->list_roles();
$modified = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $error_name = $error_surname = $error_email = $error_password = $errors_birthdate = "";
    $error = false;

    if (empty($_POST["name"])) {
        $error_name = "Introduce el nombre del usuario.";
        $error = true;
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty($_POST["surname"])) {
        $error_surname = "Introduce los apellidos del usuario.";
        $error = true;
    } else {
        $surname = trim($_POST["surname"]);
    }

    if (empty($_POST["email"])) {
        $error_email = "Introduce el email del usuario.";
        $error = true;
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty($_POST["password"])) {
        $error_password = "Introduce el password del usuario.";
        $error = true;
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($_POST["birthDate"])) {
        $errors_birthdate = "Introduce la fecha de nacimiento del usuario.";
        $error = true;
    } else {
        $birthDate = trim($_POST["birthDate"]);
    }

    if ($_POST["action"] == "eliminar") {

        //llamamos a usuario para llamar al método delete_user pasándole el $user.
        $user = $userDAO->get_user_by_id($_POST['id_user']);
        $userDAO->delete_user($user);
        header("Location: ../views/templates/admin/user_deleted.html");
        die();

    } else {

        /*llamamos a usuario y a rol para recuperar el usuario por id y el rol por id y llamar al
        método update_user pasándole el usuario.*/
        $user = $userDAO->get_user_by_id($_POST['id_user']);
        $rol = $rolDAO->get_rol_by_id($_POST['id_rol']);

        $user->set_name($_POST['name']);
        $user->set_surname($_POST['surname']);
        $user->set_email($_POST['email']);
        $user->set_password($_POST['password']);

        $birthdate_original = $_POST['birthDate'];
        $birthdate_converted = date("Y-m-d", strtotime($birthdate_original));

        $user->set_birthDate($birthdate_converted);
        $user->set_role($rol);

        $userDAO->update_user($user);

        $modified = true;
    }

} else {

    if (!isset($_GET['id_user'])) {
        die("xxxxxx");
    }

    $user = $userDAO->get_user_by_id($_GET['id_user']);

    if (empty($user)) {
        die("Introduce un usuario.");
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

    <title>Admin - User management</title>

    <!-- Custom fonts for this template-->
    <link href="../views/templates/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="../views/templates/admin/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../views/templates/admin/css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.html">Administrador</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Buscar..." aria-label="Search"
                   aria-describedby="basic-addon2">
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
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
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
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-users"></i>
                <span>Usuarios</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Gestionar usuario:</h6>
                <a class="dropdown-item" href="userProfile.php">Listar/Actualizar/Elim.</a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">Feedback:</h6>
                <a class="dropdown-item" href="punctuations.php">Valoraciones</a>
                <a class="dropdown-item" href="comments.php">Comentarios</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-puzzle-piece"></i>
                <span>Juegos</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Gestionar juegos:</h6>
                <a class="dropdown-item" href="game_search.php">Buscar</a>
                <a class="dropdown-item" href="game_form.php">Añadir</a>
                <a class="dropdown-item" href="manageGame.html">Actualizar/Eliminar</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-ellipsis-h"></i>
                <span>Categorías</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Gestionar categorías:</h6>
                <a class="dropdown-item" href="newCategory.html">Añadir/Eliminar</a>
            </div>
        </li>
    </ul>

    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="../views/templates/admin/index.html">Admin</a>
                </li>
                <li class="breadcrumb-item active">Gestionar usuario</li>
            </ol>

            <!-- Page Content -->
            <h1>Gestionar usuario</h1>
            <hr>

            <!-- Manage user -->
            <div class="card card-register mx-auto mt-5 mb-5">
                <div class="card-header">Gestionar usuario</div>
                <div class="card-body">
                    <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="id_user" value="<?= $user->get_id(); ?>">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="text" id="name" maxlength="45" name="name" class="form-control" placeholder="Nombre"
                                               value="<?= $user->get_name(); ?>" required="required" autofocus="autofocus">
                                        <label for="name">Nombre</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="text" id="surname" maxlength="60" name="surname" class="form-control" placeholder="Apellido"
                                               value="<?= $user->get_surname(); ?>" required="required">
                                        <label for="surname">Apellidos</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="text" id="email" maxlength="50" name="email" class="form-control" placeholder="Email"
                                               value="<?= $user->get_email(); ?>"
                                               required="required">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="password" id="pass" name="password" maxlength="10" class="form-control" placeholder="Contraseña"
                                               value="<?= $user->get_password(); ?>"
                                               required="required" >
                                        <small id="passwordHelpInline" class="text-muted">
                                            Must be maximum 10 characters long.
                                        </small>
                                        <label for="pass">Contraseña</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="date" id="birth_date" name="birthDate" class="form-control" placeholder="Nacimiento"
                                               value="<?= $user->get_birthDate(); ?>"
                                               required="required">
                                        <label for="birth_date">Fecha de nacimiento</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="date" id="register_date" class="form-control"
                                               placeholder="Registro" value="<?= $user->get_registerDate(); ?>"
                                               required="required" readonly>
                                        <label for="register_date">Fecha de registro</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <select required id="role" name="id_rol" class="form-control">
                                            <?php

                                            foreach ($roles as $rol) {
                                                ?>

                                            <option value="<?= $rol->get_id()?>"><?= $rol->get_role() ?></option>


                                        <?php
                                         }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" a class="btn btn-primary btn-block" name="action" value="modificar">Modificar usuario</button>
                        <button type="submit" a class="btn btn-primary btn-block" name="action" value="eliminar">Baja de usuario</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- end -->

    </div>
    <hr>
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
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Seleccione "Logout" a continuación si está listo para finalizar su sesión actual
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="login.php">Logout</a>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap core JavaScript-->
    <script src="../views/templates/admin/vendor/jquery/jquery.min.js"></script>
    <script src="../views/templates/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../views/templates/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="../views/templates/admin/vendor/chart.js/Chart.min.js"></script>
    <script src="../views/templates/admin/vendor/datatables/jquery.dataTables.js"></script>
    <script src="../views/templates/admin/vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../views/templates/admin/js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="../views/templates/admin/js/demo/datatables-demo.js"></script>
    <script src="../views/templates/admin/js/demo/chart-area-demo.js"></script>

</body>

</html>