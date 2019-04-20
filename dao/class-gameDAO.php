<?php

require_once(__DIR__ . "/../model/class-game.php");
require_once(__DIR__ . "/../model/class-category.php");
require_once(__DIR__ . "/../dao/class-datasource.php");


class gameDAO
{
    private $datasource;

    public function __construct()
    {
        $this->datasource = datasource::get_instance();
    }

    public function list_games(): array
    {

        $conn = $this->datasource->get_connection();
        $sql = "SELECT id_game, g.name, author, number_players, description, duration, 
                       image, punctuation, id_user, c.id_category, c.name 
                FROM Game g join Category c using (id_category)";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $games = $this->extract_result_list($stmt);
        $stmt->close();
        return $games;

    }

    public function get_game_by_id($id): Game
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT id_game, g.name, author, number_players, description, duration, 
                       image, punctuation, id_user, c.id_category, c.name 
                FROM Game g join Category c using (id_category) 
                where id_game = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id);
        $stmt->execute();
        $game = $this->extract_single_result($stmt);
        $stmt->close();
        return $game;
    }

    public function get_game_by_name($name): array
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT id_game, g.name, author, number_players, description, duration, 
                       image, punctuation, id_user, c.id_category, c.name 
                FROM Game g join Category c using (id_category) 
                WHERE g.name like ?";

        $id = null;
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $search = "%" . $name . "%";
        $stmt->bind_param('s', $search);
        $stmt->execute();
        $games = $this->extract_result_list($stmt);
        $stmt->close();
        return $games;

    }

    public function get_game_by_author($author): array
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT id_game, g.name, author, number_players, description, duration, 
                       image, punctuation, id_user, c.id_category, c.name 
                FROM Game g join Category c using (id_category) 
                WHERE author = ?";

        $id = null;
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $author);
        $stmt->execute();
        $games = $this->extract_result_list($stmt);
        $stmt->close();
        return $games;

    }

    public function get_game_by_category($category): array
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT id_game, g.name, author, number_players, description, duration, 
                       image, punctuation, id_user, c.id_category, c.name 
                FROM Game g join Category c using (id_category)  
                WHERE c.id_category = ?";

        $id = null;
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $category);
        $stmt->execute();
        $games = $this->extract_result_list($stmt);
        $stmt->close();
        return $games;

    }

    private function extract_result_list($stmt): array
    {
        $stmt->bind_result($id, $name, $author, $number_players, $description, $duration, $image, $score, $user, $id_category, $name_category);
        $games = [];
        while ($stmt->fetch()) {

            $category = new category();
            $category->set_id($id_category);
            $category->set_name($name_category);

            $game = new Game();
            $game->set_id($id);
            $game->set_name($name);
            $game->set_author($author);
            $game->set_number_players($number_players);
            $game->set_description($description);
            $game->set_duration($duration);
            $game->set_image($image);
            $game->set_score($score);
            $game->set_category($category);
            $game->set_user($user);

            $games[] = $game;
        }
        return $games;
    }

    private function extract_single_result($stmt): Game
    {
        $stmt->bind_result($id, $name, $author, $number_players, $description, $duration, $image, $score, $user, $id_category, $name_category);
        $game = null;
        if ($stmt->fetch()) {

            $category = new category();
            $category->set_id($id_category);
            $category->set_name($name_category);

            $game = new Game();
            $game->set_id($id);
            $game->set_name($name);
            $game->set_author($author);
            $game->set_number_players($number_players);
            $game->set_description($description);
            $game->set_duration($duration);
            $game->set_image($image);
            $game->set_score($score);
            $game->set_category($category);
            $game->set_user($user);

        }

        return $game;
    }

    public function update_game($game)
    {
        $conn = $this->datasource->get_connection();
        $sql = "UPDATE Game SET (name = ?, author = ?, number_players = ?, description = ?, duration = ?, image = ?) WHERE id_game = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $game->get_id();
        $name = $game->get_name();
        $author = $game->get_name();
        $stmt->bind_param('sd', $name, $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido actualizar la categoría correctamente" . $conn->error);
        }
    }
}

?>