<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../model/class-category.php");

class CategoryDAO
{

    private $datasource;

    public function __construct()
    {
        $this->datasource = datasource::get_instance();
    }

    public function list_categories()
    {

        $conn = $this->datasource->get_connection();
        $sql = "SELECT * FROM Category";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $name);
        $categories = [];
        while ($stmt->fetch()) {
            $category = new Category();
            $category->set_id($id);
            $category->set_name($name);
            $categories[] = $category;
        }
        $stmt->close();
        return $categories;

    }

    public function get_category_by_name($name)
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT * FROM Category WHERE name = ?";

        $id = null;
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($id, $name);
        $category = null;
        if ($stmt->fetch()) {
            $category = new Category();
            $category->set_id($id);
            $category->set_name($name);
        }
        $stmt->close();
        return $category;

    }

    public function update_category($category)
    {
        $conn = $this->datasource->get_connection();
        $sql = "UPDATE Category SET name = ? WHERE id_category = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $category->get_id();
        $name = $category->get_name();
        $stmt->bind_param('sd', $name, $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido actualizar la categoría correctamente" . $conn->error);
        }
    }

    public function insert_category($category)
    {
        $conn = $this->datasource->get_connection();
        $sql = "INSERT INTO Category(name) VALUES (?)";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $name = $category->get_name();
        $stmt->bind_param('s', $name);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido crear la categoría correctamente" . $conn->error);
        }
        $category->set_id($conn->insert_id);
    }

    public function delete_category($category)
    {
        $conn = $this->datasource->get_connection();
        $sql = "DELETE FROM Category WHERE id_category = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $category->get_id();
        $stmt->bind_param('d', $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido eliminar la categoría correctamente" . $conn->error);
        }
    }
}