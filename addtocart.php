<?php

session_start();


$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'ecom';

if (isset($_SESSION['id'])) {
    $userid = $_SESSION['id'];

    if (isset($_POST['remove'])) {
        $id = $_POST['id'];

        $conn = mysqli_connect($servername, $username, $password, $database);
        $sql = " DELETE FROM `cart` WHERE `id` =  '$id' ";
        $result = mysqli_query($conn, $sql);
        $sql2 = " SELECT*FROM `cart` WHERE `user_id` = '$userid' ";
        $result2 = mysqli_query($conn, $sql2);
        $num = mysqli_num_rows($result2);
        $count = $num;
        echo $count;
    }elseif(isset($_POST['update'])) {

            $id = $_POST['itemid'];
            $quantity = $_POST['quantity'];

            $conn = mysqli_connect($servername, $username, $password, $database);
            $sql = " UPDATE `cart` SET `quantity` = '$quantity' WHERE `id` =  '$id' ";
            $result = mysqli_query($conn, $sql);
            echo $quantity;

    }else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $itemid = $_POST['itemid'];
            $title = $_POST['title'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];

            $conn = mysqli_connect($servername, $username, $password, $database);
            $sql = " SELECT * FROM `cart` WHERE `item_id` = '$itemid' AND `user_id` = '$userid' ";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            if ($num == 1) {
            $sql2 = " SELECT*FROM `cart` WHERE `user_id` = '$userid' ";
            $result2 = mysqli_query($conn, $sql2);
            $num2 = mysqli_num_rows($result2);
            $count = $num2;
            echo $count;
            } else {
                $conn = mysqli_connect($servername, $username, $password, $database);
                $sql = " INSERT INTO `cart` (`user_id`, `item_id`, `title`, `price`, `quantity`) VALUES('$userid', '$itemid', '$title', '$price', '$quantity' ) ";
                $result = mysqli_query($conn, $sql);
                $sql2 = " SELECT*FROM `cart` WHERE `user_id` = '$userid' ";
                $result2 = mysqli_query($conn, $sql2);
                $num = mysqli_num_rows($result2);
                $count = $num;
                echo $count;
            }
        }
    }
} else {
    if (isset($_SESSION['cart'])) { 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['remove'])) {
                foreach ($_SESSION['cart'] as $key => $value) {
                    if ($value['itemid'] == $_POST['id']) {
                        unset($_SESSION['cart'][$key]);
                        $_SESSION['cart'] = array_values($_SESSION['cart']);
                        $count = count($_SESSION['cart']);
                        echo $count;
                    }
                }
            }elseif(isset($_POST['update'])){
                
                foreach ($_SESSION['cart'] as $key => $value) {
                    if ($value['itemid'] == $_POST['itemid']) {
                        $_SESSION['cart'][$key]['quantity'] = $_POST['quantity'];    
                        echo $_POST['quantity'];
                    }
                }

            }else {

                $myitems = array_column($_SESSION['cart'], 'itemid');
                if (in_array($_POST['itemid'], $myitems)) {
                $count = count($_SESSION['cart']);
                echo $count;
                } else {


                    $count = count($_SESSION['cart']);
                    $_SESSION['cart'][$count] = array('itemid' => $_POST['itemid'], 'title' => $_POST['title'], 'price' => $_POST['price'], 'quantity' => $_POST['quantity']);
                    $count = count($_SESSION['cart']);
                    echo $count;
                }
            }
        }
    } else {
        $_SESSION['cart'][0] = array('itemid' => $_POST['itemid'], 'title' => $_POST['title'], 'price' => $_POST['price'], 'quantity' => $_POST['quantity']);
        $count = count($_SESSION['cart']);
        echo $count;    
    }
}
?>
