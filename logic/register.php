<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../dao/class-userDAO.php");
require_once(__DIR__ . "/../dao/class-roleDAO.php");
require_once(__DIR__ . "/../dao/class-user_levelDAO.php");
require_once(__DIR__ . "/../model/class-role.php");
require_once(__DIR__ . "/../model/class-user.php");

$userDAO = new userDAO();
$roleDAO = new roleDAO();
$userLevelDAO = new user_levelDAO();

$modified = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new user();
    //Falta id joc
    //$id_game = $new_game->get_id_game();
    $name = $_POST['name'] ?? '';
    $surname = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $birth_date = $_POST['birth_date'] ?? '';

    $birthdate_converted = date("Y-m-d", strtotime($birth_date));
    $register_date = date('Y-m-d');

    $error = false;

    if (empty($_POST["name"])) {
        $name_error = "Introduce el nombre del usuario.";
        $error = true;
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty($_POST["surname"])) {
        $name_error = "Introduce los apellidos del usuario.";
        $error = true;
    } else {
        $surname = trim($_POST["surname"]);
    }

    if (empty($_POST["email"])) {
        $name_error = "Introduce el email del usuario.";
        $error = true;
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty($_POST["password"])) {
        $name_error = "Introduce el password del usuario.";
        $error = true;
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($_POST["birth_date"])) {
        $name_error = "Introduce la fecha de nacimiento del usuario.";
        $error = true;
    } else {
        $birthDate = trim($_POST["birth_date"]);
    }


    if (!$error) {

        try {
            $user = $userDAO->get_user_by_email($email);
            if (isset($user)) {
                $_SESSION['fallo_registro'] = 'Este correo ya está registrado';
            }

            $user_level = $userLevelDAO->get_user_level_by_name('Novato')[0];
            $rol = $roleDAO->get_a_role('USUARIO');

            $user = new user();
            $user->set_name($name);
            $user->set_surname($surname);
            $user->set_email($email);
            $user->set_password($password);
            $user->set_birthDate($birth_date);
            $user->set_registerDate($register_date);
            $user->set_role($rol);
            $user->set_userLevel($user_level);
            $user->set_counterPunctuation(0);

            $userDAO->insert_user($user);
            $modified = true;
            header("location:public_index.php");
        } finally {
            datasource::get_instance()->close_connection();
        }
    }

}


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register RGB</title>

    <!-- Bootstrap core CSS -->
    <link href="../views/templates/public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="../views/templates/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet'
          type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="../views/templates/public/css/agency.min.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav" style="background-color: #f73b51">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="public_index.php">Rotten Board Games</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Formulario login-->
<section class="bg-dark">
    <div class="container"><!-- Manage user -->

        <?php if ($error) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $name_error ?>
            </div>
        <?php } ?>
        <?php if ($modified) { ?>
            <div class="alert alert-success" role="alert">
                Te has registrado correctamente.
            </div>
        <?php } ?>


        <div class="card card-register mx-auto mt-5 mb-5">
            <div class="card-header">Registro</div>

            <div class="card-body">
                <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="id_user" value="">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" id="name" maxlength="45" name="name" class="form-control"
                                           placeholder="Nombre"
                                           value="" required="required" autofocus="autofocus">
                                    <label for="name">Nombre</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" id="surname" maxlength="60" name="surname" class="form-control"
                                           placeholder="Apellidos"
                                           value="" required="required">
                                    <label for="surname">Apellidos</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" id="email" maxlength="50" name="email" class="form-control"
                                           placeholder="Email"
                                           value=""
                                           required="required">
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="password" id="pass" name="password" maxlength="10" class="form-control"
                                           placeholder="Contraseña"
                                           value=""
                                           required="required">
                                    <label for="pass">Contraseña</label>
                                    <small id="passwordHelpInline" class="text-muted">
                                        Debe tener un máximo de 10 caracteres.
                                    </small>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="date" id="birth_date" name="birth_date" class="form-control"
                                           placeholder="Nacimiento"
                                           value=""
                                           required="required">
                                    <label for="birth_date">Fecha de nacimiento</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div>
                        <?php
                        if (isset($_SESSION['fallo_registro'])) {
                            $name_error = "Este correo ya está registrado";
                            echo "<div class=\"alert alert-danger\" role=\"alert\"> $name_error</div>";
                        }
                        ?>

                    </div>
                    <button type="submit" a class="btn btn-primary btn-block" name="action" value="register">Registrar
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- end -->

</section>


<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <span class="copyright">Copyright &copy; Rotten Board Games 2019</span>
            </div>
            <div class="col-md-4">
                <ul class="list-inline social-buttons">
                    <li class="list-inline-item">
                        <a href="#">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>


<!-- Bootstrap core JavaScript -->
<script src="../views/templates/public/vendor/jquery/jquery.min.js"></script>
<script src="../views/templates/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="../views/templates/public/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Contact form JavaScript -->
<script src="../views/templates/public/js/jqBootstrapValidation.js"></script>
<script src="../views/templates/public/js/contact_me.js"></script>

<!-- Custom scripts for this template -->
<script src="../views/templates/public/js/agency.min.js"></script>

</body>

</html>
