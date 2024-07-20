<?php
session_start();
require('../Database/MySQL.php');

if(empty($_SESSION['userid']) && empty($_SESSION['login'])) {
    header('location: index.php');
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
    <div class="container-fluid">
        <div class="row gap-0">
            <nav class="col-2 bg-light pe-3">
                <h1 class='h4 text-center text- py-3'>Admin</h1>
                <div class="list-group text-center">
                    <span class="list-group-item disabled">
                        <small>USER MANAGEMENT</small>
                    </span>
                    <a href="add.php" class="list-group-item">
                        <span>Add user</span>
                    </a>
                    <a href="#" class="list-group-item">
                        <span>Add post</span>
                    </a>
                </div>
            </nav>
            <main class="col-10 bg-light"style="padding:0px">
           
        
        
                <div class="container-fluid mt-3 p-4">

                <div class="card">
                            <div class="card-header">
                                Blog listings
                            </div>
                            <div class="card-body">
                            <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">id</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>1</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>2024/7/21</td>
                            </tr>
                            <tr>
                            <td>1</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>2024/7/21</td>
                            </tr>
                            <tr>
                            <td>1</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>2024/7/21</td>
                            </tr>
                            
                        
                        </tbody>
                        <div>hello table footer</div>
                        </table>

                            </div>
                </div>              
                </div>
                        
        </main>
        </div>
    </div>
    
</body>
</html>