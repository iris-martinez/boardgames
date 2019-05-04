<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../model/class-user_level.php");

class user_levelDAO
{
    private $datasource;

    public function __construct()
    {
        $this->datasource = datasource::get_instance();
    }

    public function list_user_levels()
    {

        $conn = $this->datasource->get_connection();
        $sql = "SELECT * FROM User_level";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $user_level_name);
        $user_levels = [];
        while ($stmt->fetch()) {
            $user_level = new user_level();
            $user_level->set_id($id);
            $user_level->set_user_level($user_level_name);
            $user_levels[] = $user_level;
        }
        $stmt->close();
        return $user_levels;

    }

    public function get_user_level_by_id($id): ?User_level
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT id_user_level, user_level
                FROM User_level WHERE id_user_level = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id);
        $stmt->execute();
        $game = $this->extract_single_result($stmt);
        $stmt->close();
        return $game;
    }

    public function get_user_level_by_name($name): array
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT id_user_level, user_level
                FROM User_level 
                WHERE user_level like ?";

        $id = null;
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $search = "%" . $name . "%";
        $stmt->bind_param('s', $search);
        $stmt->execute();
        $user_levels = $this->extract_result_list($stmt);
        $stmt->close();
        return $user_levels;

    }

    private function extract_single_result($stmt): ?User_level
    {
        $stmt->bind_result($id_user_level, $user_level_name);
        $user_level = null;
        if ($stmt->fetch()) {

            $user_level = new user_level();
            $user_level->set_id($id_user_level);
            $user_level->set_user_level($user_level_name);

        }

        return $user_level;
    }

    private function extract_result_list($stmt): array
    {
        $stmt->bind_result($id_user_level, $user_level_name);
        $user_levels = [];
        while ($stmt->fetch()) {

            $user_level = new user_level();
            $user_level->set_id($id_user_level);
            $user_level->set_user_level($user_level_name);

            $user_levels[] = $user_level;
        }
        return $user_levels;
    }

    public function insert_user_level($user_level)
    {
        $conn = $this->datasource->get_connection();
        $sql = "INSERT INTO User_level (user_level) VALUES (?)";
        $stmt = $conn->prepare($sql);

        $user_level_name = $user_level->get_user_level();

        $stmt->bind_param('s', $user_level_name);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido insertar el nivel del usuario." . $conn->error);
        }
        $stmt->close();
        $user_level->set_id($conn->insert_id);
    }

    public function delete_user_level($user_level)
    {
        $conn = $this->datasource->get_connection();
        $sql = "DELETE FROM User_level WHERE id_user_level = ?";
        $stmt = $conn->prepare($sql);
        $id = $user_level->get_id();
        $stmt->bind_param('d', $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido eliminar el nivel del usuario." . $conn->error);
        }
        $stmt->close();
    }

}