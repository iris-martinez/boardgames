<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../dao/class-userDAO.php");
require_once(__DIR__ . "/../dao/class-roleDAO.php");
require_once(__DIR__ . "/../model/class-role.php");
require_once(__DIR__ . "/../model/class-user.php");
require_once (__DIR__ . "/../logic/session.php");


$userDAO = new userDAO();
$rolDAO = new roleDAO();
try {

    $conn = new PDO("mysql:dbname=rottenBoardEN;host=localhost", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = "SELECT * FROM User WHERE email = :email AND  password = :password";

    $stmt = $conn->prepare($sql);

    $email = htmlentities(addslashes($_POST['email']));
    $password = htmlentities(addslashes($_POST['password']));

    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->bindValue(":password", $password, PDO::PARAM_STR);


    $stmt->execute();

    $numRegistre = $stmt->rowCount();

    //3 casos
    $userData = $stmt->fetch(PDO::FETCH_OBJ);

    // Si l'usuari és a la bd
    if ($numRegistre == 1) {

        session_start();
        $user = new userDAO();
        $_SESSION['email'] = $userData->email;
        $_SESSION['id_user'] =(int) $userData->id_user;


        $user_rol = (int)$userData->id_role;

        //Si l'usuari és admin
        if($user_rol == 1){
            header("location: ../views/templates/admin/admin_index.php");

            //Si l'usuari està registrat
        } elseif ($user_rol == 2){
            header("location: ../views/templates/public/index.html");
        }

        echo 'hola ' . $user_rol;

    //Si el login no és correcte
    } else {

        header("location: register.php");

    }
}catch (Exception $e){
    die ("Error: " .$e->getMessage());
}
?>