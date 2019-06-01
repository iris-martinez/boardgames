<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../model/class-game.php");
require_once(__DIR__ . "/../model/class-user.php");
require_once(__DIR__ . "/../model/class-userpunctuategame.php");

class punctuationDAO
{

    private $datasource;

    public function __construct()
    {
        $this->datasource = datasource::get_instance();
    }

    public function list_punctuations(): array
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT *
                FROM UserPunctuateGame";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $punctuations = $this->extract_result_list($stmt);
        $stmt->close();
        return $punctuations;

    }

    public function get_punctuations_by_game($id_game): array
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT *
                FROM UserpunctuateGame
                WHERE id_game = ?";

        $id = null;
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id_game);
        $stmt->execute();
        $punctuations = $this->extract_result_list($stmt);
        $stmt->close();
        return $punctuations;
    }

    public function get_punctuation_by_id($id): ?punctuation
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT *
                FROM UserPunctuateGame 
                WHERE id_punctuatecion = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id);
        $stmt->execute();
        $punctuation = $this->extract_single_result($stmt);
        $stmt->close();
        return $punctuation;
    }

    public function update_punctuation($punctuation)
    {
        $conn = $this->datasource->get_connection();
        $sql = "UPDATE UserpunctuateGame SET punctuation = ? WHERE id_punctuatecion = ?";
        $stmt = $conn->prepare($sql);

        $id = $punctuation->get_id();
        $punctuation_name = $punctuation->get_punctuation();

        $stmt->bind_param('sd', $punctuation_name, $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido actualizar la puntuación." . $conn->error);
        }
        $stmt->close();
    }

    private function extract_result_list($stmt): array
    {
        $stmt->bind_result($id, $id_user, $id_game, $punctuation_name, $create_date, $id_user_level);
        $punctuations = [];
        while ($stmt->fetch()) {
            $punctuation = new punctuation();
            $punctuation->set_id($id);
            $punctuation->set_punctuation($punctuation_name);
            $punctuation->set_date($create_date);
            $punctuation->set_user_id($id_user);
            $punctuation->set_game_id($id_game);
            $punctuation->set_user_level_id($id_user_level);

            $punctuations[] = $punctuation;
        }
        return $punctuations;
    }

    private function extract_single_result($stmt): ?punctuation
    {
        $stmt->bind_result($id, $user_id, $game_id, $punctuation_name, $date, $id_user_level);
        $punctuation = null;
        if ($stmt->fetch()) {

            $punctuation = new punctuation();
            $punctuation->set_id($id);
            $punctuation->set_user_id($user_id);
            $punctuation->set_game_id($game_id);
            $punctuation->set_punctuation($punctuation_name);
            $punctuation->set_date($date);
            $punctuation->set_user_level_id($id_user_level);
        }

        return $punctuation;
    }

    public function insert_punctuation($punctuation)
    {
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

    public function delete_punctuation($punctuation)
    {
        $conn = $this->datasource->get_connection();
        $sql = "DELETE FROM UserpunctuateGame WHERE id_punctuatecion = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $punctuation;
        $stmt->bind_param('d', $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido eliminar la puntuación correctamente" . $conn->error);
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