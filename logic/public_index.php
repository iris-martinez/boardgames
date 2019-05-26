<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../dao/class-userDAO.php");
require_once(__DIR__ . "/../dao/class-roleDAO.php");
require_once(__DIR__ . "/../dao/class-gameDAO.php");
require_once(__DIR__ . "/../model/class-role.php");
require_once(__DIR__ . "/../model/class-game.php");
require_once(__DIR__ . "/../model/class-user.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rotten Board Games</title>

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
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Rotten Board Games</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#ranking">Ranking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#boardgames">Juegos de mesa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#about">Sobre RBG</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#team">Nosotras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Header -->
<header class="masthead">
    <div class="container">
        <div class="intro-text">
            <div class="intro-lead-in">"No dejamos de jugar nos hacemos viejos, nos hacemos viejos porque dejamos de jugar"</div>
            <div class="intro-heading text-uppercase">Bienvenidos</div>
            <a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="#boardgames">Encuentra tu juego</a>
        </div>
    </div>
</header>

<!-- Ranking -->
<section id="ranking">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Ranking</h2>
            <h3 class="section-subheading text-muted">Los 10 juegos mejor valorados por nuestros usuarios</h3>
        </div>
        <!-- show the 10 best rated games with a loop -->
        <div class="text-center">
            <h4>Juego 1</h4>
            <p>Valoración</p>
        </div>
    </div>
</section>

<!-- Board Games -->
<section class="bg-light" id="boardgames">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">Juegos de mesa</h2>
                <h3 class="section-subheading text-muted">Juegos valoraciones y comentarios.</h3>
            </div>
        </div>
        <!-- IMPORTANT, implement filtering by categories -->
        <div class="text-center">
            <p>IMPLEMENTAR SISTEMA DE FILTRADO POR CATEGORÍAS!!</p>
        </div>
        <div class="row">
            <!-- Sample content (sacar contenido con un bucle) -->

            <?php

            $game = new game();
            $gameDAO = new gameDAO();

            $games = $gameDAO->list_games();

            foreach ($games as $game) {
            ?>
            <div class="col-md-4 col-sm-6 portfolio-item">
                <a class="portfolio-link" href="game.html">
                    <div class="portfolio-hover">
                        <div class="portfolio-hover-content">
                            <i class="fas fa-plus fa-2x"></i>
                        </div>
                    </div>
                    <img class="img-fluid" src="" alt="">
                </a>
                <div class="portfolio-caption">
                    <img height="150" src="../views/templates/public/img/portfolio/<?=$game->get_name()?>.jpg" style="float: left; margin-right: 10px"><br>
                    <h4><?= $game->get_name(); ?></h4><br>
                    <p class="text-muted"><?= $game->get_category(); ?></p>
                    <p><?= $game->get_description(); ?></p><br>
                </div>
            </div>
                <?php
            }

            ?>
        </div>
    </div>
</section>

<!-- About -->
<section id="about">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Sobre Rotten Board Games</h2>
            <h3 class="section-subheading text-muted">Todo sobre nuestra web.</h3>
        </div>
        <div class="text-center">
            <!-- FALTA CONTENIDO-->
        </div>
    </div>
</section>

<!-- Team -->
<section class="badge-secondary" id="team">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">Nosotras</h2>
                <h3 class="section-subheading text-muted">Equipo de RBG.</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="team-member">
                    <img class="mx-auto rounded-circle" src="../views/templates/public/img/team/1.jpg" alt="">
                    <h4>Melissa del Cerro</h4>
                    <p>Project manager</p>
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
            <div class="col-sm-4">
                <div class="team-member">
                    <img class="mx-auto rounded-circle" src="../views/templates/public/img/team/2.jpg" alt="">
                    <h4>Eva Lujan</h4>
                    <p>Developer</p>
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
            <div class="col-sm-4">
                <div class="team-member">
                    <img class="mx-auto rounded-circle" src="../views/templates/public/img/team/3.jpg" alt="">
                    <h4>Iris Martínez</h4>
                    <p>Developer</p>
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
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <p class="large text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eaque, laboriosam veritatis, quos non quis ad perspiciatis, totam corporis ea, alias ut unde.</p>
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
