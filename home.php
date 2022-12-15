<?php

require_once "navbar.php";

// session_start();
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'ecom';

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
  <script>
    $(document).ready(function() {
      $('form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
          type: 'post',
          url: 'addtocart.php',
          data: $(this).serialize(),
          success: function(data) {
            // alert(data);
            getcount();
            getminicart();
          }

        });
        // get data
        function getcount() {
          $.ajax({
            url: 'getcount.php',
            success: function(response) {
              $('#getcount').html(response);
            }
          });
        }
        // get mini cart
        function getminicart() {
          $.ajax({
            type: "GET",
            url: 'getminicart.php',
            success: function(response) {

              $('#getminicart').html(response);

              // $.each(response, function(key, value){
              //   // console.log(value['title']);
              //   $('#getminicart').html('<li>'+
              //   '<a class="dropdown-item" href="">' + value['title'] + ' : ' + value['quantity'] + '</a>' + '</li>');
              // });

            }
          });
        }
      });
    });
  </script>
  <title>Online Shopping</title>
  <style>
    .center {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background-color: lightcyan;
      margin: 10px;
      padding: 10px;
      border-radius: 30px;
    }

    .center img {
      border-radius: 30px;
      margin: 10px;
      width: 80%;
      height: 200px;
    }

    .center p {
      color: red;
    }

    .center span {
      text-decoration: line-through;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }
  </style>
</head>

<body>

  <?php
  $conn = mysqli_connect($servername, $username, $password, $database);
  $sql = " SELECT * FROM item ";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  if ($num > 0) {

    echo "<div class='container mt-5'>";
    echo "<div class='row '>";
    while ($row = mysqli_fetch_assoc($result)) {

      $itemid = $row['id'];
      $title = $row['title'];
      $price = $row['price'];
      $image = $row['image'];
      $discount = $row['discount'];
      $actualprice = (int)($price / ((100 - $discount) / 100));

      echo "
      <form class='col-md-3'>
      <div class='center'>
      <h4>$title</h4>
      <img src='../uploads/$image' alt=''>
      <p> <span>&#8377 $actualprice</span> ($discount% off) &#8377; $price</p>
      <input type='hidden' value='$title' name='title' id='title' class='title'>
      <input type='hidden' value='$price' name='price' id='price' class='price'>
      <input type='hidden' value='$itemid' name='itemid' id='itemid' class='itemid'>
      <input class='text-center m-2 quantity' type='number' value='1' min='1' max='10' name='quantity' id='quantity' >
      <button type='submit' name='submit' id='submit' class='btn btn-primary'>Add to Cart</button>
      </div>
      </form>
      ";
    }
    echo "</div>";
    echo "</div>";
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