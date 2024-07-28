<?php
session_start();
require('Database/MySQL.php');
require('Database/encap.php');


if ($_POST['search']) {
    // echo $_POST['search']; exit();
    setcookie('search', $_POST['search'], time() + (86400 * 30), "/");
} else {
    if (empty($_GET['pageno'])) {
        unset($_COOKIE['search']);
        setcookie('search', null, -1, "/");
    }
}
if (!empty($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

$numOfrecs = 3;
$offset = ($pageno - 1) * $numOfrecs;

if (empty($_POST['search']) && empty($_COOKIE['search'])) {

    $stmt = $db->prepare("SELECT * FROM articles ORDER BY id DESC");
    $stmt->execute();
    $rawResult = $stmt->fetchAll();

    $total_pages = ceil(count($rawResult) / $numOfrecs);

    $stmt = $db->prepare("SELECT * FROM articles ORDER BY id DESC LIMIT $offset,$numOfrecs");
    $stmt->execute();
    $result = $stmt->fetchAll();
} else {
    if (!empty($_POST['search'])) {
        $searchKey = $_POST['search'];
    } else {
        $searchKey = $_COOKIE['search'];
    }
    $stmt = $db->prepare("SELECT * FROM articles WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
    $stmt->execute();
    $rawResult = $stmt->fetchAll();

    $total_pages = ceil(count($rawResult) / $numOfrecs);

    $stmt = $db->prepare("SELECT * FROM articles WHERE title LIKE '%$searchKey%'ORDER BY id DESC LIMIT $offset,$numOfrecs");
    $stmt->execute();
    $result = $stmt->fetchAll();
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>

    <title>Blog</title>

</head>

<body>
    <div class="wrap">
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg  shadow-sm fixed-top bg-light py-3">
            <div class="container">
                <div>
                    <a class="navbar-brand text-success h-3" href="index.php">Blog</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="d-none d-lg-block">
                    <form class="form-inline my-lg-0 d-flex" action="index.php" method="post">
                    <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                        <input class="form-control mr-sm-2 me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                        <button class="btn btn-outline-secondary  my-sm-0" type="submit">Search</button>
                    </form>
                </div>
                <div>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">About</a>
                            </li>
                            <li class="nav-item me-3">
                                <a class="nav-link" href="#">Blog</a>
                            </li>

                            <a class=" btn btn-primary" href="logout.php">Logout</a>

                        </ul>

                    </div>
                </div>
            </div>
        </nav>
        <!-- navbar end -->

        <main class="py-5 app mt-5">
            <div class="container text-center mt-5">
                <figure class="text-center ">
                    <blockquote class="blockquote">
                        <h3 class="display-1 text-white">Welcome To My Blog</h3>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        <p class="h4 text-warning">About<cite title="Source Title"> Software engineering</cite></p>
                    </figcaption>
                </figure>
            </div>
        </main>

        <section class="container py-5">
            <h4 class="text-black-50 text-center mt-5">Blogs</h4>
            <hr class="mb-5" style="width:40%;text-align:center;margin:auto;">
            <div class="row g-5 mb-3">
                <?php if ($result) {
                    $i = 1;
                    foreach ($result as $value) { ?>
                        <div class="col">
                            <div class="card mb-3 shadow-lg" style="width: 22rem;">
                                <a href="blogdetail.php?id=<?= $value['id'] ?>"><img class="card-img-top" src="admin/images/<?= $value['photo'] ?>" alt="Card image cap" height="200px"></a>
                                <div class="card-body">
                                    <h4 class="card-title"><?= encap(substr($value['title'], 0, 20) )?></h4>
                                    <span class="card-subtitle text-muted"><?= $value['created_at'] ?></span>
                                    <p class="card-text"><?= encap(substr($value['description'], 0, 20)) ?></p>
                                </div>
                            </div>
                        </div>
                <?php }
                    $i++;
                } ?>
            </div>
            <div class="d-flex justify-content-center mb-3">
                <ul class="pagination" style="margin: 0 auto;" !important>
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if ($pageno <= 1) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="<?php if ($pageno <= 1) {
                                                        echo '#';
                                                    } else {
                                                        echo "?pageno=" . ($pageno - 1);
                                                    } ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if ($pageno >= $total_pages) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="<?php if ($pageno >= $total_pages) {
                                                        echo '#';
                                                    } else {
                                                        echo "?pageno=" . ($pageno + 1);
                                                    } ?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                </ul>
            </div>
        </section>
        <footer class="foot">
            <div class="py-5 text-center text-light" style="background-color: #372e5e;">
                <p class="fs-4">Copyright &copy; all right reserved by Kwon 2024</p>
            </div>
        </footer>
    </div>
</body>

</html>