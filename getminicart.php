<?php
session_start();
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'ecom';

$result_array = [];

if (isset($_SESSION['id'])) {
    $userid = $_SESSION['id'];
    $conn = mysqli_connect($servername, $username, $password, $database);
    $sql = " SELECT*FROM `cart` WHERE `user_id` = '$userid' ";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    $sr = 0;
    if ($num > 0) {

        // foreach($result as $row)
        // {
        //     array_push($result_array, $row);
        // }
        // header('Content-type: application/json');
        // echo json_encode($result_array);

        while ($row = mysqli_fetch_assoc($result)) {
            $title = $row['title'];
            $quantity = $row['quantity'];
            echo "<li><a class='dropdown-item' href=''>$title :    $quantity</a></li>";
        }
    }
} else {
    if (isset($_SESSION['cart'])) {

        // foreach ($_SESSION['cart'] as $row) 
        // {
        //     array_push($result_array, $row);
        // }
        // header('Content-type: application/json');
        // echo json_encode($result_array);

        foreach ($_SESSION['cart'] as $key => $value) {
            echo "<li><a class='dropdown-item' href=''>$value[title] :    $value[quantity]</a></li>";
        }
    }
}
?>
