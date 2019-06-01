<?php

require_once(__DIR__ . "/../dao/class-usercommentgameDAO.php");
require_once(__DIR__ . "/../dao/class-gameDAO.php");
require_once(__DIR__ . "/../dao/class-userDAO.php");
require_once(__DIR__ . "/../model/class-game.php");
require_once(__DIR__ . "/../model/class-user.php");
require_once(__DIR__ . "/../model/class-usercommentgame.php");


try {

    /**
     * test list_comments method
     */
    $commentDAO = new commentDAO();
    $comments = $commentDAO->list_comments();
    foreach ($comments as $comment) {
        echo "Test listar comentarios" . " " . $comment->get_id() . '<br>';
        echo "Test listar comentarios" . " " . $comment->get_user_id() . '<br>';
        echo "Test listar comentarios" . " " . $comment->get_game_id() . '<br>';
        echo "Test listar comentarios" . " " . $comment->get_comment() . '<br>';
        echo "Test listar comentarios" . " " . $comment->get_date() . '<br>';
    }

    /**
     * test get_comments_by_game method
     */
    echo "---------------------------<br>";
    echo "test get_comments_by_game method<br>";
    $comments = $commentDAO->get_comments_by_game(2);
    foreach ($comments as $comment) {
        echo (ISSET($comment) ? 'existe' : 'no existe') . '<br>';
        echo $comment->get_comment() . '<br>';
    }
    echo "---------------------------<br>";

    /**
     * test update_comment method
     */
    echo "---------------------------<br>";
    echo "test update_comment method<br>";
    $comment = $commentDAO->get_comment_by_id(2);
    $comment->set_comment("Esto es un nuevo comentario");
    $commentDAO->update_comment($comment);
    $comment = $commentDAO->get_comment_by_id(2);
    echo 'First update' . ' ' . $comment->get_comment() . '<br>';

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
    $comment = $commentDAO->get_comment_by_id(1);
    $commentDAO->delete_comment($comment);
    $comment = $commentDAO->get_comment_by_id(1);
    echo (!empty($comment) ? 'existe' : 'no existe') . '<br>';


} finally {
    datasource::get_instance()->close_connection();
}

?>


