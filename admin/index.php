<?php
session_start();
require('../Database/MySQL.php');

if (empty($_SESSION['userid']) && empty($_SESSION['login'])) {
    header('location: index.php');
}

if ($_SESSION['role'] != 1) {
    header("Location: login.php");
}


$stmt = $db->prepare("SELECT * FROM articles ORDER BY id DESC");

$stmt->execute();

$result = $stmt->fetchAll();


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
    <div class="container-fluid">
        <div class="row gap-0 ">
            <nav class="col-2 py-5" style="background: #0083aa;">
                <div class="list-group text-center">
                    <span class="list-group-item disabled">
                        <h4>Dashboard</h4>
                    </span>
                    <a href="index.php" class="list-group-item">
                        <span>Blogs</span>
                    </a>
                    <a href="#" class="list-group-item">
                        <span>Users</span>
                    </a>
                </div>
            </nav>
            <main class="col-10 bg-light py-5">
                <div class="container py-3">
                    <div class="row flex-col flex-lg-row">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h3 class="card-title h2">Users</h3>
                                    <span class="text-success">
                                        100+
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                        <div class="card mb-3 bg-success">
                                <div class="card-body text-center">
                                    <h3 class="card-title h2">Blogs</h3>
                                    <span class="text-white">
                                        100+
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                        <div class="card mb-3 bg-warning">
                                <div class="card-body text-center">
                                    <h3 class="card-title h2">Courses</h3>
                                    <span class="text-white">
                                        100+
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                </div>
                <div class="container-fluid py-5">
                    <div class="d-flex justify-content-between mb-3">
                    <h3>Blogs</h3>
                    <a href="add.php" type="button" class="btn btn-primary">Create new Blog</a>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Photo</th>
                                <th>Actions</th>
                                <th scope="col">Created_at</th>
                            </tr>
                        </thead>
                        <?php

                        if ($result) {
                            $i = 1;
                            foreach ($result as $value) { ?>

                                <tbody>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $value['title'] ?></td>
                                        <td><?php echo substr($value['description'], 0, 10) ?></td>
                                        <td>
                                            <img class="img-fluid pad" src="images/<?php echo $value['photo'] ?>" style="height: 150px !important;">
                                        </td>
                                        <td>
                                            <div>
                                                <a href="edit.php?id=<?php echo $value['id'] ?>" class="btn btn-success" type='button'>Edit</a>
                                                <a href="delete.php?id=<?php echo $value['id'] ?>" class="btn btn-warning" type='button'>Delete</a>
                                            </div>
                                        </td>
                                        <td><?php echo $value['created_at'] ?></td>
                                    </tr>
                                </tbody>

                        <?php

                                $i++;
                            }
                        }


                        ?>
                    </table>
                    <nav aria-label="Page navigation example" style="float:right">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                            <li class="page-item <?php if ($pageno <= 1) {
                                                        echo 'didabled';
                                                    } ?>">
                                <a class="page-link" href="<?php if ($pageno <= 1) {
                                                                echo '#';
                                                            } else {
                                                                echo "?pageno" . ($pageno - 1);
                                                            } ?>">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                            <li class="page-item <?php if ($pageno >= 1) {
                                                        echo 'didabled';
                                                    } ?>">
                                <a class="page-link" href="<?php if ($pageno >= $total_pages) {
                                                                echo '#';
                                                            } else {
                                                                echo "?pageno=" . ($pageno + 1);
                                                            } ?>">Next</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                        </ul>
                    </nav>
                </div>
                

            </main>
            
        </div>
    </div>

</body>

</html>