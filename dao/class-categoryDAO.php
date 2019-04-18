<?php

require_once(__DIR__."/../model/class-category.php");

class CategoryDAO
{

    private $datasource;
    private $categoryDAO;

    public function __construct(){
        $this->datasource = new DataSource();
        $this->categoryDAO = new categoryDAO();
    }

    public function get_category_by_id($id) {

    }
    public function get_category_by_name($name) {

    }
    public function insert_category($name) {

    }
}