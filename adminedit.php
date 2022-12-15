<?php
require_once "navbar.php";
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
</head>

<body>

    <!---------------------------------------- php ----------------------------------------- -->
    <?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'ecom';

    // define variables
    $category = $title = $price = "";

    // session_start();
        if (isset($_SESSION['id'])) {
            $id = $_GET['var'];
    
            $conn = mysqli_connect($servername, $username, $password, $database);
            $sql = " SELECT * FROM item WHERE `id` = $id ";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            if ($num == 1) {
    
                $row = mysqli_fetch_assoc($result);
    
                $id = $row['id'];
                $userid = $row['user_id'];
                $category = $row['category'];
                $title = $row['title'];
                $price = $row['price'];
                $image = $row['image'];
                $created_at = $row['created_at'];
            }
        } else {
            header('location: home.php');
        }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $category = $_POST['category'];
        $title = $_POST['title'];
        $price = $_POST['price'];

        $file = $_FILES['image'];
        $fileName = $_FILES['image']['name'];
        $fileTmpName = $_FILES['image']['tmp_name'];
        $fileType = $_FILES['image']['type'];
        $fileSize = $_FILES['image']['size'];
        $fileError = $_FILES['image']['error'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $fileDestination = '../uploads/' . $fileName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    // create connection
                    $conn = mysqli_connect($servername, $username, $password, $database);
                    $sql = "UPDATE `item` SET `category`='$category', `title`='$title',`price`='$price', `image`='$fileName' WHERE `id`='$id' ";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        // header('admin.php?itemupdatesuccess');
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
    ?>

    <div class="container mt-4">
        <h1>Add your Item !</h1>
        <hr><br>
        <form class="row g-3" action="" method="POST" enctype="multipart/form-data">
            <div class="col-md-12">
                <img src="../uploads/<?php echo $image; ?>" alt="">
            </div>
            <div class="col-md-3">
                <label for="category" class="form-label">Select Category</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                    <option>Books</option>
                    <option>Clothing</option>
                    <option>Electronics</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" required>
            </div>
            <div class="col-md-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $price; ?>" required>
            </div>
            <div class="col-md-3">
                <label for="image" class="form-label">Change Image</label>
                <input type="file" class="form-control" id="image" name="image" value="<?php echo $image; ?>" required>
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