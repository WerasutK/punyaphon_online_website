<?php

    session_start();

    if ((!isset($_SESSION['username'])) || $_SESSION['type'] != 'staff') {
        session_destroy();
        // header('Location: login.php');
        echo "<script language='javascript'>;
                    alert('Permission Denied!');
                    window.location='login.php';
            </script>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <title>Administrator Page</title>
</head>
<body>
    <?php
        // Get all Data from form action
        $username = $_SESSION['username'];
        $product_id = $_POST['update_product'];
        $product_name = $_POST['product_name'];
        $unit_price = $_POST['unit_price'];
        $amount = $_POST['amount'];
        $unit = $_POST['unit'];
        $description = $_POST['description'];
        $image = $_FILES['image']['name'];
        date_default_timezone_set("Asia/Bangkok");
        $dt = date("Y-m-d H:i:s");

        // Path to store the uploaded image
        $target = "product/".basename($_FILES['image']['name']);

        // Create Connection
        $conn = new mysqli("34.87.109.220", "werasutk", "password", "db");

        // Check Connection
        if ($conn->connect_error) {
            die("Connection Failed: " . $conn->connect_error);
        }
        // Update Data: Product table
        if ($image == "") {
            $sql = "UPDATE product SET product_name='$product_name', unit_price='$unit_price', amount='$amount', unit='$unit', `description`='$description'
                    WHERE product_id='$product_id'";
            if ($conn->query($sql)) {
                echo "<script language='javascript'>;
                      alert('Update Completed!');
                      window.location='staff.php';
                      </script>";
            } else {
                echo "<script language='javascript';
                      alert('Update Failed!');
                      window.location='staff.php';
                      </script>";
            }
        } else {
            $sql = "UPDATE product SET product_name='$product_name', unit_price='$unit_price', amount='$amount', unit='$unit', `description`='$description', `image`='$image'
                    WHERE product_id='$product_id'";
            if ($conn->query($sql)) {
                echo "<script language='javascript'>;
                      alert('Update Completed!');
                      window.location='staff.php';
                      </script>";
            } else {
                echo "<script language='javascript';
                      alert('Update Failed!');
                      window.location='staff.php';
                      </script>";
            }
        }

        // Insert Data into Database : STAFF_PRODUCT table
        $sql = "INSERT INTO staff_product (staff_user_username, product_product_id, datetime, manage_type)
                VALUES ('$username', $product_id, '$dt', 'update')";
        $conn->query($sql);

        // Redirect to staff.php
        $_SESSION['username'] = $username;
        // header('Location: staff.php');
            
        // Close Connection
        $conn->close();
    ?>

    </div>

</body>
</html>