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

    <title>Delete Product</title>
</head>
<body>

    <?php
        // Get all the submited data on the form and session
        $username = $_SESSION['username'];
        $product_id = $_POST['deleteProduct'];
        date_default_timezone_set("Asia/Bangkok");
        $dt = date("Y-m-d H:i:s");
            
        // Create Connection
        $conn = new mysqli("34.87.109.220", "panyaphol", "password", "db");

        // Check Connection
        if ($conn->connect_error) {
            die("Connection Failed: " . $conn->connect_error);
        }

        // DELETE data from staff_product table
        $sql = "DELETE FROM staff_product WHERE product_product_id='$product_id'";
        $conn->query($sql);

         // DELETE data from product table
        $sql = "DELETE FROM product WHERE product_id='$product_id'";
        $conn->query($sql);

        // Redirect to staff.php
        $_SESSION['username'] = $username;
        echo "<script language='javascript'>;
              alert('You delete complete!');
              window.location='staff.php';
              </script>";
        // header('Location: staff.php');

        // Close Connection
        $conn->close();
    ?>

</body>
</html>