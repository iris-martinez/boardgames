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

    public function get_punctuations_by_game($id_game): array
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT *
                FROM UserPunctuateGame
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

    public function get_punctuation_by_id($id): ?Punctuation
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT *
                FROM UserPunctuateGame 
                WHERE id_punctuation = ?";
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
        $sql = "UPDATE UserPunctuatetGame SET punctuation = ? WHERE id_punctuation = ?";
        $stmt = $conn->prepare($sql);

        $id = $punctuation->get_id();
        $punctuation_name = $punctuation->get_punctuation();

        $stmt->bind_param('sd', $punctuation_name, $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido actualizar la puntuación ." . $conn->error);
        }
        $stmt->close();
    }

    private function extract_result_list($stmt): array
    {
        $stmt->bind_result($id, $id_user, $id_game, $punctuation_name, $create_date, $id_user_level);
        $punctuations = [];
        while ($stmt->fetch()) {
            $punctuation = new punctuations();
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
        $stmt->bind_result($id, $user_id, $game_id, $punctuation_name, $date);
        $punctuation = null;
        if ($stmt->fetch()) {

            $punctuation = new punctuations();
            $punctuation->set_id($id);
            $punctuation->set_user_id($user_id);
            $punctuation->set_game_id($game_id);
            $punctuation->set_punctuation($punctuation_name);
            $punctuation->set_date($date);
        }

        return $punctuation;
    }

    public function insert_punctuations($punctuation)
    {
        $conn = $this->datasource->get_connection();
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
        $punctuation->set_id($conn->insert_id);
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
}