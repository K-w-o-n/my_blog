<?php 

session_start();
require('../../Database/MySQL.php');

$id = $_GET['id'];

$stmt = $db->prepare("DELETE FROM users WHERE id=$id");
$stmt->execute();

header("location: ../user_list.php");