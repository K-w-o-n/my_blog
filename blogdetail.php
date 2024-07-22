<?php
session_start();
require('Database/MySQL.php');


$stmt = $db->prepare("SELECT * FROM articles WHERE id=" . $_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>

    <title>Blog</title>

</head>

<body>
    <div class="container mt-5">
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg  shadow-sm">
            <div class="container">
                <div>
                    <a class="navbar-brand text-success h-3" href="#">Blog</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Articles</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- navbar end -->
        <div class="container mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><?php echo $result[0]['title'] ?></h4>
                    </div>
                    <div class="card-body">
                        <img class="img-fluid" src="admin/images/<?php echo $result[0]['photo']; ?>" alt="Card image cap">
                        <p class="card-text"><?php echo $result[0]['description']; ?></p>
                        <a href="index.php" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <div class="row mt-5 w-100 p-3" id='footer'>
            <div class="col-12 text-center">
                <h5>Copyright &copy; all right reserved by Kwon 2024</h5>
            </div>
        </div>
</body>

</html>