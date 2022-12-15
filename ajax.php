<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'ecom';
$conn = mysqli_connect($servername, $username, $password, $database);

if(isset($_POST['country'])){
    $country = $_POST['country'];
    $sql = "SELECT*FROM `state` WHERE `country` = '$country'";
    $query = mysqli_query($conn , $sql);
    while($row = mysqli_fetch_array($query)){
        $state = $row['state'];
               echo "<option value='$state' >$state</option>";
    }
}

if(isset($_POST['state'])){
    $state = $_POST['state'];
    $sql = "SELECT*FROM `city` WHERE `state` = '$state'";
    $query = mysqli_query($conn , $sql);
    while($row = mysqli_fetch_array($query)){
        $city = $row['city'];
               echo "<option value='$city' >$city</option>";
    }
}

?>