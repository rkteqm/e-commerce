<?php
session_start();
if(isset($_SESSION['id'])){
    session_unset();
    session_destroy();
    echo "You have been logged out";
    header('location: home.php');
}else{
    header("location: home.php");
}
?>