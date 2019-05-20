<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../model/class-game.php");
require_once(__DIR__ . "/../model/class-user.php");
require_once(__DIR__ . "/../model/class-usercommentgame.php");

class commentDAO
{

    private $datasource;

    public function __construct()
    {
        $this->datasource = datasource::get_instance();
    }

    public function list_comments()
    {

        $conn = $this->datasource->get_connection();
        $sql = "SELECT * FROM Usercommentgame";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $user_id, $game_id, $comment, $date);
        $comments = [];
        while ($stmt->fetch()) {
            $comentario = new Comment();
            $comentario->set_id($id);
            $comentario->set_user_id($user_id);
            $comentario->set_game_id($game_id);
            $comentario->set_comment($comment);
            $comentario->set_date($date);
            $comments[] = $comentario;
        }
        $stmt->close();
        return $comments;

    }

    public function update_comment($comment)
    {
        $conn = $this->datasource->get_connection();
        $sql = "UPDATE Usercommentgame SET comment = ? WHERE user_id = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $comment->get_id();
        $user_id = $comment->get_user_id();
        $game_id = $comment->get_game_id();
        $comentario = $comment->get_comment();
        $stmt->bind_param('ddds', $id, $user_id, $game_id, $comentario);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido actualizar el comentario correctamente" . $conn->error);
        }
    }

    public function insert_comment($comment)
    {
        $conn = $this->datasource->get_connection();
        $sql = "INSERT INTO usercommentgame (id_user, id_game, comment, create_date) VALUES (?,?,?,?)";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $user_id = $comment->get_user_id();
        $game_id = $comment->get_game_id();
        $comentario = $comment->get_comment();
        $date = $comment->get_date();
        $stmt->bind_param('ddss', $user_id, $game_id, $comentario, $date);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido crear el comentario correctamente" . $conn->error);
        }
        $comment->set_id($conn->insert_id);
    }

    public function delete_comment($comment)
    {
        $conn = $this->datasource->get_connection();
        $sql = "DELETE FROM Userpunctuategame WHERE id_comment = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $comment->get_id();
        $stmt->bind_param('d', $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido eliminar el comentario correctamente" . $conn->error);
        }
    }
}