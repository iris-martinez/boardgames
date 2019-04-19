<?php

require_once(__DIR__."/../model/class-category.php");
require_once(__DIR__."/../dao/class-datasource.php");

class CategoryDAO
{

    private $datasource;

    public function __construct(){
        $this->datasource = new datasource();
    }

    public function get_category_by_id($id) {

    }
    public function get_category_by_name($name) {

    }
    public function insert_category($name) {

    }
}