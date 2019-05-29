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

    public function list_comments(): array
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT *
                FROM UserCommentGame";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $comments = $this->extract_result_list($stmt);
        $stmt->close();
        return $comments;
    }

    public function get_comments_by_game($id_game): array
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT *
                FROM UserCommentGame
                WHERE id_game = ?";

        $id = null;
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id_game);
        $stmt->execute();
        $comments = $this->extract_result_list($stmt);
        $stmt->close();
        return $comments;
    }

    public function get_comment_by_id($id): ?Comment
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT *
                FROM UserCommentGame 
                WHERE id_comment = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id);
        $stmt->execute();
        $comment = $this->extract_single_result($stmt);
        $stmt->close();
        return $comment;
    }

    public function update_comment($comment)
    {
        $conn = $this->datasource->get_connection();
        $sql = "UPDATE UserCommentGame SET comment = ? WHERE id_comment = ?";
        $stmt = $conn->prepare($sql);

        $id = $comment->get_id();
        $comment_name = $comment->get_comment();

        $stmt->bind_param('sd', $comment_name, $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido actualizar el comentario." . $conn->error);
        }
        $stmt->close();
    }

    private function extract_result_list($stmt): array
    {
        $stmt->bind_result($id, $id_user, $id_game, $comment_name, $create_date);
        $comments = [];
        while ($stmt->fetch()) {

            $user = new user();
            $user->set_id($id_user);

            $game = new game();
            $game->set_id($id_game);

            $comment = new comment();
            $comment->set_id($id);
            $comment->set_comment($comment_name);
            $comment->set_date($create_date);

            $comments[] = $comment;
        }
        return $comments;
    }

    private function extract_single_result($stmt): ?Comment
    {
        $stmt->bind_result($id, $user_id, $game_id, $comment_name, $date);
        $comment = null;
        if ($stmt->fetch()) {

            $comment = new comment();
            $comment->set_id($id);
            $comment->set_user_id($user_id);
            $comment->set_game_id($game_id);
            $comment->set_comment($comment_name);
            $comment->set_date($date);
        }

        return $comment;
    }

    public function insert_comment($comment)
    {
        $conn = $this->datasource->get_connection();
        $sql = "INSERT INTO UserCommentGame (id_user, id_game, comment, create_date) VALUES (?,?,?,?)";
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
        $sql = "DELETE FROM UserCommentGame WHERE id_comment = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $comment->get_id();
        $stmt->bind_param('d', $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido eliminar el comentario correctamente" . $conn->error);
        }
    }
}