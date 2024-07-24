<?php
session_start();
require('Database/MySQL.php');

if (!empty($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

$numOfrecs = 4;
$offset = ($pageno - 1) * $numOfrecs;

$stmt = $db->prepare("SELECT * FROM articles ORDER BY id DESC");
$stmt->execute();
$rawResult = $stmt->fetchAll();

$total_pages = ceil(count($rawResult) / $numOfrecs);

$stmt = $db->prepare("SELECT * FROM articles ORDER BY id DESC LIMIT $offset,$numOfrecs");
$stmt->execute();
$result = $stmt->fetchAll();

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
    <div>
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg  shadow-sm fixed-top bg-light">
            <div class="container">
                <div>
                    <a class="navbar-brand text-success h-3" href="index.php">Blog</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
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
                            <li class="nav-item">
                                <a class="nav-link" href="#">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">More info</a>
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
                    <h1 class="display-1 text-white">Welcome To My Blog</h1>
                </blockquote>
                <figcaption class="blockquote-footer">
                    <p class="h4 text-warning">About<cite title="Source Title"> Software engineering</cite></p>
                </figcaption>
                </figure>
            </div>
        </main>

        <section class="container py-5">
            <div class="row g-5">
                <?php if ($result) {
                    $i = 1;
                    foreach ($result as $value) {
                ?>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="col-md-4 mb-3">
                                <div class="card" style="width: 18rem;">
                                    <a href="blogdetail.php?id=<?php echo $value['id']; ?>"><img class="card-img-top" src="admin/images/<?php echo $value['photo']; ?>" alt="Card image cap" height='300px' width='300px'></a>
                                    <div class="card-body">
                                        <h4><?php echo $value['title'] ?></h4>
                                        <p class="card-text"><?php echo substr($value['description'], 0, 10); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                        $i++;
                    }
                } ?>
            </div>
            <ul class="pagination" style="margin: 0 auto;" !important>
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
        </section>
        <footer>
            <div class="py-5 text-center text-light" style="background-color: #372e5e;">
                <p class="fs-4">Copyright &copy; all right reserved by Kwon 2024</p>
            </div>
        </footer>
    </div>
</body>

</html>