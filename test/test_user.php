<?php

require_once(__DIR__ . "/../dao/class-userDAO.php");
require_once(__DIR__ . "/../model/class-user.php");
require_once(__DIR__ . "/../dao/class-roleDAO.php");
require_once(__DIR__ . "/../model/class-role.php");
require_once(__DIR__ . "/../dao/class-user_levelDAO.php");
require_once(__DIR__ . "/../model/class-user_level.php");

try {

    /**
     * test list_users method
     */
    $roleDAO = new roleDAO();
    $user_levelDAO = new user_levelDAO();
    $userDAO = new userDAO();
    $users = $userDAO->list_users();
    foreach ($users as $user) {
        echo "Test listar usuarios" . " " . $user->get_id() . '<br>';
        echo "Test listar usuarios" . " " . $user->get_name() . '<br>';
        echo "Test listar usuarios" . " " . $user->get_surname() . '<br>';
        echo "Test listar usuarios" . " " . $user->get_email() . '<br>';
        echo "Test listar usuarios" . " " . $user->get_password() . '<br>';
        echo "Test listar usuarios" . " " . $user->get_birthDate() . '<br>';
        echo "Test listar usuarios" . " " . $user->get_registerDate() . '<br>';
        echo "Test listar usuarios" . " " . $user->get_role() . '<br>';
        echo "Test listar usuarios" . " " . $user->get_userLevel() . '<br>';
        echo "Test listar usuarios" . " " . $user->get_counterPunctuation() . '<br>';
    }

    /**
     * test get_user_by_id method
     */
    /*
    echo "---------------------------<br>";
    echo "test get_user_by_id method<br>";
    $user = $userDAO->get_user_by_id(2);
    echo (ISSET($user) ? 'existe' : 'no existe') . '<br>';
    echo $user->get_id() . '<br>';
    echo $user->get_name() . '<br>';
    echo $user->get_surname() . '<br>';
    echo $user->get_email() . '<br>';
    echo $user->get_password() . '<br>';
    echo $user->get_birthDate() . '<br>';
    echo $user->get_registerDate() . '<br>';
    echo $user->get_role() . '<br>';
    echo $user->get_userLevel() . '<br>';
    echo $user->get_counterPunctuation() . '<br>';*/

    /**
     * test get_user_by_name method
     */
    /*
    echo "---------------------------<br>";
    echo "test get_user_by_name method<br>";
    $users = $userDAO->get_user_by_name('admin1');
    foreach ($users as $user) {
        echo (ISSET($user) ? 'existe' : 'no existe') . '<br>';
        echo $user->get_id() . '<br>';
        echo $user->get_name() . '<br>';
        echo $user->get_surname() . '<br>';
        echo $user->get_email() . '<br>';
        echo $user->get_password() . '<br>';
        echo $user->get_birthDate() . '<br>';
        echo $user->get_registerDate() . '<br>';
        echo $user->get_role() . '<br>';
        echo $user->get_userLevel() . '<br>';
        echo $user->get_counterPunctuation() . '<br>';
    }
    echo "---------------------------<br>";*/

    /**
     * test update_user method
     */
    /*echo "---------------------------<br>";
    echo "test update_user method<br>";
    $user = $userDAO->get_user_by_name("admin2")[0];
    $role= $roleDAO->get_a_role("ADMIN");
    $user_level = $user_levelDAO->get_user_level_by_name("Experto")[0];
    $user->set_name("Test update");
    $user->set_surname("Funciona");
    $user->set_email("mdelcerro@test.com");
    $user->set_password("estoesunpass1");
    $user->set_birthDate("1985-11-03");
    $user->set_registerDate("2019-05-01");
    $user->set_registerDate("2019-05-01");
    $user->set_role($role);
    $user->set_userLevel($user_level);
    $user->set_counterPunctuation(8);
    $userDAO->update_user($user);
    $user = $userDAO->get_user_by_name("Test update")[0];
    echo 'First update' . ' ' . $user->get_name() . '<br>';
    echo 'First update' . ' ' . $user->get_surname() . '<br>';
    echo 'First update' . ' ' . $user->get_email() . '<br>';
    echo 'First update' . ' ' . $user->get_password() . '<br>';
    echo 'First update' . ' ' . $user->get_birthDate() . '<br>';
    echo 'First update' . ' ' . $user->get_registerDate() . '<br>';
    echo 'First update' . ' ' . $user->get_role() . '<br>';
    echo 'First update' . ' ' . $user->get_userLevel() . '<br>';
    echo 'First update' . ' ' . $user->get_counterPunctuation() . '<br>';*/

    /**
     * test insert_user method
     */
    echo "---------------------------<br>";
    echo "test insert_user method<br>";
    $user = new user();
    $role= $roleDAO->get_a_role("ADMIN");
    $user_level = $user_levelDAO->get_user_level_by_name("Experto")[0];
    $user->set_name("Dummy");
    $user->set_surname("Funciona");
    $user->set_email("mdelcerro@test.com");
    $user->set_password("estoesunpass1");
    $user->set_birthDate("1985-11-03");
    $user->set_registerDate("2019-05-01");
    $user->set_registerDate("2019-05-01");
    $user->set_role($role);
    $user->set_userLevel($user_level);
    $user->set_counterPunctuation(8);
    $userDAO->insert_user($user);

    /**
     * test delete_user method
     */
    /*echo "---------------------------<br>";
    echo "test delete_user method<br>";
    $user = $userDAO->get_user_by_name("Dummy")[0];
    $userDAO->delete_user($user);
    $user = $userDAO->get_user_by_name("Dummy");
    echo (!empty($user) ? 'existe' : 'no existe') . '<br>';*/

} finally {
    datasource::get_instance()->close_connection();
}
?>