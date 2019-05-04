<?php

require_once ("dao/class-gameDAO.php");
require_once ("dao/class-categoryDAO.php");
require_once ("model/class-game.php");
require_once ("dao/class-datasource.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['add_game'])) {

        $game_dao = new GameDAO();
        $name = $_POST['name'] ?? '';
        $author = $_POST['author'] ?? '';
        $number_players = $_POST['number_players'] ?? '';
        $description = $_POST['description'] ?? '';
        $id_category = (int)$_POST['category'] ?? '';
        $duration = $_POST['duration'] ?? '';
        $image = $_FILES['image'] ?? '';
        $punctuation = (int)$_POST['punctuation'] ?? '';
        $id_user = $_POST['id_user'];

        $error = false;
        if (empty($name)) {
            $name_error = "El nombre del juego es requerido";
            $error = true;
        }

        if (empty($author)) {
            $name_error = "El autor del juego es requerido";
            $error = true;
        }

        if (empty($number_players)) {
            $name_error = "El número de jugadores del juego es requerido";
            $error = true;
        }

        if (empty($id_category)) {
            $name_error = "La categoria del juego es requerida";
            $error = true;
        }

        if (empty($duration)) {
            $name_error = "La duración del juego es requerida";
            $error = true;
        }
       // var_dump($name); exit();

        //Subir imagen
        /*if (empty($image)) {
            $name_error = "Name is required!";
            $error = true;
        }*/

        if (empty($punctuation)) {
            $name_error = "La puntuación del juego es requerida,por defecto pon 0";
            $error = true;
        }

        //var_dump($punctuation); exit();
        var_dump($error . $name_error);exit();
        if (!$error) {
            $game = new Game();
            $game->set_name($name);
            $game->set_author($author);
            $game->set_number_players($number_players);
            $game->set_description($description);
            $game->set_duration($duration);
            $game->set_image($image);

            $game->set_punctuation($punctuation);
            var_dump($game->set_punctuation($punctuation));exit();
            $game->set_id_category($id_category);
            $game->set_id_user($id_user);

//////////Aquí estoy
            $game_dao->insert_game($game);


        }

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

    <title>SB Admin - Blank Page</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

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
                <a class="dropdown-item" href="#">Perfiles de usuario</a>
                <a class="dropdown-item" href="#">Alta/Baja</a>
                <a class="dropdown-item" href="#"></a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">Feedback:</h6>
                <a class="dropdown-item" href="#">Valoraciones</a>
                <a class="dropdown-item" href="#">Comentarios</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-puzzle-piece"></i>
                <span>Juegos</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Gestionar juegos:</h6>
                <a class="dropdown-item" href="searchGame.html">Buscar</a>
                <a class="dropdown-item" href="newGame.html">Añadir</a>
                <a class="dropdown-item" href="#">Actualizar/Modificar</a>
                <a class="dropdown-item" href="#">Eliminar</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-ellipsis-h"></i>
                <span>Categorías</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Gestionar categorías:</h6>
                <a class="dropdown-item" href="#">Añadir</a>
                <a class="dropdown-item" href="#">Modifica/Eliminar</a>
                <a class="dropdown-item" href="#"></a>
            </div>
        </li>
    </ul>

    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Admin</a>
                </li>
                <li class="breadcrumb-item active">Añadir juego</li>
            </ol>

            <!-- Page Content -->
            <h1>Añadir Juego</h1>
            <hr>
            <div class="container">
                <div class="card card-register mx-auto mt-5">
                    <div class="card-header">Introducir juego</div>
                    <div class="card-body">
                        <form method="post" action="game-form.php">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input type="text" id="name" class="form-control" name="name" placeholder="Nombre" required="required" autofocus="autofocus">
                                            <label for="name">Nombre</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input type="text" id="author" class="form-control" name="author" placeholder="Autor" required="required">
                                            <label for="author">Autor</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input type="number" id="number_players" class="form-control" name="number_players" placeholder="Nº de Jugadores" required="required">
                                            <label for="number_players">Nº de Jugadores</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input type="text" id="duration" class="form-control" name="duration" placeholder="Duración de partida" required="required">
                                            <label for="duration">Duración de partida</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input type="hidden" id="id_user" name="id_user" class="form-control" placeholder="Puntuación" value="1" >
                                            <label for="id_user"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input type="number" id="punctuation" name="punctuation" class="form-control" placeholder="Puntuación" >
                                            <label for="punctuation">Puntuación del juego</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <label for="id_category">Selecciona la categoría</label>
                                            <select name="id_category" class="form-control" id="id_category">
                                                <option value="0">Seleccione:</option>
                                                <?php
                                                $category_dao = new CategoryDAO();
                                                $categories = $category_dao->list_categories();

                                                foreach ($categories as $id_category) {
                                                    //var_dump($id_category); exit();
                                                    ?>
                                                    <option value="<?=$id_category->get_id() ?>"><?= $id_category->get_name()?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="text" id="description" name="description" class="form-control" placeholder="Descripción" required="required">
                                    <label for="description">Descripción</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="file" id="image" name="image" class="form-control" placeholder="Imagen" >
                                    <label for="image">Imagen</label>
                                </div>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" name="add_game">
                                    <i class="fas fa-plus">Añadir</i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin.min.js"></script>

</body>

</html>
