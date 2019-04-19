<?php

require_once(__DIR__ . "/../model/class-game.php");
require_once(__DIR__ . "/../dao/class-datasource.php");


class gameDAO
{
    private $datasource;

    public function __construct()
    {
        $this->datasource = datasource::get_instance();
    }

    public function list_games()
    {

        $conn = $this->datasource->get_connection();
        $sql = "SELECT * FROM Game";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $name, $author, $number_players, $description, $duration, $image, $score, $category, $user);
        $games = [];
        while ($stmt->fetch()) {
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
        $stmt->close();
        return $games;

    }
}

?>