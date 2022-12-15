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
  echo $count;
} else {
  if (isset($_SESSION['cart'])) {
    $count = count($_SESSION['cart']);
    echo $count;
  }
}
?>