<?php 

session_start();
require('../Database/MySQL.php');

$id = $_GET['id'];

$stmt = $db->prepare("DELETE FROM articles WHERE id=$id");
$stmt->execute();

header("location: index.php");

