<?php

require_once(__DIR__ . "/../dao/class-userpunctuategameDao.php");
require_once(__DIR__ . "/../model/class-userpunctuategame.php");

try {

    /**
     * test list_comments method
     */

    $punctuationDAO = new punctuationsDAO();
    $punctuations = $punctuationDAO->list_punctuations();
    foreach ($punctuations as $punctuation) {
        echo "Test listar puntuaciones" . " " . $punctuation->get_punctuation() . '<br>';
    }
  

} finally {
    datasource::get_instance()->close_connection();
}
?>


