<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../model/class-role.php");

class roleDAO
{

    private $datasource;

    public function __construct()
    {
        $this->datasource = datasource::get_instance();
    }

    public function list_roles()
    {

        $conn = $this->datasource->get_connection();
        $sql = "SELECT * FROM Role";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $role_name);
        $roles = [];
        while ($stmt->fetch()) {
            $role = new role();
            $role->set_id($id);
            $role->set_role($role_name);
            $roles[] = $role;
        }
        $stmt->close();
        return $roles;

    }

    public function get_a_role($role_name)
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT * FROM Role WHERE role = ?";

        $id = null;
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $role_name);
        $stmt->execute();
        $stmt->bind_result($id, $role_name);
        $role = null;
        if ($stmt->fetch()) {
            $role = new role();
            $role->set_id($id);
            $role->set_role($role_name);
        }
        $stmt->close();
        return $role;

    }

    public function insert_role($role)
    {
        $conn = $this->datasource->get_connection();
        $sql = "INSERT INTO Role(role) VALUES (?)";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $role_name = $role->get_role();
        $stmt->bind_param('s', $role_name);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido crear el rol correctamente" . $conn->error);
        }
        $role->set_id($conn->insert_id);
    }

    public function delete_role($role)
    {
        $conn = $this->datasource->get_connection();
        $sql = "DELETE FROM Role WHERE id_role = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $role->get_id();
        $stmt->bind_param('d', $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido eliminar el rol correctamente" . $conn->error);
        }
    }

    public function get_rol_by_id($id_rol)
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT * FROM Role WHERE id_role = ?";

        $id = null;
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id_rol);
        $stmt->execute();
        $stmt->bind_result($id, $role_name);
        $role = null;
        if ($stmt->fetch()) {
            $role = new role();
            $role->set_id($id);
            $role->set_role($role_name);
        }
        $stmt->close();
        return $role;
    }

}

