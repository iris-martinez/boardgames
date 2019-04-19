<?php


class datasource
{

    private static $instance;
    private $connection;

    public static function get_instance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __construct() {

    }

    private function create_connection()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $schema = "rottenBoardEN";

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
        if ($this->connection == null) {
            $this->create_connection();
        }

        return $this->connection;
    }

    public function close_connection() {
        if ($this->connection != null) {
            $this->connection->close();
            $this->connection = null;
        }
    }
}