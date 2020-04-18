<?php

    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
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

    <title>Create New Product</title>
</head>
<body>
<div class="container mt-4">
        <h1>Create New Product</h1>
        <h3>สวัสดีคุณ <?php echo $_SESSION['username']; ?></h3>
        <hr>
        <form action="create_product.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">Product Name :</label>
                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Milk" minlength='2' placeholder="John"
                    pattern="[A-Za-z]{2,}|[ก-๙]{2,}"
                    title="Must be Thai / Eng language and contain at least 2 characters" required>
            </div>
            <div class="form-group">
                <label for="unit_price">Price per unit :</label>
                <input type="number" class="form-control" id="unit_price" name="unit_price" placeholder="100.25" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount :</label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="25.00">
            </div>
            <div class="form-group">
                <label for="unit">Unit (หน่วย) :</label>
                <input type="text" class="form-control" id="unit" name="unit" placeholder="kg." minlength='2'
                    pattern="[A-Za-z]{2,}|[ก-๙]{2,}"
                    title="Must be Thai / Eng language and contain at least 2 characters" required>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="This is a ...">
            </div>
            <div class="form-group">
                <label for="image">Image :</label>
                <input type="file" id="image" name="image">
            </div>
            <div class="form-group">
				<center> 
                    <input type="submit" name="create_product" value="Create Product" style="margin-top: 20px"class="btn btn-outline-dark">
                </center>
			</div>
        </form>
        <a href="staff.php" class="btn btn-info" role="button">Back</a>
    </div>

    <?php

        // if create product button is pressed
        if (isset($_POST['create_product'])) {
            // Get all the submited data on the form and session
            $product_name = $_POST['product_name'];
            $unit_price = $_POST['unit_price'];
            $amount = $_POST['amount'];
            $image = $_FILES['image']['name'];
            $username = $_SESSION['username'];
            $unit = $_POST['unit'];
            $description = $_POST['description'];
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

            // Insert Data into Database : Product Table
            $sql = "INSERT INTO product (unit_price, product_name, amount, `image`, unit, `description`)
                    VALUES ($unit_price, '$product_name', $amount, '$image', '$unit', '$description')";

            if ($conn->query($sql) === TRUE) {
                if ((move_uploaded_file($_FILES['image']['tmp_name'], $target)) || $image == "") {
                    echo "<script language='javascript'>";
                    echo "alert('Create Product Successfully!')";
                    echo "</script>";
                } else {
                    echo "<script language='javascript'>";
                    echo "alert('There was a problem create product!')";
                    echo "</script>";
                }
            }

            // SELECT product_id recently create FROM product TABLE
            $sql = "SELECT product_id FROM product ORDER BY product_id DESC LIMIT 1";
            $result = $conn->query($sql);
            $row = mysqli_fetch_array($result);
            $product_id = $row['product_id'];

            // Insert Data into Database : STAFF_PRODUCT table
            $sql = "INSERT INTO staff_product (staff_user_username, product_product_id, datetime, manage_type)
                    VALUES ('$username', $product_id, '$dt', 'insert')";
            $conn->query($sql);

            // Close Connection
            $conn->close();
        }
    ?>

</body>
</html>