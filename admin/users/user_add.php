<?php

session_start();

require('../../Database/MySQL.php');

if (empty($_SESSION['userid']) && empty($_SESSION['login'])) {

    header("Location: ../login.php");
}

if ($_SESSION['role'] != 1) {
    header('Location: ../login.php');
}



if ($_POST) {

    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password']) < 4) {

        if (empty($_POST['name'])) {
            $nameError = 'Name cannot be null';
        }
        if ( empty($_POST['email'])) {
            $emailError = 'Email cannot be null';
        }
        if (empty($_POST['password']) ) {
            $passwordError = 'Password cannot be null';
        }
        if (strlen($_POST['password']) < 4) {
            $passwordError = 'Password should be 4 characters at least';
        }
    } else {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if (empty($_POST['role'])) {
            $role = 0;
        } else {
            $role = 1;
        }

        $stmt = $db->prepare("SELECT * FROM users WHERE email=:email");

        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user) {

            echo "<script>alert('Email duplicated')</script>";
        }else {

            $stmt = $db->prepare("INSERT INTO users(name,email,password,role) VALUES (:name,:email,:password,:role)");
            $result = $stmt->execute(
                array(':name'=>$name,':email'=>$email,':password'=>$password,':role'=>$role)
            );
            if ($result) {
              echo "<script>alert('Successfully added');window.location.href='../user_list.php';</script>";
            }
        }
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="../../js/bootstrap.bundle.min.js" defer></script>

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
                    <a href="../dashboard.php" class="list-group-item">
                        <span>Dashboard</span>
                    </a>
                    <a href="../user_list.php" class="list-group-item">
                        <span>Users</span>
                    </a>
                    <a href="../index.php" class="list-group-item">
                        <span>Blogs</span>
                    </a>
                </div>
            </nav>
            <main class="col-10 bg-light p-3">
                <div class="row p-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action='user_add.php' method='post' >
                                <div>
                                    <h4>Create New User</h4>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Name</label><p style="color:red"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                                    <input type="text" class="form-control" name='name'>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Email</label><p style="color:red"><?php echo empty($emailError) ? '' : '*'.$emailError; ?></p>
                                    <input type="email" class="form-control" name='email'>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Password</label><p style="color:red"><?php echo empty($passwordError) ? '' : '*'.$passwordError; ?></p>
                                    <input type="password" class="form-control" name='password'>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="role" value="1">
                                    <label class="form-check-label">Admin</label>
                                </div><br>

                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="../user_list.php" type='button' class='btn btn-default'>Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>

</body>

</html>