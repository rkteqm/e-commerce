<?php

require_once 'navbar.php';

$servername = "localhost";
$username = "root";
$password = "";
$database = "ecom";

// define variables
$fname = $lname = $gender = $dob = $pass = $city = $state = $country = $pincode = $file = "";
$fnameErr = $lnameErr = $genderErr = $dobErr = $passErr = $cityErr = $stateErr = $countryErr = $pincodeErr = $fileErr = "";

if(isset($_SESSION['id'])){
$newid = $_SESSION['id'];
$conn = mysqli_connect($servername, $username, $password, $database);
$sql = " SELECT * FROM user WHERE `id` = $newid ";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
if ($num == 1) {

    $row = mysqli_fetch_row($result);
    $fname = $row[1];
    // echo $fname;
    $lname = $row[2];
    $gender = $row[3];
    $dob = $row[4];
    $email = $row[5];
    $pass = $row[6];
    $city = $row[7];
    $state = $row[8];
    $pincode = $row[9];
    $imageName = $row[12];
    $country = $row[13];
}
}else{
    header("location: home.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // print_r($_FILES);    
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileType = $_FILES['file']['type'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    if (empty($_POST['fname'])) {
        $fnameErr = " First Name is Required";
    } else {
        $fname = test_input($_POST['fname']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
            $fnameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST['lname'])) {
        $lname = $_POST['lname'];
    } else {
        $lname = test_input($_POST['lname']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
            $fnameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    if (empty($_POST["dob"])) {
        $dobErr = "DOB is required";
    } else {
        $dob = test_input($_POST["dob"]);
        if ($dob > date("Y")) {
            $dobErr = "Enter valid DOB";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["pass"])) {
        $passErr = "Password is required";
    } else {
        $pass = test_input($_POST["pass"]);
    }

    if (empty($_POST["city"])) {
        $cityErr = "City is required";
    } else {
        $city = test_input($_POST["city"]);
    }

    if (empty($_POST["state"])) {
        $stateErr = "State is required";
    } else {
        $state = test_input($_POST["state"]);
    }

    if (empty($_POST["pincode"])) {
        $pincodeErr = "Pincode is required";
    } else {
        $pincode = test_input($_POST["pincode"]);
    }

    if (empty($_POST["country"])) {
        $countryErr = "Country is required";
    } else {
        $country = test_input($_POST["country"]);
    }

    // die('11111111111111111');
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileDestination = '../uploads/' . $fileName;
                move_uploaded_file($fileTmpName, $fileDestination);
                // create connection
                $conn = mysqli_connect($servername, $username, $password, $database);
                $sql = "UPDATE `user` SET `fname` = '$fname', `lname` = '$lname', `gender` = '$gender', `dob` = '$dob', `password` = '$pass', `city` = '$city', `state` = '$state', `pincode` = '$pincode', `country` = '$country', `image` = '$fileName' WHERE `id` = $newid";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header('update.php?updatesuccess');
                } else {
                    // echo mysqli_error($conn);
                }
            } else {
                echo "Your file is to big!";
            }
        } else {
            echo "There was an error in uploading your file";
        }
    } else {
        // echo " you can not upload this type of file";
    }
}
// Function for Validate variables 
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Upadate Page</title>
</head>

<script>
    $(document).ready(function(){
        $("#country").on('change', function(){
            var country = $(this).val();
            $.ajax({
                method: "POST",
                url: "ajax.php",
                data: {country: country},
                dataType: "html",
                success:function(data){
                    $("#state").html(data);
                }
            });
        });
        $("#state").on('change', function(){
            var state = $(this).val();
            $.ajax({
                method: "POST",
                url: "ajax.php",
                data: {state: state},
                dataType: "html",
                success:function(data){
                    $("#city").html(data);
                }
            });
        });
    });
</script>

<body>

    <div class="container mt-4">
        <h1>Enter Details You Want to Update</h1>
        <hr><br>
        <form class="row g-3" action="" method="post" enctype="multipart/form-data">
            <div class="col-md-4 align-item-center">
            </div>
            <div class="col-md-4 align-item-center">
                <img src="../uploads/<?php echo $imageName ?>" alt="" class="form-label"><br>
            </div>
            <div class="col-md-4">
                <label for="file" class="form-label">Select Image</label>
                <span class="error"><?php echo $fileErr; ?></span>
                <input type="file" class="form-control" id="file" name="file">
            </div>
            <div class="col-md-4">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?php print_r($fname); ?>">
            </div>
            <div class="col-md-4">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" value="<?php print_r($lname); ?>">
            </div>
            <div class="col-md-4 position-relative">
                <label for="gender" class="form-label">Gender</label>
                <select type="text" class="form-select" id="gender" name="gender">
                    <option selected disabled> <?php print_r($gender); ?> </option>
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>
            <div class="col-md-4 input-with-post-icon datepicker">
                <label for="dob">DOB</label>
                <input placeholder="Select date" type="date" id="dob" name="dob" class="form-control" value="<?php print_r($dob); ?>">
                <i class="fas fa-calendar input-prefix" tabindex=0></i>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label ">E-Mail</label>
                <input type="email" class="form-control list-group-item disabled" id="email" name="email" value="<?php print_r($email); ?>">
            </div>
            <div class="col-md-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="pass" value="<?php print_r($pass); ?>">
            </div>
            <div class="col-md-4 position-relative">
                <label for="country" class="form-label">Select Country</label>
                <select class="form-select" id="country" name="country" value="">
                    <option selected disabled value=""><?php print_r($country); ?></option>
                    <?php
                    $conn = mysqli_connect($servername, $username, $password, $database);
                    $query = mysqli_query($conn , "SELECT*FROM `country`"); 
                    while($row = mysqli_fetch_array($query)){
                        $country = $row['country'];
                    echo "<option value='$country' >$country</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4 position-relative">
                <label for="state" class="form-label">Select State</label>
                <select class="form-select" id="state" name="state" value="">
                    <option selected disabled value=""><?php print_r($state); ?></option>
                </select>
            </div>
            <div class="col-md-4 position-relative">
                <label for="city" class="form-label">Select City</label>
                <select class="form-select" id="city" name="city" value="">
                    <option selected disabled value=""><?php print_r($city); ?></option>
                </select>
            </div>
            <div class="col-md-4 position-relative">
                <label for="pincode" class="form-label">Pincode</label>
                <input type="text" class="form-control" id="pincode" name="pincode" value="<?php print_r($pincode); ?>">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
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


