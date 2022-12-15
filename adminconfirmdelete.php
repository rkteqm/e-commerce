<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "ecom";
    session_start();
    if(isset($_SESSION['id'])){

        $id = $_GET['var'];

        $conn = mysqli_connect($servername, $username, $password, $database);
        $sql = " DELETE FROM item WHERE `id` = $id ";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            header("location:admin.php?deleted-successfully");
        }
    }else {
        header("location: home2.php");
    }
?>