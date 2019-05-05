<?php

require_once(__DIR__ . "/../model/class-user.php");
require_once(__DIR__ . "/../model/class-role.php");
require_once(__DIR__ . "/../model/class-user_level.php");
require_once(__DIR__ . "/../dao/class-datasource.php");

class userDAO
{
    private $datasource;

    public function __construct()
    {
        $this->datasource = datasource::get_instance();
    }

    public function list_users(): array
    {

        $conn = $this->datasource->get_connection();
        $sql = "SELECT u.id_user, u.name, u.surname, u.email, u.password, u.birth_date, u.register_date, r.id_role, r.role, l.id_user_level, l.user_level, u.counter_punctuation
                FROM User u 
                JOIN Role r USING (id_role)
                JOIN User_level l USING (id_user_level)";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $users = $this->extract_result_list($stmt);
        $stmt->close();
        return $users;

    }

    public function get_user_by_id($id): ?User
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT u.id_user, u.name, u.surname, u.email, u.password, u.birth_date, u.register_date, r.id_role, r.role, l.id_user_level, l.user_level, u.counter_punctuation
                FROM User u 
                JOIN Role r USING (id_role)
                JOIN User_level l USING (id_user_level) 
                WHERE u.id_user = ?";
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id);
        $stmt->execute();
        $user = $this->extract_single_result($stmt);
        $stmt->close();
        return $user;
    }

    public function get_user_by_name($name): array
    {
        $conn = $this->datasource->get_connection();
        $sql = "SELECT u.id_user, u.name, u.surname, u.email, u.password, u.birth_date, u.register_date, r.id_role, r.role, l.id_user_level, l.user_level, u.counter_punctuation
                FROM User u 
                JOIN Role r USING (id_role)
                JOIN User_level l USING (id_user_level) 
                WHERE u.name like ?";

        $id = null;
        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $search = "%" . $name . "%";
        $stmt->bind_param('s', $search);
        $stmt->execute();
        $users = $this->extract_result_list($stmt);
        $stmt->close();
        return $users;

    }

    public function update_user($user)
    {
        $conn = $this->datasource->get_connection();
        $sql = "UPDATE User  
                SET name = ?, surname = ?, email = ?, password = ?, birth_date = ?, register_date = ?, id_role = ?, id_user_level = ?, counter_punctuation = ?
                WHERE id_user = ?";

        $stmt = $conn->prepare($sql);

        $id_user = $user->get_id();
        $name = $user->get_name();
        $surname = $user->get_surname();
        $email = $user->get_email();
        $password = $user->get_password();
        $birth_date = $user->get_birthDate();
        $register_date = $user->get_registerDate();
        $id_role = $user->get_role()->get_id();
        $id_user_level = $user->get_userLevel()->get_id();
        $counter_punctuation = $user->get_counterPunctuation();

        $stmt->bind_param('ssssssdddd', $name, $surname, $email, $password, $birth_date, $register_date, $id_role, $id_user_level, $counter_punctuation, $id_user);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido actualizar el usuario." . $conn->error);
        }
        $stmt->close();
    }

    public function insert_user($user)
    {
        $conn = $this->datasource->get_connection();
        $sql = "INSERT INTO User (name, surname, email, password, birth_date, register_date, id_role, id_user_level, counter_punctuation) VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);


        $name = $user->get_name();
        $surname = $user->get_surname();
        $email= $user->get_email();
        $password = $user->get_password();
        $birth_date = $user->get_birthDate();
        $register_date = $user->get_registerDate();
        $id_role = $user->get_role()->get_id();
        $id_user_level = $user->get_userLevel()->get_id();
        $counter_punctuation = $user->get_counterPunctuation();

        $stmt->bind_param('ssssssddd', $name, $surname, $email, $password, $birth_date, $register_date, $id_role, $id_user_level, $counter_punctuation);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido insertar el usuario." . $conn->error);
        }
        $stmt->close();
        $user->set_id($conn->insert_id);
    }

    public function delete_user($user)
    {
        $conn = $this->datasource->get_connection();
        $sql = "DELETE FROM User WHERE id_user = ?";
        $stmt = $conn->prepare($sql);
        $id = $user->get_id();
        $stmt->bind_param('d', $id);
        if ($stmt->execute() === FALSE) {
            throw new Exception("No has podido eliminar el usuario." . $conn->error);
        }
        $stmt->close();
    }

    private function extract_single_result($stmt): ?User
    {
        $stmt->bind_result($id_user, $name, $surname, $email, $password, $birth_date, $register_date, $id_role, $role_name, $id_user_level, $name_user_level, $counter_punctuation);
        $user = null;
        if ($stmt->fetch()) {

            $role = new role();
            $role->set_id($id_role);
            $role->set_role($role_name);

            $user_level = new user_level();
            $user_level->set_id($id_user_level);
            $user_level->set_user_level($name_user_level);

            $user = new user();
            $user->set_id($id_user);
            $user->set_name($name);
            $user->set_surname($surname);
            $user->set_email($email);
            $user->set_password($password);
            $user->set_birthDate($birth_date);
            $user->set_registerDate($register_date);
            $user->set_role($role);
            $user->set_counterPunctuation($counter_punctuation);

        }

        return $user;
    }

    private function extract_result_list($stmt): array
    {
        $stmt->bind_result($id_user, $name, $surname, $email, $password, $birth_date, $register_date, $id_role, $role_name, $id_user_level, $name_user_level, $counter_punctuation);
        $users = [];
        while ($stmt->fetch()) {

            $role = new role();
            $role->set_id($id_role);
            $role->set_role($role_name);

            $user_level = new user_level();
            $user_level->set_id($id_user_level);
            $user_level->set_user_level($name_user_level);

            $user = new user();
            $user->set_id($id_user);
            $user->set_name($name);
            $user->set_surname($surname);
            $user->set_email($email);
            $user->set_password($password);
            $user->set_birthDate($birth_date);
            $user->set_registerDate($register_date);
            $user->set_role($role);
            $user->set_counterPunctuation($counter_punctuation);

            $users[] = $user;
        }
        return $users;
    }
}