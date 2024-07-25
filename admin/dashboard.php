<?php
session_start();
require('../Database/MySQL.php');

if (empty($_SESSION['userid']) && empty($_SESSION['login'])) {
    header('location: index.php');
}

if ($_SESSION['role'] != 1) {
    header("Location: login.php");
}



if (!empty($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

$numOfRecords = 6;
$offset = ($pageno - 1) * $numOfRecords;

$stmt = $db->prepare("SELECT * FROM articles ORDER BY id DESC");
$stmt->execute();
$rawResult = $stmt->fetchAll();

$total_pages = ceil(count($rawResult) / $numOfRecords);

$stmt = $db->prepare("SELECT * FROM articles ORDER BY id DESC LIMIT $offset,$numOfRecords");
$stmt->execute();
$result = $stmt->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/bootstrap.bundle.min.js" defer></script>

    <title>Blog</title>

</head>

<body>
    <div class="container-fluid p-5">
        <div class="row bg-primary p-3 text-white">
            <h4>Kwon blogs</h4>
        </div>
        <div class="row gap-0 ">
            <nav class="col-2 bg-light pe-3" style="background: #0083aa;padding:0px;">
                <div class="list-group rounded-0 text-center text-lg-start">
                    <a href="dashboard.php" class="list-group-item">
                        <span>Dashboard</span>
                    </a>
                    <a href="user_list.php" class="list-group-item">
                        <span>Users</span>
                    </a>
                    <a href="index.php" class="list-group-item">
                        <span>Blogs</span>
                    </a>
                </div>
            </nav>
            <main class="col-10 bg-light p-3">
                <div class="container-fluid" style="height: 600px;">
                    <div class="d-flex justify-content-between bg-primary text-white p-2">
                        <div class="d-flex">
                            <h4 class="me-2">Blogs</h4>
                            <a href="add.php" type="button" class="btn bg-white">Create new Blog</a>
                        </div>
                        <div class="d-none d-lg-block">
                            <form class="form-inline my-lg-0 d-flex " action="">
                                <input class="form-control mr-sm-2 me-2" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success bg-success text-white  my-sm-0" type="submit">Search</button>
                            </form>
                        </div>
                    </div>

                    <div class="row flex-column flex-lg-row p-3">
                        <div class="col text-center">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h3 class="card-title h2">8,210</h3>
                                    <span class="text-success">
                                       
                                        Users
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col text-center">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h3 class="card-title h2">8,210</h3>
                                    <span class="text-success">
                                       
                                        Blogs
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col text-center">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h3 class="card-title h2">8,210</h3>
                                    <span class="text-success">
                                       
                                        Courses
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        </div>

        </main>
    </div>
    </div>

</body>

</html>