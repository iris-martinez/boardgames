<?php


class DataSource
{

    private $connection;

    public function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $schema = "rottenBoard";
        
        // Conectar DB
        $this->connection = new mysqli($servername, $username, $password);
        mysqli_set_charset($this->connection, "utf8");
        // Comprobar conexión
        if ($this->connection->connect_error) {
            die("<p style=\"color:red\">Error de conexión: </p><br>" . $this->connection->connect_error);
        }
        // Seleccionar bd
        $sql = "USE " . $schema;
        if ($this->connection->query($sql) === FALSE) {
            die("<br><p style=\"color:red\">La base de datos " . $schema . " no se ha podido seleccionar: </p><br>" . $this->connection->error);
        }
    }
    public function get_connection()
    {
        return $this->connection;
    }
}