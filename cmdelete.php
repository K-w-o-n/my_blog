<?php

session_start();
require('Database/MySQL.php');
require('Database/encap.php');


$id = $_GET['id'];
$stmt = $db->prepare("DELETE FROM comments WHERE id=$id");
$stmt->execute();

header("location: blogdetail.php");