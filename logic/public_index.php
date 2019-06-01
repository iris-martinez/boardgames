<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../dao/class-userDAO.php");
require_once(__DIR__ . "/../dao/class-roleDAO.php");
require_once(__DIR__ . "/../dao/class-gameDAO.php");
require_once(__DIR__ . "/../dao/class-categoryDAO.php");
require_once(__DIR__ . "/../model/class-role.php");
require_once(__DIR__ . "/../model/class-game.php");
require_once(__DIR__ . "/../model/class-user.php");
require_once(__DIR__ . "/../model/class-category.php");

$gameDAO = new gameDAO();
$game = new game();
$categoryDAO = new categoryDAO();

if (isset($_GET['id_category'])) {
    $games = $gameDAO->get_game_by_category($_GET['id_category']);
} else {
    $games = $gameDAO->list_games();
}

/* Ranking */

$categories = $categoryDAO->list_categories();
$juegos = $gameDAO->list_games();
    
    function compare($a, $b)
    {
        if ($a->get_punctuation() ==  $b->get_punctuation()) {
            return 0 ;
        }
        return ($a->get_punctuation() > $b->get_punctuation()) ? -1 : 1;
    }
    
    usort($juegos, 'compare');
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
    <link href="../views/templates/public/css/agency.css" rel="stylesheet">

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
            <div class="intro-lead-in">"No dejamos de jugar porque nos hacemos viejos, nos hacemos viejos porque dejamos de jugar"</div>
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
            <?php

                foreach ($juegos as $juego) {
                    ?>
                    <h4><?= $juego->get_name(); ?></h4>
                    <p><?= $juego->get_punctuation(); ?></p>

                    <?php
                }     
            ?>
        </div>
    </div>
</section>

<!-- Board Games -->

<section class="bg-light" id="boardgames">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">Juegos de mesa</h2>
                <h3 class="section-subheading text-muted">Busca, valora y opina.</h3>
            </div>
        </div>
        <!-- IMPORTANT, implement filtering by categories -->
        <div class="text-center">
            <!-- Categories dropdown -->
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filtrar juegos
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item <?=!isset($_GET['id_category']) ? 'active' : ''?>" href="public_index.php">Todos los juegos</a>
                    <?php

                    foreach ($categories as $category) {

                        ?>
                        <a class="dropdown-item <?=isset($_GET['id_category']) && $_GET['id_category'] == $category->get_id() ? 'active' : ''?>" href="public_index.php?id_category=<?= $category->get_id(); ?>"><?= $category->get_name(); ?></a>

                        <?php
                    }

                    ?>
                </div>
            </div>
        </div><br><br>
        <div class="row">
            <!-- Sample content (sacar contenido con un bucle) -->

            <?php

            foreach ($games as $game) {
            ?>
            <div class="col-md-4 col-sm-6 portfolio-item">
                <a class="portfolio-link" href="game.php?id_game=<?= $game->get_id(); ?>">
                    <div class="portfolio-hover">
                        <div class="portfolio-hover-content">
                            <i class="fas fa-plus fa-2x"></i>
                        </div>
                    </div>
                    <img class="img-fluid" src="" alt="">
                </a>
                <div class="portfolio-caption">
                    <img height="150" src="../views/images/<?= $game->get_image(); ?>" style="float: left; margin-right: 10px"><br>
                    <h4><?= $game->get_name(); ?></h4><br>
                    <p class="text-muted"><?= $game->get_category(); ?></p>
                    <br>
                    <p align="justify"><?= $game->get_description(); ?></p><br>
                </div>
            </div>
                <?php
            }

            ?>
        
    </div>
</section>

<!-- About -->
<section id="about">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Sobre Rotten Board Games</h2>
            <h3 class="section-subheading text-muted">Todo sobre los juegos de mesa.</h3>
            <p>Estás en una aplicación web donde encontrar los juegos de mesa que han marcado un antes y un después en tus tardes de domingo, donde puedes opinar sobre cualquier juego de mesa.</p>
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
