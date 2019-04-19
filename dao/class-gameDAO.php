<?php

require_once(__DIR__."/../model/class-game.php");
require_once(__DIR__."/../dao/class-datasource.php");


class gameDAO
{
    private $datasource;
    private $gameDAO;


    public function __construct(){
        $this->datasource = new datasource();
        $this->gameDAO = new gameDAO();
    }
    public function get_game_by_id($id) {
        $conn = $this->datasource->get_conexion();
        $sql = "SELECT * Game FROM  WHERE idGame = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id);
        $stmt->execute();
        $stmt->bind_result($id);
        $game = new game();
        if ($stmt->fetch()) {
            $compra->set_id($id);
            $compra->set_cliente($this->gameDAO->get_game_by_id($id));
                   }
        $stmt->close();
        return $game;
    }
    public function insert_game($game) {
        $conn = $this->datasource->get_conexion();
        $sql = "INSERT INTO Game (idGame,name,author,numberPlayers,description,duration,image) VALUES (?, ?, ?, ?, ?, ?, ?)";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $game->get_id();
        $id_cliente = $compra->get_cliente()->get_id();
        $stmt->bind_param('dd', $id, $id_cliente);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido crear el producto correctamente" . $conn->error);
        }
        $compra->set_id($conn->insert_id);
        foreach ($compra->get_productos_comprados() as $producto_comprado) {
            $this->producto_compradoDAO->insertar_producto_comprado($producto_comprado);
        }
    }
}

?>