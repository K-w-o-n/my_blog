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

$stmt = $db->prepare("SELECT * FROM users ORDER BY id DESC");
$stmt->execute();
$rawResult = $stmt->fetchAll();

$total_pages = ceil(count($rawResult) / $numOfRecords);

$stmt = $db->prepare("SELECT * FROM users ORDER BY id DESC LIMIT $offset,$numOfRecords");
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
        <div class="row bg-primary p-3 text-white"><h4>Kwon blogs</h4></div>
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
                <div class="container-fluid">
                    <div class="d-flex justify-content-between bg-primary text-white p-2">
                        <div class="d-flex">
                            <h4 class="me-2">Users</h4>
                            <a href="users/user_add.php" type="button" class="btn bg-white">Create new user</a>
                        </div>
                        <div class="d-none d-lg-block">
                                <form class="form-inline my-lg-0 d-flex " action="">
                                    <input class="form-control mr-sm-2 me-2" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-outline-success bg-success text-white  my-sm-0" type="submit">Search</button>
                                </form>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered rounded-3 overflow-hidden">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Password</th>
                                <th scope="col">Role</th>
                                <th>Actions</th>
                               
                            </tr>
                        </thead>
                        <?php

                        if ($result) {
                            $i = 1;
                            foreach ($result as $value) { ?>

                                <tbody>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $value['name'] ?></td>
                                        <td><?php echo $value['email'] ?></td>
                                        <td>
                                            <?php echo $value['password'] ?>
                                        </td>
                                        <td><?php echo $value['role'] ?></td>
                                        <td>
                                            <div>
                                                <a href="users/users_edit.php?id=<?php echo $value['id'] ?>" class="btn btn-success" type='button'>Edit</a>
                                                <a href="users/users_delete.php?id=<?php echo $value['id'] ?>" class="btn btn-warning" type='button'>Delete</a>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                </tbody>

                        <?php

                                $i++;
                            }
                        }


                        ?>
                    </table>
                    <div class="d-flex align-items-center justify-content-center">
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
                </div>
                

            </main>
            
        </div>
    </div>

</body>

</html>