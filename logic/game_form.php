<?php
require_once (__DIR__ . "/../dao/class-gameDAO.php");
require_once (__DIR__ . "/../dao/class-categoryDAO.php");
require_once (__DIR__ ."/../model/class-game.php");
require_once (__DIR__ . "/../dao/class-datasource.php");

require_once(__DIR__ . "/../dao/class-userDAO.php");
require_once(__DIR__ . "/../dao/class-roleDAO.php");
require_once(__DIR__ . "/../model/class-role.php");
require_once(__DIR__ . "/../model/class-user.php");

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_game']) == 'crear') {

    // var_dump($_FILES);exit();
    $game = new Game();

    //Falta id joc
    //$id_game = $new_game->get_id_game();
    $name = $_POST['name'] ?? '';
    $author = $_POST['author'] ?? '';
    $number_players = (int) $_POST['number_players'] ?? '';
    $description = $_POST['description'] ?? '';
    $duration = $_POST['duration'] ?? '';
    //var_dump($_FILES); exit();
    $image = $_FILES['image']['name'] ?? '';
    $punctuation = (int)$_POST['punctuation'] ?? '';
    $category_id =(int) $_POST['id'] ?? '';
    $id_user = $_SESSION['id_user'];
//var_dump($game); exit();

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
    if (empty($category_id)) {
        $name_error = "La categoria del juego es requerida";
        $error = true;
    }
    if (empty($duration)) {
        $name_error = "La duración del juego es requerida";
        $error = true;
    }
    /*Per pujar imatges*/
    /*Mirem els diferents tipus d'error*/

    if($_FILES['image']['error']){

        switch ($_FILES['image']['error']){

            case 1: //Error excés de tamany
                echo "Has superado el tamaño permitido";
                break;

            case 2: //Error tamany arxiu marcat des del formulari amb l'input amagat
                echo "Has superado el tamaño permitido por el formulario";
                break;

            case 3: //Error fitxer pujat parcialment
                echo "Error fichero subido parcialment, fichero corrupto";
                break;

            /* case 4: //Error no sha pujat cap fitxer
                 echo "Error no se ha subido ningun fichero";
                 break;*/

        }

    } else {

        //echo "Has subido la imagen correctamente <br>";

        if((isset($_FILES['image']['name']) && ($_FILES['image']['error'] == UPLOAD_ERR_OK))){



            /*Creem una carpeta on desarem les imatges*/
            $destiRuta = "../views/images/";

           // var_dump($destiRuta . $_FILES['image']['name']); exit();

            move_uploaded_file($_FILES['image']['tmp_name'], $destiRuta . $_FILES['image']['name']);


            echo "<h3 style='color: green'>El archivo " . $_FILES['image']['name'] . " se ha copiado en el directorio de imagenes </h3>";

        } else {

            echo "Ha habido algun error, no se ha copiado el archivo en imagenes/";
        }
    }


    if (empty($punctuation)) {
        $name_error = "La puntuación del juego es requerida,por defecto pon 1";
        $error = true;
    }
    if (!$error) {
        $game = new Game();

        /*Estic aquí, falta l'id del joc???*/
        /* $game->get_id_game();*/
        $game->set_name($name);
        $game->set_author($author);
        $game->set_number_players($number_players);
        $game->set_description($description);
        $game->set_duration($duration);
        $game->set_image($image);
        $game->set_punctuation($punctuation);
        $game->set_category($category_id);
        $game->set_user($id_user);

        //$game = $game_dao->insert_game($game);
        $game_dao = new gameDAO();
        $game_dao->insert_game($game);


        echo "<h3 style='color: green'>Nuevo juego subido en la base de datos con éxito</h3>";
        //$miss = 'Nuevo juego subido en la base de datos con éxito';



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

    <title>Admin - New game</title>

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
                <a class="dropdown-item" href="userProfile.php">Listar/Actualizar/Elim.</a>
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
                <a class="dropdown-item" href="game_list.php">Actualizar/Modificar</a>
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
                <li class="breadcrumb-item active">Añadir juego</li>
            </ol>

            <!-- Page Content -->
            <h1>Añadir Juego</h1>
            <hr>

            <div class="container">
                <div class="card card-register mx-auto mt-5">
                    <div class="card-header">Introducir juego</div>
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
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
                                            <label for="number_players" style="display: none"></label>
                                            <select name="number_players" class="form-control" id="number_players" required>
                                                <option>Nº de Jugadores</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <select name="id" class="form-control" id="id">
                                                <option value="0">Selecciona la categoría</option>
                                                <?php

                                                $category_dao = new CategoryDAO();
                                                $categories = $category_dao->list_categories();
                                               // error_log(var_export($categories,true)); exit();
                                                foreach ($categories as $category) {
                                                    ?>
                                                    <option value="<?=$category->get_id() ?>"><?= $category->get_name()?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">

                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input type="number" id="punctuation" name="punctuation" class="form-control" placeholder="Puntuación" >
                                            <label for="punctuation">Puntuación del juego</label>
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
                                <div class="form-label-group">
                                    <input type="text" id="description" name="description" class="form-control" placeholder="Descripción" required="required">
                                    <label for="description">Descripción</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="file" id="image" name="image" class="form-control" placeholder="Imagen" data-validation-required-message="Adjunta una imagen" >
                                    <label for="image">Imagen</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="hidden" id="id_user" name="id_user" class="form-control" placeholder="Puntuación" value="1" >
                                    <label for="id_user"></label>
                                </div>
                            </div>
                            <div class="input-group-append">
                                <button type="submit" a class="btn btn-primary btn-block" name="add_game" value="crear">Crear juego</button>

                                <!--<input type="submit" name="add_game" value="manda">-->

                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <hr>

        <!-- /.container-fluid -->



    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->
<!-- Sticky Footer -->

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
                <a class="btn btn-primary" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="../views/templates/admin/vendor/jquery/jquery.min.js"></script>
<script src="../views/templates/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../views/templates/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../views/templates/admin/js/sb-admin.min.js"></script>

</body>

</html>