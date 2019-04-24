<?php

require_once ('../dao/class-categoryDAO.php');
require_once ('../model/class-category.php');

$category = new CategoryDAO();
$category->list_categories();
//var_dump($category); exit();