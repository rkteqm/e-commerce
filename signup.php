<?php

require_once 'navbar.php';

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'ecom';
?>
<?php


// define variables
$fname = $lname = $gender = $dob = $email = $pass = $city = $state = $country = $pincode = $file = "";
$fnameErr = $lnameErr = $genderErr = $dobErr = $emailErr = $passErr = $cityErr = $stateErr = $countryErr = $pincodeErr = $fileErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

// die("1111111111111");
    if (empty($fnameErr) && empty($genderErr) && empty($dobErr) && empty($emailErr) && empty($passErr) && empty($cityErr) && empty($stateErr) && empty($pincodeErr) && empty($countryErr)) {

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $fileDestination = '../uploads/' . $fileName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    // create connection
                    $conn = mysqli_connect($servername, $username, $password, $database);
                    $sql = "INSERT INTO user (fname, lname, gender, dob, username, password, city, state, pincode, image, country) 
                    VALUES ('$fname', '$lname', '$gender', '$dob', '$email', '$pass', '$city', '$state', '$pincode','$fileName', '$country') ";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                             You have registered successfully..
                             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                             </div>';
                             header('signup.php?signupsuccess');
                    } else {
                        echo mysqli_error($conn);
                    }
                } else {
                    echo "Your file is to big!";
                }
            } else {
                echo "There was an error in uploading your file";
            }
        } else {
            echo "You can not upload file of this type";
        }
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
<style>
    .error {
        color: red;
    }
</style>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="date.js">
</head>

<script>
    $(document).ready(function(){
        $("#country").on('change', function(){
            var country = $(this).val();
            // console.log(country);
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
    <!----------------------------------- signup page -------------------------------------->
    <div class="container mt-5">
        <h1>Please Register Here</h1>
        <hr><br>
        <form class="row g-3" action="" method="post" enctype="multipart/form-data">
            <div class="col-md-4">
                <label for="file" class="form-label">Upload Profile</label>
                <span class="error">*<?php echo $fileErr; ?></span>
                <input type="file" class="form-control" id="file" name="file">
            </div>
            <div class="col-md-4">
                <label for="fname" class="form-label">First Name</label>
                <span class="error">*<?php echo $fnameErr; ?></span>
                <input type="text" class="form-control" id="fname" name="fname">
            </div>
            <div class="col-md-4">
                <label for="lname" class="form-label">Last Name</label>
                <span class="error"><?php echo $lnameErr; ?></span>
                <input type="text" class="form-control" id="lname" name="lname">
            </div>
            <div class="col-md-4 position-relative">
                <label for="gender" class="form-label">Gender</label>
                <span class="error">*<?php echo $genderErr; ?></span>
                <select type="text" class="form-select" id="gender" name="gender">
                    <option selected disabled value="">Choose...</option>
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>
            <div class="col-md-4 input-with-post-icon datepicker">
                <label for="dob">DOB</label>
                <span class="error">*<?php echo $dobErr; ?></span>
                <input placeholder="Select date" type="date" id="dob" name="dob" class="form-control">
                <i class="fas fa-calendar input-prefix" tabindex="0"></i>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">E-Mail</label>
                <span class="error">*<?php echo $emailErr; ?></span>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="col-md-4">
                <label for="password" class="form-label">Password</label>
                <span class="error">*<?php echo $passErr; ?></span>
                <input type="password" class="form-control" id="password" name="pass">
            </div>
            <div class="col-md-4 position-relative">
                <label for="country" class="form-label">Country</label>
                <span class="error">*<?php echo $countryErr; ?></span>
                <select class="form-select" id="country" name="country">
                    <option selected disabled value="">Select Country</option>
                    
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
                <label for="state" class="form-label">State</label>
                <span class="error">*<?php echo $stateErr; ?></span>
                <select class="form-select" id="state" name="state">
                <option selected disabled value="">Select State</option>
                </select>
            </div>
            <div class="col-md-4 position-relative">
                <label for="city" class="form-label">City</label>
                <span class="error">*<?php echo $cityErr; ?></span>
                <select class="form-select" id="city" name="city">
                <option selected disabled value="">Select City</option>
                </select>
            </div>
            <div class="col-md-4 position-relative">
                <label for="pincode" class="form-label">Pincode</label>
                <span class="error">*<?php echo $pincodeErr; ?></span>
                <input type="text" class="form-control" id="pincode" name="pincode">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Sign up</button>
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