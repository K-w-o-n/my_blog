<?php

session_start();
include('../vendor/autoload.php');

use Database\MySQL;
use Database\FunctionsGroup;
use Routes\HTTP;

$data = [
    $title = $_POST['title'] ?? "Unknown",
    $email = $_POST['description'] ?? "Unknown",
    $password = $_POST['photo'] ?? "Unknown",
   
];


$table = new FunctionsGroup(new MySQL);

if($table) {
    $table->insert($data);
    echo "<script>alert('Incorrect Credentials')</script>";
    HTTP::redirect('/index.php');
}
