<?php

var_dump($_POST);

$mitjaJoc = 2;

echo '{"users_rating":'. $mitjaJoc .'}';

/*require_once(__DIR__ . "/../dao/class-datasource.php");



if(!empty($_POST['rating']) && !empty($_POST['game_id'])){
    /*var_dump($_POST); exit();
    $itemId = $_POST['itemId'];
    $userID = 1234567;
    $conn = new mysqli("localhost", "root", "oxieva", "exemple");
    $insertRating = "INSERT INTO item_rating (itemId, userId, ratingNumber, title, comments, created, modified)
      VALUES ('".$itemId."', '".$userID."', '".$_POST['rating']."', '".$_POST['title']."', '".$_POST["comment"].
        "', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')";
    mysqli_query($conn, $insertRating) or die("database error: ". mysqli_error($conn));
    echo "rating saved!";*/
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
