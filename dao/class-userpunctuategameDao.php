<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../model/class-game.php");
require_once(__DIR__ . "/../model/class-user.php");
require_once(__DIR__ . "/../model/class-userpunctuategame.php");

class punctuationsDAO
{

    private $datasource;

    public function __construct()
    {
        $this->datasource = datasource::get_instance();
    }

    public function list_punctuations()
    {

        $conn = $this->datasource->get_connection();
        $sql = "SELECT * FROM userpunctuategame";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $user_id, $game_id, $punct, $date, $user_level_id);
        $punctuations = [];
        while ($stmt->fetch()) {
            $punctuation = new punctuations();
            $punctuation->set_id($id);
            $punctuation->set_user_id($user_id);
            $punctuation->set_game_id($game_id);
            $punctuation->set_punctuation($punct);
            $punctuation->set_date($date);
            $punctuation->set_user_level_id($user_level_id);
            $punctuations[] = $punctuation;
        }
        $stmt->close();
        return $punctuations;

    }

    public function update_punctuations($punctuation)
    {
        $conn = $this->datasource->get_connection();
        $sql = "UPDATE userpunctuategame SET punctuation = ? WHERE user_id = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $punctuation->get_id();
        $user_id = $punctuation->get_user_id();
        $game_id = $punctuation->get_game_id();
        $punct = $punctuation->get_punctuation();
        $user_level_id = $punctuation->get_user_level_id();
        $stmt->bind_param('ddddd', $id, $user_id, $game_id, $punct, $user_level_id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido actualizar la categoría correctamente" . $conn->error);
        }
    }

    public function insert_punctuations($punctuation)
    {
       // var_dump($punctuation->get_user_id()); exit();
        $conn = $this->datasource->get_connection();
        $sql = "INSERT INTO UserPunctuateGame(id_user, id_game, punctuation, create_date, id_user_level) VALUES (?,?,?,?,?)";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $user_id = $punctuation->get_user_id();
        $game_id = $punctuation->get_game_id();
        $puntuation = $punctuation->get_punctuation();
        $date = $punctuation->get_date();
        $user_level_id = $punctuation->get_user_level_id();
        $stmt->bind_param('dddsd', $user_id, $game_id, $puntuation, $date, $user_level_id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido puntuar correctamente" . $conn->error);
        }

        $total_rating= $this->getRatingByGameId($game_id);
        $this->updatePunctuactionGame($game_id, $total_rating);

        return $punctuation;
    }

    public function delete_punctuations($punctuation_id)
    {
        $conn = $this->datasource->get_connection();
        $sql = "DELETE FROM Userpunctuategame WHERE id_punctuaetion = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $punctuation_id;
        $stmt->bind_param('d', $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido eliminar la categoría correctamente" . $conn->error);
        }
    }

    public function getRatingByGame($game){
        $conn = $this->datasource->get_connection();
        $game_id = $game->get_id();
        $sql = "SELECT id_user_level, punctuation FROM UserPunctuateGame WHERE id_game = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $game_id);

        if ($stmt->execute() === FALSE) {
            throw new Exception("No se puede conectar con la base de datos" . $conn->error);
        }
        $stmt->bind_result($id_user_level, $punctuation);
        $number_of_rattings = 0;
        $rating = 0;
        while ($stmt->fetch()) {
            $number_of_rattings++;
            $rating += ($id_user_level * $punctuation);
        }
        $total_rating = $rating / $number_of_rattings;


        return $total_rating;


    }

    //Funció a la home per mostrar estrelletes
    public function getRatingByGameId($game_id){
        $conn = $this->datasource->get_connection();
        $sql = "SELECT id_user_level, punctuation FROM UserPunctuateGame WHERE id_game = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $game_id);

        if ($stmt->execute() === FALSE) {
            throw new Exception("No se puede conectar con la base de datos" . $conn->error);
        }
        $stmt->bind_result($id_user_level, $punctuation);
        $number_of_rattings = 0;
        $rating = 0;
        while ($stmt->fetch()) {
            $number_of_rattings++;
            $rating += ($id_user_level * $punctuation);
        }
        $total_rating = $rating / $number_of_rattings;


        return $total_rating;
    }

    public function updatePunctuactionGame($game_id,$total_rating){

        $conn = $this->datasource->get_connection();

        //var_dump($total_rating); exit();

        $sql = "UPDATE Game SET punctuation = ? WHERE  id_game = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('dd',$total_rating, $game_id);

        if ($stmt->execute() === FALSE) {
            throw new Exception("No se puede conectar con la base de datos ahora" . $conn->error);
        }
        //var_dump($total_rating); exit();

        $stmt->close();



    }




    public function userHasRated($id_user, $id_game){
        $conn = $this->datasource->get_connection();
        $sql = "SELECT * FROM UserPunctuateGame WHERE id_game = ? AND id_user = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('dd', $id_game, $id_user);


        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido actualizar la categoría correctamente" . $conn->error);
        }

        $stmt->store_result();
        $rnum = $stmt->num_rows;

        return $rnum > 0;
    }
}