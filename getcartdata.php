<?php

session_start();
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'ecom';

$total = 0;

if (isset($_SESSION['id'])) {
    $userid = $_SESSION['id'];
    $conn = mysqli_connect($servername, $username, $password, $database);
    $sql = " SELECT*FROM `cart` WHERE `user_id` = '$userid' ";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    $sr = 0;
    if ($num > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            $id = $row['id'];
            $title = $row['title'];
            $price = $row['price'];
            $quantity = $row['quantity'];

            $total = $total + $price * $quantity;
            $sr = $sr + 1;
            echo "
            <tr>
                <td>$sr</td>
                <td>$title</td>
                <td>$price</td>
                <td>
                <form>
                <input class='text-center m-2 quantity' type='number' value='$quantity' min='1' max='9' name='quantity' id='quantity'>
                <input type='hidden' name='id' value='$id'>
                <input type='hidden' name='update' value='$id'>
                <button name='submit' type='submit' class='btn btn-sm btn-outline-danger'>Update</button>
                </form>
                </td>
                <td>
                <form>
                <input type='hidden' name='id' value='$id'>
                <input type='hidden' name='remove' value='$id'>
                <button name='submit' type='submit' class='btn btn-sm btn-outline-danger'>Remove</button>
                </form>
                </td>
                </tr>
                ";
        }
    }
} else {
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
            $total = $total + $value['price'] * $value['quantity'];
            $sr = $key + 1;
            $itemid = $value['itemid'];
            echo "
            <tr>
            <td>$sr</td>
            <td>$value[title]</td>
            <td>$value[price]</td>
            <td>
            <form>
            <input class='text-center m-2 quantity' id='quantity' type='number' value='$value[quantity]' min='1' max='9' name='quantity' id='quantity'>
            <input type='hidden' name='itemid' value='$itemid'>
            <input type='hidden' name='update' value='$itemid'>
            <button name='submit' type='submit' class='btn btn-sm btn-outline-danger'>Update</button>
            </form>
            </td>
            <td>
            <form>
            <input type='hidden' name='itemid' value='$itemid'>
            <input type='hidden' name='remove' value='$itemid'>
            <button name='submit' type='submit' class='btn btn-sm btn-outline-danger'>Remove</button>
            </form>
            </td>
        </tr>
        ";
        }
    }
}
?>