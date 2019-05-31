<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../model/class-game.php");
require_once(__DIR__ . "/../dao/class-gameDAO.php");
require_once(__DIR__ . "/../model/class-user.php");
require_once(__DIR__ . "/../model/class-userpunctuategame.php");
require_once (__DIR__ . "/../dao/class-userpunctuategameDao.php");

$gameInfo =($_POST);
//var_dump($gameInfo);
//$rating = $gameInfo['rating'];
//$game_id = $gameInfo['game_id'];
//$user_id = $gameInfo['user_id'];


//echo ( 'User id is    ' . $user_id  . '        and number of stars ' . $rating . '         game id is ' . $game_id);
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $punctuation = new punctuations();

    //var_dump($punctuation); exit();
    $id_user = (int)$gameInfo['user_id'];
    $id_game = (int)$gameInfo['game_id'];
    $game_dao = new gameDAO();
    $game    =  $game_dao->get_game_by_id($id_game);
    $punctuation = $gameInfo['rating'];
    $create_date = date('Y-m-d');
    $id_user_level = 1;
//var_dump('hola'); exit();
    $error = false;

    if (empty($id_user)) {
        $name_error = "El id-user del juego es requerido";
        $error = true;
    }
    if (empty($id_game)) {
        $name_error = "El id_game del juego es requerido";
        $error = true;
    }
    if (empty($punctuation)) {
        $name_error = "El número de estrellas del juego es requerido";
        $error = true;
    }
    if (empty($id_user_level)) {
        $name_error = "La categoria del juego es requerida";
        $error = true;
    }
    if (!$error) {
        $punctuations = new punctuations();

        $punctuations->set_user_id($id_user);
        $punctuations->set_game_id($id_game);
        $punctuations->set_punctuation($punctuation);
        $punctuations->set_date($create_date);
        $punctuations->set_user_level_id($id_user_level);

        $punctuation_dao = new punctuationsDAO();
        $punctuation_dao->insert_punctuations($punctuations);

        $users_rating = $punctuation_dao->getRatingByGame($game);

        echo '{"users_rating":'. $users_rating .'}';

        //echo "<h3 style='color: green'>Nuevo juego subido en la base de datos con éxito</h3>";
        //$miss = 'Nuevo juego subido en la base de datos con éxito';



    }
    //var_dump($_POST);
    /*exit();
    $insertRating = "INSERT INTO item_rating (itemId, userId, ratingNumber, title, comments, created, modified)
      VALUES ('" . $itemId . "', '" . $userID . "', '" . $_POST['rating'] . "', '" . $_POST['title'] . "', '" . $_POST["comment"] .
        "', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d H:i:s") . "')";
    mysqli_query($conn, $insertRating) or die("database error: " . mysqli_error($conn));
    echo "rating saved!";*/
}

/*require_once(__DIR__ . "/../dao/class-datasource.php");



if(!empty($_POST['rating']) && !empty($_POST['game_id'])){
    var_dump($_POST); exit();
    $itemId = $_POST['itemId'];
    $userID = 1234567;
    $conn = new mysqli("localhost", "root", "oxieva", "exemple");
    $insertRating = "INSERT INTO item_rating (itemId, userId, ratingNumber, title, comments, created, modified)
      VALUES ('".$itemId."', '".$userID."', '".$_POST['rating']."', '".$_POST['title']."', '".$_POST["comment"].
        "', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')";
    mysqli_query($conn, $insertRating) or die("database error: ". mysqli_error($conn));
    echo "rating saved!";
    /*$conn = $this->datasource->get_connection();
    $sql = "INSERT INTO userpunctuategame(id_user, id_game, punctuation, create_date, id_user_level) VALUES (?,?,?,?,?)";
    // Vincular variables a una instrucción preparada como parámetros
    $stmt = $conn->prepare($sql);
    $user_id = $punctuation->get_user_id();
    $game_id = $punctuation->get_game_id();
    $puntuation = $punctuation->get_punctuation();
    $date = $punctuation->get_date();
    $user_level_id = $punctuation->get_user_level_id();
    $stmt->bind_param('dddsd', $user_id, $game_id, $puntuation, $date, $user_level_id);
    if ($stmt->execute() === FALSE) {
        throw new Exception("No has podido crear la puntuación correctamente" . $conn->error);
    }
    $punctuation->set_id($conn->insert_id);*/
