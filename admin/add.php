<?php
session_start();
require('../Database/MySQL.php');

if(empty($_SESSION['userid']) && empty($_SESSION['login'])) {
    header('location: index.php');
}


if($_POST) {
    
    // $file = 'images/'.($_FILES['image']['name']);
    $file = 'images/'.($_FILES['image']['name']);

    $imgType = pathinfo($file,PATHINFO_EXTENSION);
    
    if($imgType != 'png' && $imgType != 'jpg' && $imgType != 'jpeg' ) {

        echo "<script>alert('Image must be jpeg or png or jpg')</script>";
    } else {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],$file);

        $stmt = $db->prepare("INSERT INTO articles(title, description, photo) VALUES(:title, :description, :photo)");
        $result = $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':photo' => $image,
            
        ]);

        if($result) {
            
            echo "<script>alert('Successfully added');window.location.href='index.php'</script>";
        }

    }
}

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
                <div class="row p-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action='add.php' method='post' enctype='multipart/form-data'>
                                <div><h4>Create New Blog</h4></div>
                                <div class="form-group mb-3">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name='title'>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Description</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='description'></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Image</label><br>
                                    <input type="file" class="form-control-file" name='image'>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="index.php" type='button' class='btn btn-default'>Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>

</body>

</html>