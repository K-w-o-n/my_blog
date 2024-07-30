<?php
session_start();
require('Database/MySQL.php');
require('Database/encap.php');

$id = $_GET['id'];
$stmt = $db->prepare("SELECT * FROM articles WHERE id=$id");
$stmt->execute();
$result = $stmt->fetchAll();


// for cmResult
$blogId = $_GET['id'];
$cmStmt = $db->prepare("SELECT * FROM comments WHERE article_id=$blogId");
$cmStmt->execute();
$cmResult = $cmStmt->fetchAll();


$auResult = [];

if ($cmResult) {
    foreach ($cmResult as $key => $value) {
        $authorId = $cmResult[$key]['author_id'];
        $stmtau = $db->prepare("SELECT * FROM users WHERE id=$authorId");
        $stmtau->execute();
        $auResult[] = $stmtau->fetchAll();
    }
}


if ($_POST) {
    if (empty($_POST['content'])) {
        $cmtError = '!** Comment cannot be null';
    } else {
        $content = $_POST['content'];
        $stmt = $db->prepare("INSERT INTO comments(content,author_id,article_id) VALUES (:content,:author_id,:article_id)");
        $stmt->execute(
            array(':content' => $content, ':author_id' => $_SESSION['userid'], ':article_id' => $blogId)
        );
        if ($result) {
            header('Location: blogdetail.php?id=' . $blogId);
        }
    }
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
        <section class="container py-5">
            <div class="container mt-5">
                <div class="col-12">
                    <div class="card p-3">

                        <div class="card-body">
                            <img class="img-fluid" src="admin/images/<?php echo $result[0]['photo']; ?>" alt="Card image cap">
                            <h4 class="mt-3"><?php echo encap($result[0]['title']); ?></h4>
                            <p class="card-text"><?php echo encap($result[0]['description']); ?></p>
                            <a href="index.php" class="btn btn-success">&laquo;</a>
                        </div>
                        <hr>
                        <div>
                            <h5 class="">Comments</h5>
                            <?php if ($cmResult) { ?>
                                <?php foreach ($cmResult as $key => $value) { ?>
                                    <div class="card-comment mb-3 bg-info px-3 py-2 rounded bg-light">

                                        <span><?= encap($auResult[$key][0]['name']) ?><span class="text-muted" style="float: right;"><?= $value['created_at'] ?><a href="cmdelete.php?id=<?php echo $value['id'] ?>" class="btn btn-close btn-sm ms-2"></a></span></span>
                                        <div class="font-weight-bold" style="font-size: small;"><?= encap($value['content']) ?></div>
                                    </div>
                                    <span style="color:red;"><?= $cmtError ?? ""; ?></span>
                            <?php }
                            }
                            ?>
                            <form action="" method="post" class="d-flex">
                                <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">

                                <input type="text" name="content" id="" class="form-control form-control-sm me-2" placeholder="comment">
                                <button class="btn btn-sm btn-primary">Comment</button>

                            </form>
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