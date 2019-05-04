<?php

require_once(__DIR__ . "/../dao/class-user_levelDAO.php");
require_once(__DIR__ . "/../model/class-user.php");

try {

    /**
     * test list_user_levels method
     */
    $user_levelDAO = new user_levelDAO();
    $user_levels = $user_levelDAO->list_user_levels();
    foreach ($user_levels as $user_level) {
        echo "Test listar niveles de usuario" . " " . $user_level->get_id() . '<br>';
        echo "Test listar niveles de usuario" . " " . $user_level->get_user_level() . '<br>';
    }

    /**
     * test get_user_level_by_id method
     */
    $user_level = $user_levelDAO->get_user_level_by_id(2);
    echo (ISSET($user_level) ? 'existe' : 'no existe') . '<br>';
    echo $user_level->get_id() . '<br>';
    echo $user_level->get_user_level() . '<br>';

    /**
     * test get_user_level_by_name method
     */
    echo "---------------------------<br>";
    echo "test get_user_level_by_name method<br>";
    $user_levels = $user_levelDAO->get_user_level_by_name('Intermedio');
    foreach ($user_levels as $user_level) {
        echo (ISSET($user_level) ? 'existe' : 'no existe') . '<br>';
        echo $user_level->get_id() . '<br>';
        echo $user_level->get_user_level() . '<br>';
    }
    echo "---------------------------<br>";

    /**
     * test insert_user_level method
     */
    echo "---------------------------<br>";
    echo "test insert_user_level method<br>";
    $user_level = new user_level();
    $user_level->set_user_level("Dummy");
    $user_levelDAO->insert_user_level($user_level);

    /**
     * test delete_user_level method
     */
    /*echo "---------------------------<br>";
    echo "test delete_user_level method<br>";
    $user_level = $user_levelDAO->get_user_level_by_name("Novato")[0];
    $user_levelDAO->delete_user_level($user_level);
    $user_level = $user_levelDAO->get_user_level_by_name("Novato");
    echo (!empty($user_level) ? 'existe' : 'no existe') . '<br>';*/

} finally {
    datasource::get_instance()->close_connection();
}
?>