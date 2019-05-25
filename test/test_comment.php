<?php

require_once(__DIR__ . "/../dao/class-usercommentgameDAO.php");
require_once(__DIR__ . "/../model/class-usercommentgame.php");

try {

    /**
     * test list_comments method
     */

    $commentDAO = new commentDAO();
    $comments = $commentDAO->list_comments();
    foreach ($comments as $comment) {
        echo "Test listar comentarios" . " " . $comment->get_comment() . '<br>';
    }
  
    /**
     * test insert_comment method
     */

    echo "---------------------------<br>";
    echo "test insert_comment method<br>";
    $comment = new comment();
    $comment->set_user_id(3);
    $comment->set_game_id(2);
    $comment->set_comment("Muy lento de aprender!");
    $comment->set_date("2019-05-25");
    $commentDAO->insert_comment($comment);

    /**
     * test delete_comment method
     */
    echo "---------------------------<br>";
    echo "test delete_comment method<br>";
    $comment = $comment->get_id(6);
    $commentDAO->delete_comment($comment);
    $comment = $commentDAO->get_id(6);
    echo (!empty($comment) ? 'existe' : 'no existe') . '<br>';



} finally {
    datasource::get_instance()->close_connection();
}
?>


