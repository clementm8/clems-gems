<?php
require_once "/home/comotosho1/data/connect.php";
$connection = db_connect();

require_once "../private/prepared.php";

if(!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id' < 0]){
    header('Location:' . $_SERVER['HTTP_REFERER']);
}

delete_item($_GET['id']);

header('Location: delete.php');
?>