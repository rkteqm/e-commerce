<?php
require_once "navbar.php";
?>
  <?php


$servername = "localhost";
$username = "root";
$password = "";
$database = "ecom";

$email = $pass = "";
$emailErr = $passErr = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
  }

  if (empty($_POST["pass"])) {
    $passErr = "Password is required";
  } else {
    $pass = test_input($_POST["pass"]);
  }

  if (empty($emailErr) && empty($passErr)) {
    // create a connection 
    $conn = mysqli_connect($servername, $username, $password, $database);
    $sql = " SELECT * FROM `user` WHERE `username` = '$email' AND `password` = '$pass' ";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);


    // Check for login successfully!
    if ($num == 1) {
      $row = mysqli_fetch_array($result);
      if ($row['usertype'] === "user") {
        // session_start();
        $_SESSION['id'] = $row[0];
        header("location: user.php");
      } elseif ($row['usertype'] === "admin") {
        // session_start();
        $_SESSION['id'] = $row[0];
        header("location: admin.php");
      } else {
        echo mysqli_error($conn);
      }
    } else {
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
<strong>Success!</strong> Please enter correct details for login...
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }
}

// Function for Validate variables 
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
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

  <title>Online Shopping</title>
  <style>
    .error {
      color: red;
    }
  </style>
</head>

<body>

  <div class="container mt-5">
    <h1>Please Login Here</h1>
    <hr><br>
    <form class="row g-3" method="post">
      <div class="col-md-6">
        <label for="email" class="form-label">E-Mail</label>
        <span class="error">*<?php echo $emailErr; ?></span>
        <input type="text" class="form-control" id="email" name="email">
      </div>
      <div class="col-md-6">
        <label for="password" class="form-label">Password</label>
        <span class="error">*<?php echo $passErr; ?></span>
        <input type="password" class="form-control" id="password" name="pass">
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">Sign in</button>
      </div>
    </form>
  </div>

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