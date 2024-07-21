<?php
session_start();
require('../Database/MySQL.php');

if(empty($_SESSION['userid']) && empty($_SESSION['login'])) {
    header('location: index.php');
}


if($_POST) {

    $id = $_POST['id'];
    echo $id;exit();
    $title = $_POST['title'];
    $content = $_POST['content'];
   

    if ($_FILES['image']['name'] != null) {
      $file = 'images/'.($_FILES['image']['name']);
      $imageType = pathinfo($file,PATHINFO_EXTENSION);

      if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
        echo "<script>alert('Image must be png,jpg,jpeg')</script>";
      }else{
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],$file);

        $stmt = $pdo->prepare("UPDATE articles SET title='$title',description='$description',image='$image'");
        $result = $stmt->execute();
        if ($result) {
          echo "<script>alert('Successfully Updated');window.location.href='index.php';</script>";
        }
      }
    }else{
      $stmt = $pdo->prepare("UPDATE articles SET title='$title',description='$description' WHERE id='$id'");
      $result = $stmt->execute();
      if ($result) {
        echo "<script>alert('Successfully Updated');window.location.href='index.php';</script>";
      }
    }
  }
        


$id = $_GET['id'];
$stmt = $db->prepare("SELECT * FROM articles WHERE id=$id");
$stmt->execute();
$result = $stmt->fetch();
// echo $result['id']; exit();
        




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
        <div class="row gap-0">
            <nav class="col-2 bg-light pe-3">
                <h1 class='h4 text-center text- py-3'>Admin</h1>
                <div class="list-group text-center">
                    <span class="list-group-item disabled">
                        <small>USER MANAGEMENT</small>
                    </span>
                    <a href="add.php" class="list-group-item">
                        <span>Add Post</span>
                    </a>
                    <a href="#" class="list-group-item">
                        <span>Add User</span>
                    </a>
                </div>
            </nav>
            <main class="col-10 bg-secondary"style="padding:0px">
                    <div class="container-fluid mt-3 p-4">

                        <div class="card">
                            <div class="card-header">
                                New Blog
                            </div>
                            <div class="card-body">
                            <form action='add.php' method='post' enctype='multipart/form-data'>
                                <input type="hidden" name="id" value="<?php echo $result[0]['id']?>">
                                <div class="form-group mb-3">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name='title' value="<?php echo $result['title']?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Description</label>
                                    <textarea class="form-control"name='description'>
                                        <?php echo $result['title']?>
                                    </textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Image</label><br>
                                    <img class="img-fluid pad" src="images/<?php echo $result['photo']?>" style="height: 150px !important;"><br><br>
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