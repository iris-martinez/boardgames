<?php
session_start();
if(!($_SESSION['id_user'])){
    header('location:login.php');
}