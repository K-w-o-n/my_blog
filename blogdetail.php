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
    <link rel="stylesheet" href="style.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>

    <title>Blog</title>

</head>

<body>
    <div class="wrap">
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

                            <a class=" btn btn-primary" href="#">Logout</a>

                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- navbar end -->
        <section class="container py-5">
            <div class="container mt-5">
                <div class="col-12">
                    <div class="card p-3">
                        
                        <div class="card-body">
                            <img class="img-fluid" src="admin/images/<?php echo $result[0]['photo']; ?>" alt="Card image cap">
                            <h4 class="mt-3"><?php echo $result[0]['title']; ?></h4>
                            <p class="card-text"><?php echo $result[0]['description']; ?></p>
                            <a href="index.php" class="btn btn-primary">Back</a>
                        </div>
                    </div>
                </div>
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