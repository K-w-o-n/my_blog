<?php
session_start();
require('Database/MySQL.php');

if ($_POST) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->execute([
        ':email' => $email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['userid'] = $user['id'];
            $SESSION['name'] = $user['name'];
            $SESSION['login'] = time();
            $_SESSION['role'] = 0;

            header("location: index.php");
        }
    }

    echo "<script>alert('Incorrect credentials')</script>";
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
        <nav class="navbar navbar-expand-lg  shadow-sm fixed-top bg-light">
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
                                <a class="nav-link" href="logout.php">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">More info</a>
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
        <div class="container py-5 mt-5">
            <div class="row py-3">
                <!-- left login -->
                <div class="col-md-6 col-12">
                    <div class='rounded'>
                        <img src="images/login.jpg" alt="" height='600px' width='600px' class='img-fluid'>
                    </div>
                </div>
                <!-- right login -->
                <div class="col-12 col-md-6 p-5 shadow-lg rounded">
                    <h3 class='text-center mt-3 text-dark mb-5'>Welcome</h3>
                    <form action="login.php" method='post'>
                        <div class='mb-3'>
                            <label for="">Email</label>
                            <input type="text" name="email" class='form-control'>
                        </div>
                        <div class='mb-3'>
                            <label for="">Password</label>
                            <input type="password" name="password" class='form-control'>
                        </div>
                        <button class='btn btn-primary w-100 fs'>Log in</button>
                    </form>
                    <p class='text-center text-muted mt-3'>If u don't have account register <a href="register.php">here!</a></p>
                </div>
            </div>
        </div>

        <footer class="foot">
            <div class="py-5 text-center text-light" style="background-color: #372e5e;">
                <p class="fs-4">Copyright &copy; all right reserved by Kwon 2024</p>
            </div>
        </footer>
    </div>
</body>

</html>