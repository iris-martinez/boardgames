<?php

require_once(__DIR__ . "/../dao/class-datasource.php");
require_once(__DIR__ . "/../dao/class-gameDAO.php");
require_once(__DIR__ . "/../model/class-game.php");
   
    $game = new game();
    $gameDAO = new gameDAO();

    $games = $gameDAO->list_games();
    
    function compare($a, $b)
    {
        if ($a->get_punctuation() ==  $b->get_punctuation()) {
            return 0 ;
        }
        return ($a->get_punctuation() > $b->get_punctuation()) ? -1 : 1;
    }
    
    usort($games, 'compare');

    var_dump($games);

    foreach ($games as $game) {
        echo $game->get_name();
        echo $game->get_punctuation();
    }
    





?>