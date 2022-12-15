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

    </script>

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
                                    <td>$quantity</td>
                                    <td>
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
                                <td>$value[quantity]</td>
                            </tr>
                            ";
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-3 text-center">
                <div class="border bg-light rounded p-4">
                    <br>
                    <h3>Total</h3>
                    <h5 style="color: red;">&#8377; <span id="gettotal"><?php echo $total ?></span> </h5>
                    <br>
                    <h6>Select Mode of Payment</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Cash on Delevery
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Online Payment
                        </label>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <div class="row">
            <h3>Enter Billing Details</h3>
        </div>
        <div class="col-md-12">
            <form class="row g-3">
                <div class="col-md-4">
                    <label for="inputEmail4" class="form-label">Name</label>
                    <input type="text" class="form-control" id="inputEmail4">
                </div>
                <div class="col-md-3">
                    <label for="inputEmail4" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmail4">
                </div>
                <div class="col-md-3">
                    <label for="inputPassword4" class="form-label">Contact no</label>
                    <input type="number" class="form-control" id="inputPassword4">
                </div>
                <div class="col-6">
                    <label for="inputAddress" class="form-label">Address</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                </div>
                <div class="col-md-2">
                    <label for="inputCity" class="form-label">City</label>
                    <input type="text" class="form-control" id="inputCity">
                </div>
                <div class="col-md-2">
                    <label for="inputZip" class="form-label">Zip</label>
                    <input type="text" class="form-control" id="inputZip">
                </div>
                <div class="col-md-4 mb-4">
                    <button type="submit" class="btn btn-primary">Place Order</button>
                </div>
            </form>
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