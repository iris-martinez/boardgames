<?php

require_once(__DIR__ . "/../dao/class-gameDAO.php");
require_once(__DIR__ . "/../dao/class-userDAO.php");
require_once(__DIR__ . "/../dao/class-categoryDAO.php");
require_once(__DIR__ . "/../model/class-game.php");
require_once(__DIR__ . "/../model/class-category.php");
require_once(__DIR__ . "/../model/class-user.php");

try {

    /**
     * test list_games method
     */
    $gameDAO = new GameDAO();
    $categoryDAO = new CategoryDAO();
    $userDAO = new userDAO();
    $games = $gameDAO->list_games();
    foreach ($games as $game) {
        echo "Test listar juegos" . " " . $game->get_id() . '<br>';
        echo "Test listar juegos" . " " . $game->get_name() . '<br>';
        echo "Test listar juegos" . " " . $game->get_author() . '<br>';
        echo "Test listar juegos" . " " . $game->get_category() . '<br>';
    }

    /**
     * test get_game_by_id method
     */
    $game = $gameDAO->get_game_by_id(2);
    echo (ISSET($game) ? 'existe' : 'no existe') . '<br>';
    echo $game->get_id() . '<br>';
    echo $game->get_name() . '<br>';
    echo $game->get_author() . '<br>';
    echo $game->get_category() . '<br>';

    /**
     * test get_game_by_name method
     */
    echo "---------------------------<br>";
    echo "test get_game_by_name method<br>";
    $games = $gameDAO->get_game_by_name('Love');
    foreach ($games as $game) {
        echo (ISSET($game) ? 'existe' : 'no existe') . '<br>';
        echo $game->get_id() . '<br>';
        echo $game->get_name() . '<br>';
        echo $game->get_author() . '<br>';
        echo $game->get_category() . '<br>';
    }
    echo "---------------------------<br>";

    /**
     * test get_game_by_author method
     */
    $games = $gameDAO->get_game_by_author('Seiji Kanai');
    foreach ($games as $game) {
        echo (ISSET($game) ? 'existe' : 'no existe') . '<br>';
        echo $game->get_id() . '<br>';
        echo $game->get_name() . '<br>';
        echo $game->get_author() . '<br>';
        echo $game->get_category() . '<br>';
    }

    /**
     * test insert_game method
     */
    /*echo "---------------------------<br>";
    echo "test insert_game method<br>";
    $game = new Game();
    $category= $categoryDAO->get_category_by_name("Wargame");
    $user = $userDAO->get_user_by_name("user2")[0];
    $game->set_name("Dummy");
    $game->set_author("Melissa");
    $game->set_number_players(2);
    $game->set_description("This is a description");
    $game->set_duration("20 min");
    $game->set_image("image.png");
    $game->set_punctuation(30);
    $game->set_user($user);
    $game->set_category($category);
    $gameDAO->insert_game($game);*/

    /**
     * test update_game method
     */
    /*echo "test update_game method<br>";
    $game = $gameDAO->get_game_by_name("Dummy")[0];
    $category= $categoryDAO->get_category_by_name("Abstracto");
    $user = $userDAO->get_user_by_name("user2")[0];
    $game->set_author("Melissa");
    $game->set_description("This is another description");
    $game->set_category($category);
    $game->set_user($user);
    $gameDAO->update_game($game);
    $game = $gameDAO->get_game_by_name("test")[0];
    echo 'First update' . ' ' . $game->get_author() . '<br>';
    echo 'First update' . ' ' . $game->get_description() . '<br>';
    echo 'First update' . ' ' . $game->get_category() . '<br>';*/

    /**
     * test delete_game method
     */
    $game = $gameDAO->get_game_by_name("Dummy")[0];
    $gameDAO->delete_game($game);
    $game = $gameDAO->get_game_by_name("Dummy");
    echo (!empty($game) ? 'existe' : 'no existe') . '<br>';

} finally {
    datasource::get_instance()->close_connection();
}
?>