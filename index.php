<?php
session_start();
require('Database/MySQL.php');

if (!empty($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
  }else{
    $pageno = 1;
  }

  $numOfrecs = 3;
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
   
    <div class="container">
        <img src="images/login2.jpg" alt="" class='img-fluid'>
        <h1 class='banner-caption text-center p-5'>Welcome To My Blog</h1>
        
    </div>

        <div class="container mt-5">
            
        <div class="row">
            
    <?php if($result) {
        $i = 1;
        foreach($result as $value) {
    ?>
            <div class="col-md-4 mb-3">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="admin/images/<?php  echo $value['photo']; ?>" alt="Card image cap" height='300px' width='300px'>
                    <div class="card-body">
                        <h4><?php echo $value['title']?></h4>
                        <p class="card-text"><?php echo substr($value['description'],0,10);?></p>
                    </div>
                </div>
            </div>
            
    <?php
    $i++;
        }
    }?>

        </div>
        
            
    </div>

    <ul class="pagination" style="margin: 0 auto;"!important>
                                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                                    <li class="page-item <?php if($pageno <= 1) { echo 'didabled';} ?>">
                                        <a class="page-link" href="<?php if($pageno <= 1) {echo '#';} else { echo "?pageno".($pageno - 1);} ?>">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                                    <li class="page-item <?php if($pageno >= 1) { echo 'didabled';} ?>">
                                        <a class="page-link" href="<?php if($pageno >= $total_pages) { echo '#';} else { echo "?pageno=".($pageno+1);}?>">Next</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                                </ul>

    
    <!-- footer -->
    <div class="row mt-5 w-100 p-3" id='footer'>
        <div class="col-12 text-center"><h5>Copyright &copy; all right reserved by Kwon 2024</h5></div>
     </div>
</body>
</html>