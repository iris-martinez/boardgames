<?php

require_once(__DIR__ . "/../model/class-game.php");
require_once(__DIR__ . "/../model/class-category.php");
require_once(__DIR__ . "/../model/class-user.php");
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

/*        $conn = $this->datasource->get_connection();
        $sql = "SELECT * FROM Game";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id_game, $name);
        $categories = [];
        while ($stmt->fetch()) {
            $game = new Game();
            $game->set_id($id_game);
            $game->set_name($name);

        }
        $stmt->close();
        return $categories;
*/


        $conn = $this->datasource->get_connection();
        $sql = "SELECT * FROM Game";
        /*
        $sql = "SELECT id_game, g.name, author, number_players, description, duration,
                       image, punctuation, id_user, c.id_category, c.name
                FROM Game g JOIN Category c USING (id_category)";*/
        /*$sql = "SELECT id_game, g.name, author, number_players, description, duration,
                       image, punctuation, id_user, c.id_category, c.name
                FROM Game g JOIN Category c USING (id_category)";*/

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
       // var_dump($this->extract_result_list($stmt)); exit();
        $games = $this->extract_result_list($stmt);
        //var_dump($games); exit();
        $stmt->close();

        return $games;

    }

    public function get_game_by_id($id): ?Game
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT id_game, g.name, author, number_players, description, duration, 
                       image, punctuation, id_user, c.id_category, c.name 
                FROM Game g JOIN Category c USING (id_category) 
                WHERE id_game = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id);
        $stmt->execute();
        $game = $this->extract_single_result($stmt);
        $stmt->close();
        return $game;
    }

    public function get_game_by_name($name)
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT id_game, g.name, author, number_players, description, duration, 
                       image, punctuation, id_user, c.id_category, c.name 
                FROM Game g JOIN Category c USING (id_category) 
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

    public function get_game_by_author($author)
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

    public function get_game_by_category($category)
    {
        var_dump($category); exit();
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

    private function extract_result_list($stmt)
    {

        $stmt->bind_result($id_game, $name, $author, $number_players, $description, $duration, $image, $punctuation, $id_category, $id_user);
        $games = [];

        while ($stmt->fetch()) {

            $category = new category();
            $category->set_id($id_category);
            //$category->set_name($name_category);
//var_dump($category); exit();
            $game = new Game();
            $game->set_id_game($id_game);
            $game->set_name($name);
            $game->set_author($author);
            $game->set_number_players($number_players);
            $game->set_description($description);
            $game->set_duration($duration);
            $game->set_image($image);
            $game->set_punctuation($punctuation);
            $game->set_id_category($id_category);
            $game->set_id_user($id_user);

            $games[] = $game;
        }
        return $games;
    }

    private function extract_single_result($stmt)
    {
        $stmt->bind_result($id_game, $name, $author, $number_players, $description, $duration, $image, $punctuation, $id_user, $id_category);
        $game = null;
        if ($stmt->fetch()) {

            $category = new category();
            $category->set_id($id_category);
            $category->set_name($name_category);

            $game = new Game();
            $game->set_id_game($id_game);
            $game->set_name($name);
            $game->set_author($author);
            $game->set_number_players($number_players);
            $game->set_description($description);
            $game->set_duration($duration);
            $game->set_image($image);
            $game->set_punctuation($punctuation);
            $game->set_id_category($category);
            $game->set_id_user($id_user);

        }

        return $game;
    }

    public function update_game($game)
    {
        $conn = $this->datasource->get_connection();
        $sql = "UPDATE Game SET name = ?, author = ?, number_players = ?, description = ?, duration = ?, image = ?, punctuation = ?, id_user = ?, id_category = ?  WHERE id_game = ?";
        $stmt = $conn->prepare($sql);

        $id = $game->get_id();
        $name = $game->get_name();
        $author = $game->get_author();
        $number_players= $game->get_number_players();
        $description = $game->get_description();
        $duration = $game->get_duration();
        $image = $game->get_image();
        $punctuation = $game->get_punctuation();
        $id_user = $game->get_user()->get_id();
        $id_category = $game->get_category()->get_id();

        $stmt->bind_param('ssdsssdddd', $name, $author, $number_players, $description, $duration, $image, $punctuation, $id_user, $id_category, $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido actualizar el juego." . $conn->error);
        }
        $stmt->close();
    }

    public function insert_game($game)
    {
        $conn = $this->datasource->get_connection();
        $sql = "INSERT INTO Game (name, author, number_players, description, duration, image, punctuation, id_user, id_category) VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);

        $name = $game->get_name();
        $author = $game->get_author();
        $number_players= $game->get_number_players();
        $description = $game->get_description();
        $duration = $game->get_duration();
        $image = $game->get_image();
        $punctuation = $game->get_punctuation();
        $id_user = $game->get_id_user();
        $id_category = $game->get_id_category();

        $stmt->bind_param('ssdsssddd', $name, $author, $number_players, $description, $duration, $image, $punctuation, $id_user, $id_category);

        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido insertar el juego." . $conn->error);
        }
        $stmt->close();
        $game->set_id_game($conn->insert_id);
    }

    public function delete_game($game)
    {
        $conn = $this->datasource->get_connection();
        $sql = "DELETE FROM Game WHERE id_game = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $game);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido eliminar el juego." . $conn->error);
        }
        $stmt->close();
    }
}
?>