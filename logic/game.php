<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../dao/class-gameDAO.php");
require_once(__DIR__ . "/../dao/class-userpunctuategameDao.php");
require_once(__DIR__ . "/../dao/class-usercommentgameDAO.php");
require_once(__DIR__ . "/../dao/class-userDAO.php");
require_once(__DIR__ . "/../model/class-game.php");
require_once(__DIR__ . "/../model/class-usercommentgame.php");
require_once(__DIR__ . "/../model/class-user.php");
require_once (__DIR__ . "/../logic/session.php");

session_start();
$gameDAO = new gameDAO();
$commentDAO = new commentDAO();
$userDAO = new userDAO();
$punctuation_dao = new punctuationsDAO();
$user_id = $_SESSION['id_user'];
//$user_id = null;

$id_game = $_GET["id_game"];
if($user_id == null){
    $user_already_rated = true;
}else{
    $user_already_rated = $punctuation_dao->userHasRated($user_id, $id_game);
}
$game = $gameDAO->get_game_by_id($id_game);
$current_rating = $punctuation_dao->getRatingByGame($game);
$comments = $commentDAO->get_comments_by_game($id_game);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Game</title>

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

<body id="game-page">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="public_index.php">Rotten Board Games</a>
        <a class="btn btn-secondary" href="public_index.php" role="button">
            <i class="fas fa-times"></i>
        </a>

    </div>
</nav>

<!-- Board Game info -->
<section id="game">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="modal-body">
                    <!-- Game Details Go Here -->
                    <h1 class="text-uppercase">Usuario <?php echo $_SESSION['id_user']; ?></h1>
                    <h2 class="text-uppercase">Título <?= $game->get_name(); ?></h2>
                    <p class="item-intro text-muted">Categoría <?= $game->get_category(); ?></p>
                    <img class="img-fluid d-block mx-auto" src="../views/images/<?=$game->get_image()?>" alt="">
                    <p><?= $game->get_description(); ?></p>
                    <ul class="list-inline">
                        <li><b>Autor:</b> <?= $game->get_author(); ?> </li>
                        <li><b>Duración:</b> <?= $game->get_duration(); ?></li>
                        <li><b>Nº Jugadores:</b> <?= $game->get_number_players(); ?></li>
                        <li><?php

                            echo count($comments) . " ";
                            echo "<b>comentarios de usuarios:</b>" . '<br>';

                            foreach ($comments as $comment) {
                                $user = $userDAO->get_user_by_id($comment->get_user_id());
                                echo '</br>';
                                echo $user->get_name() . '<br>';
                                echo $comment->get_comment() . '<br>';
                            }

                            ?>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-sm-12">
                            <h2 id="rating-title"><?= $user_already_rated ? 'La media del juego es:' : 'Vota para ver la media del juego'?></h2>
                            <div id="game-info" class="hidden" data-game-id="<?= $game->get_id()?>" data-user-id="<?=  $_SESSION['id_user']; ?>"></div>

                            <div id="<?= $user_already_rated ? 'average-rating' : 'data-stars'?>">
                                <span class="fa-star <?= 1 <= $current_rating || !$user_already_rated ? 'fa' : 'far' ?>" data-rating="1"></span>
                                <span class="fa-star <?= 2 <= $current_rating || !$user_already_rated ? 'fa' : 'far' ?>" data-rating="2"></span>
                                <span class="fa-star <?= 3 <= $current_rating || !$user_already_rated ? 'fa' : 'far' ?>" data-rating="3"></span>
                                <span class="fa-star <?= 4 <= $current_rating || !$user_already_rated ? 'fa' : 'far' ?>" data-rating="4"></span>
                                <span class="fa-star <?= 5 <= $current_rating || !$user_already_rated ? 'fa' : 'far' ?>" data-rating="5"></span>


                            </div>
                            <!--<form id="ratingForm" method="POST">
                                <div class="form-group">


                                    <input type="hidden" class="form-control" id="rating" name="rating" value="1">
                                    <input type="hidden" class="form-control" id="game_id" name="game_id" value="12345678">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info" id="save_punctuaction">Save Review</button> <button type="button" class="btn btn-info" id="cancelReview">Cancel</button>
                                </div>
                            </form>-->
                        </div>
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
            <div class="col-md-4">
                <ul class="list-inline quicklinks">
                    <li class="list-inline-item">
                        <a href="public_index.php">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- Games Modals -->

<!-- Modal  -->



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

<script type="text/javascript">

    /*$(document).ready(function(){
        $("*[data-stars]").on("click", function(event){
            alert(event.currentTarget === this);
        });
    });*/
    $(document).ready(function(){

        $('#data-stars > span').on('click', function(event){
            var rating = $(event.currentTarget).attr('data-rating');
            var hiddenInfoDiv = $('#game-info');
            var userId = hiddenInfoDiv.attr('data-user-id');
            var gameId = hiddenInfoDiv.attr('data-game-id');

            $.ajax({
                type : 'POST',
                url : 'save_punctuaction.php',
                data : {'rating':rating, 'user_id': userId, 'game_id': gameId},
                success:function(response){

                    var jsonResponse = JSON.parse(response);
                    var currentRating = jsonResponse.users_rating;

                    $('#data-stars > span').each(function(i){
                        if(i+1 <= currentRating){
                            $(this).attr('class', 'fa fa-star');
                        }else{
                            $(this).attr('class', 'far fa-star');
                        }
                    });
                    $('#data-stars > span').off();
                    $('#rating-title').html('Ya has votado! gracias! La media del juego es');
                }
            });
        });


/*        $("[data-rating]").each(function(i){
            $(this).on("click", {x:i}, function(event){

            //alert("Aquesta estrella  " + $(this).index() + ". té valor: " + event.data.x);


                var puntuacion = (event.data.x) +1;
                $("p").append(" <b>Puntuacion </b>." + puntuacion);

                console.log(puntuacion);
            });
        });*/
    });
</script>

<!-- Rating Form Submit with jQuery Ajax -------------------->
<script>
    $('#ratingForm').on('submit', function(event){
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type : 'POST',
            url : 'save_punctuaction.php',
            data : formData,
            success:function(response){
                $("#ratingForm")[0].reset();
                window.setTimeout(function(){window.location.reload()},1000)
            }
        });
    });
</script>

</body>

</html>
