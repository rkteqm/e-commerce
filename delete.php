<?php
require_once "navbar.php";
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Online Shopping</title>
    <style>
        .center {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: lightcyan;
            margin: 20px;
            padding: 20px;
            border-radius: 30px;
        }

        .center img {
            border-radius: 30px;
            margin: 10px;
        }

        .center p {
            color: red;
        }
    </style>
</head>

<body>

    <!---------------------------------------- php ----------------------------------------- -->
    <?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'ecom';

    // session_start();
    if (isset($_SESSION['id'])) {
        $id = $_GET['var'];

        $conn = mysqli_connect($servername, $username, $password, $database);
        $sql = " SELECT * FROM item WHERE `id` = $id ";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                $id = $row['id'];
                $userid = $row['user_id'];
                $category = $row['category'];
                $title = $row['title'];
                $price = $row['price'];
                $image = $row['image'];
                $created_at = $row['created_at'];
                if ($userid != $_SESSION['id']) {
                    die("You have no access!...");
                }

                echo "
          <form action='editblog2.php'>
          <div class='col-md-5'>
          <div class='center'>
          <img src='../uploads/$image' alt=''>
          <p>Rs.$price</p>
          <h3>$title</h3>
          <a href='confirmdelete.php?var=$id'>Confirm Delete</a>
          </div>
          </div>
          </form>";
            }
        }
    } else {
        header('location: home.php');
    }
    ?>

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