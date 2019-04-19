<?php

require_once(__DIR__ . "/../dao/class-categoryDAO.php");
require_once(__DIR__ . "/../model/class-category.php");

/**
 * test list_categories method
 */

$categoryDAO = new CategoryDAO();
$categories = $categoryDAO->list_categories();
foreach ($categories as $category) {
    echo "Test listar categorías" . " " . $category->get_name() . '<br>';
}

/**
 * test get_category_by_name method
 */
$category = $categoryDAO->get_category_by_name("Party game");
echo (ISSET($category) ? 'existe' : 'no existe') . '<br>';
echo $category->get_name() . '<br>';

/**
 * test update_category method
 */
$category = $categoryDAO->get_category_by_name("Abstracto");
$category->set_name("Abstracto2");
$categoryDAO->update_category($category);
$category = $categoryDAO->get_category_by_name("Abstracto2");
echo 'First update' . ' ' . $category->get_id() . '<br>';
echo 'First update' . ' ' . $category->get_name() . '<br>';
$category->set_name("Abstracto");
$categoryDAO->update_category($category);
echo 'Second update' . ' ' . $category->get_id() . '<br>';
echo 'Second update' . ' ' . $category->get_name() . '<br>';

/**
 * test insert_category method
 */
$category->set_name("Dummy");
$categoryDAO->insert_category($category);
$category = $categoryDAO->get_category_by_name("Dummy");
echo 'First insert' . ' ' . $category->get_id() . '<br>';
echo 'First insert' . ' ' . $category->get_name() . '<br>';


/**
 * test delete_category method
 */
$category = new category();
$category->set_name("Dummy2");
$categoryDAO->insert_category($category);
$category = $categoryDAO->get_category_by_name("Dummy2");
echo 'First insert' . ' ' . $category->get_id() . '<br>';
echo 'First insert' . ' ' . $category->get_name() . '<br>';
echo (ISSET($category) ? 'existe' : 'no existe') . '<br>';
echo $category->get_name() . '<br>';
$categoryDAO->delete_category($category);
$category = $categoryDAO->get_category_by_name("Dummy2");
echo (ISSET($category) ? 'existe' : 'no existe') . '<br>';


?>

