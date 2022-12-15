<?php

session_start();
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'ecom';

$count = 0;
if (isset($_SESSION['id'])) {
  $userid = $_SESSION['id'];
  $conn = mysqli_connect($servername, $username, $password, $database);
  $sql = " SELECT*FROM `cart` WHERE `user_id` = '$userid' ";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  $count = $num;
} else {
  if (isset($_SESSION['cart'])) {
    $count = count($_SESSION['cart']);
  }
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">E-COM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <?php
                    if (isset($_SESSION['id'])) {
                    ?>

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="update.php">Update Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="logout.php">Logout</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="user.php">User Interface</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="addnewitem.php">Add New Item</a>
                        </li>

                    <?php
                    } else {
                    ?>

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="signin.php">Signin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="signup.php">Signup</a>
                        </li>

                    <?php
                    }
                    ?>
                    <li class="nav-item dropdown count">
                        <a class="nav-link active btn btn-outline-success" aria-current="page" href="cart.php">My Cart (<span id="getcount" value="getcount"><?php echo $count;?></span>) </a>
                        <ul class="dropdown-menu dropdown-content" id="getminicart" aria-labelledby="navbarDropdown">
                            <?php
                            if (isset($_SESSION['id'])) {
                                $userid = $_SESSION['id'];
                                $conn = mysqli_connect($servername, $username, $password, $database);
                                $sql = " SELECT*FROM `cart` WHERE `user_id` = '$userid' ";
                                $result = mysqli_query($conn, $sql);
                                $num = mysqli_num_rows($result);
                                $sr = 0;
                                if ($num > 0) {

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $title = $row['title'];
                                        $quantity = $row['quantity'];
                                        echo "<li><a class='dropdown-item' href=''>$title :    $quantity</a></li>";
                                    }
                                }
                            } else {
                                if (isset($_SESSION['cart'])) {
                                    foreach ($_SESSION['cart'] as $key => $value) {
                                        echo "<li><a class='dropdown-item' href=''>$value[title] :    $value[quantity]</a></li>";
                                    }
                                }
                            }
                            ?>

                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  -->
</body>

</html>