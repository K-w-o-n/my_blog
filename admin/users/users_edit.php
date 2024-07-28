<?php
session_start();
require('../../Database/MySQL.php');
require('../../Database/encap.php');

if (empty($_SESSION['userid']) && empty($_SESSION['login'])) {
    header('location: index.php');
}


if ($_POST) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    if (empty($_POST['role'])) {
        $role = 0;
    } else {
        $role = 1;
    }
  

    $stmt = $db->prepare("UPDATE users SET name='$name',email='$email',password='$password',role='$role' WHERE id=".$_GET['id']);
        $result = $stmt->execute();
        if ($result) {
            echo "<script>alert('Successfully Updated');window.location.href='../user_list.php';</script>";
        }
    
        
    
}



$id = $_GET['id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id=$id");
$stmt->execute();
$result = $stmt->fetch();
// echo $result['id']; exit();





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
                <div class="row p-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                        <form action='' method='post' >
                                <div>
                                    <h4>Create New User</h4>
                                </div>
                                <div class="form-group mb-2">
                                <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                                    <label>Name</label><p style="color:red"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                                    <input type="text" class="form-control" name='name' value="<?php echo encap($result['name']) ?>">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Email</label><p style="color:red"><?php echo empty($emailError) ? '' : '*'.$emailError; ?></p>
                                    <input type="email" class="form-control" name='email' value="<?php echo encap($result['email'] )?>">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Password</label><p style="color:red"><?php echo empty($passwordError) ? '' : '*'.$passwordError; ?></p>
                                    <input type="password" class="form-control" name='password' value="<?php echo encap($result['password']) ?>">
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