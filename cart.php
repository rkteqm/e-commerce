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
    <title>Online Shopping</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.cart-remove').on('click', function(e) {
                var a = e.target.value;
                var b = $(this).parents("tr:first");
                $.ajax({
                    type: 'POST',
                    url: 'addtocart.php',
                    data: {
                        remove: true,
                        id: a
                    },
                    success: function(data) {
                        getcount();
                        b.hide();
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
            });
            $('.cart-update').on('change', function(e) {
                var a=e.target.value;
                var $el = $(this).closest('td');
                var itemid = $el.find(".itemid").val();

                $.ajax({
                    type: 'POST',
                    url: 'addtocart.php',
                    data: {
                        update: true,
                        itemid: itemid,
                        quantity: a
                    },
                    success: function(data) {
                        $('#quantity').html(response);
                    }
                });
            });

        });
    </script>

    <style>
        .butn {
            width: 28px;
            height: 28px;
            background: linear-gradient(#fff, #f9f9f9);
            display: inline-block;
            border: 1px solid #c2c2c2;
            cursor: pointer;
            font-size: 16px;
            border-radius: 50%;
            padding-top: 1px;
            line-height: 1;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center border rounded bg-light my-5">
                <h1>My Cart</h1>
            </div>
            <div class="col-lg-9 text-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Serial No</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Item price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="getcartdata">

                        <?php
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
                                    <input type='hidden' class='itemid' value='$id'>
                                    <input class='text-center m-2 cart-update' type='number' value='$quantity' min='1' max='9' name='quantity' id='quantity'>
                                    </td>
                                    
                                    <td>
                                    <button name='remove' value='$id' class='btn btn-sm btn-outline-danger cart-remove'>Remove</button>
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
                                        <input type='hidden' class='itemid' value='$itemid'>
                                        <input class='text-center m-2 cart-update' id='quantity' type='number' value='$value[quantity]' min='1' max='9' name='quantity' id='quantity'>
                                        </td>

                                        <td>
                                        <button name='remove'  value='$itemid' class='btn btn-sm btn-outline-danger cart-remove'>Remove</button>
                                        </td>

                                    </tr>
                                    ";
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-3 text-center mt-5 ">
                <br>
                <button class="btn btn-primary btn-block"><a href="home.php" style="color: white; text-decoration:none;">Shop More</a></button>
                <br>
                <br>
                <br>
                <button class="btn btn-primary btn-block"><a href="billing.php" style="color: white; text-decoration:none;">Proceed to Payment</a></button>
            </div>
        </div>
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