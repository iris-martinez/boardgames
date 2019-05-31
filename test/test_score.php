<?php

require_once(__DIR__ . "/../dao/class-userpunctuategameDao.php");
require_once(__DIR__ . "/../model/class-userpunctuategame.php");

try {

    /**
     * test list_punctuations method
     */

    $punctuationDAO = new punctuationDAO();
    $punctuations = $punctuationDAO->list_punctuations();
    foreach ($punctuations as $punctuation) {
        echo "Test listar puntuaciones" . " " . $punctuation->get_punctuation() . '<br>';
    }
  
    /**
     * test insert_punctuation method
     */

    /*  echo "---------------------------<br>";
    echo "test insert_punctuation method<br>";
    $punctuation = new punctuations();
    $punctuation->set_user_id(3);
    $punctuation->set_game_id(2);
    $punctuation->set_punctuation(5);
    $punctuation->set_date("2019-05-19");
    $punctuation->set_user_level_id(2);
    $punctuationDAO->insert_punctuations($punctuation); */

    /**
     * test update_punctuation method
     */
    echo "---------------------------<br>";
    echo "test update_punctuation method<br>";
    $punctuation = $punctuationDAO->get_punctuation_by_id(2);
    $punctuation->set_punctuation(4);
    $punctuationDAO->update_punctuation($punctuation);
    $punctuation = $punctuationDAO->get_punctuation_by_id(2);
    echo 'First update' . ' ' . $punctuation->get_punctuation() . '<br>';

    /**
     * test delete_punctuation method
     */
    echo "---------------------------<br>";
    echo "test delete_punctuation method<br>";
    $punctuation = $punctuationDAO->get_punctuation_by_id(5);
    $punctuationDAO->delete_punctuation($punctuation);
    $punctuation = $punctuationDAO->get_punctuation_by_id(5);
    echo (!empty($punctuation) ? 'existe' : 'no existe') . '<br>';

} finally {
    datasource::get_instance()->close_connection();
}
?>


