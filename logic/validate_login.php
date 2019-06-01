<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../dao/class-userDAO.php");
require_once(__DIR__ . "/../model/class-role.php");
require_once(__DIR__ . "/../model/class-user.php");
require_once(__DIR__ . "/../logic/session.php");


$userDAO = new userDAO();
try {

    $email = htmlentities(addslashes($_POST['email']));
    $password = htmlentities(addslashes($_POST['password']));
    $user = $userDAO->get_user_by_email($email);

    $validUser = isset($user) && $user->get_password() == $password;

    // Si l'usuari és a la bd
    if ($validUser) {

        session_destroy();
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['id_user'] = $user->get_id();

        $user_rol = $user->get_role()->get_role();

        //Si l'usuari és admin
        if ($user_rol == 'ADMIN') {
            header("location: admin_index.php");

            //Si l'usuari està registrat
        } elseif ($user_rol == 'USUARIO') {
            header("location: public_index.php");
        } else {
            die ("Invalid role: " . $user->get_role()->get_role());
        }

        //Si el login no és correcte
    } else {
        $_SESSION['fallo_login'] = 'fallo inicio de sesion, datos incorrectos';
        //print "alert(Usuario o contraseña incorrectos)";
        header("location: login.php");

        //echo "<div class=\"notificacion error\">Usuario o contraseña incorrectos</div>";

    }
} catch (Exception $e) {
    die ("Error: " . $e->getMessage());
} finally {
    datasource::get_instance()->close_connection();
}
?>