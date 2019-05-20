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
        $conn = $this->datasource->get_connection();
        $sql = "INSERT INTO userpunctuategame(punctuation) VALUES (?)";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $user_id = $punctuation->get_user_id();
        $game_id = $punctuation->get_game_id();
        $punctuation = $punctuation->get_punctuation();
        $user_level_id = $punctuation->get_user_level_id();
        $stmt->bind_param('dddd', $user_id, $game_id, $punctuation, $user_level_id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido crear la categoría correctamente" . $conn->error);
        }
        $category->set_id($conn->insert_id);
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