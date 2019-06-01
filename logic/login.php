<?php
session_start();
require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../dao/class-userDAO.php");
require_once(__DIR__ . "/../dao/class-roleDAO.php");
require_once(__DIR__ . "/../model/class-role.php");
require_once(__DIR__ . "/../model/class-user.php");

$userDAO = new userDAO();
$rolDAO = new roleDAO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $error_name = $error_surname = $error_email = $error_password = $errors_birthdate = "";
    $error = false;

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

}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login RGB</title>

    <!-- Bootstrap core CSS -->
    <link href="../views/templates/public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="../views/templates/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="../views/templates/public/css/agency.min.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="public_index.php">Rotten Board Games</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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
<section class="bg-dark" >
        <div class="container">
            <div class="row">
            <div class="card card-login mx-auto mt-5">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="post" action="validate_login.php">
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" required="required" autofocus="autofocus">
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Contraseña" required="required">
                                <label for="inputPassword">Contraseña</label>
                            </div>
                        </div>

                        <?php
                        if(isset($_SESSION['fallo_login'])){
                            echo "<div style='color: red'>Los datos introducidos son incorrectos</div>";
                        }
                        ?>
                        <button type="submit" a class="btn btn-primary btn-block" value="login">Entrar</button>

                    </form>
                    <div class="text-center" style="margin-top: 20px">
                        <a href="register.php"><button style="" class="btn btn-primary btn-block" value="register"> Registrar</button></a>

                    </div>
                </div>
            </div>
            </div>
    </div>
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
