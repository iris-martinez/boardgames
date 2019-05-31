<?php

require_once(__DIR__ . "/../dao/class-roleDAO.php");
require_once(__DIR__ . "/../model/class-role.php");

try {
    /**
     * test list_roles method
     */

    $roleDAO = new roleDAO();
    $roles = $roleDAO->list_roles();
    foreach ($roles as $role) {
        echo 'Test listar roles' . $role->get_role() . '<br>';
    }

    /**
     * test get_a_role method
     */
    $role = $roleDAO->get_a_role("USUARIO");
    echo (ISSET($role) ? 'existe' : 'no existe') . '<br>';
    echo $role->get_role() . '<br>';

    $role = $roleDAO->get_a_role("ADMIN");
    echo (ISSET($role) ? 'existe' : 'no existe') . '<br>';
    echo $role->get_role() . '<br>';

    /**
     * test insert_role method
     */
    try {
        $role = new role();
        $role->set_role("Dummy");
        $roleDAO->insert_role($role);
    } catch (Exception $e) {
        echo 'Great we cannot add duplicated roles.<br>';
    }


    /**
     * test delete_role method
     */
    $roleDAO->delete_role($role);
    $role = $roleDAO->get_a_role("Dummy");
    echo (ISSET($role) ? 'existe' : 'no existe') . '<br>';

} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
} finally {
    datasource::get_instance()->close_connection();
}


