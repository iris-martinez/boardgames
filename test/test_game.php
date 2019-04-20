<?php

require_once(__DIR__ . "/../dao/class-gameDAO.php");
require_once(__DIR__ . "/../model/class-game.php");

try {

    /**
     * test list_games method
     */
    $gameDAO = new GameDAO();
    $games = $gameDAO->list_games();
    foreach ($games as $game) {
        echo "Test listar juegos" . " " . $game->get_id() . '<br>';
        echo "Test listar juegos" . " " . $game->get_name() . '<br>';
        echo "Test listar juegos" . " " . $game->get_author() . '<br>';
        echo "Test listar juegos" . " " . $game->get_category() . '<br>';
    }

    /**
     * test get_category_by_id method
     */
    $game = $gameDAO->get_game_by_id(1);
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
     * test get_category_by_author method
     */
    $games = $gameDAO->get_game_by_author('Seiji Kanai');
    foreach ($games as $game) {
        echo (ISSET($game) ? 'existe' : 'no existe') . '<br>';
        echo $game->get_id() . '<br>';
        echo $game->get_name() . '<br>';
        echo $game->get_author() . '<br>';
        echo $game->get_category() . '<br>';
    }

} finally {
    datasource::get_instance()->close_connection();
}
?>