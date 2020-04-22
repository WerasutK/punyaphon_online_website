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

    <link rel="stylesheet" href="css/style_update.css">

    <link href="https://fonts.googleapis.com/css?family=Prompt&display=swap" rel="stylesheet">

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

    <div class="container mt-4">
        <h1>Update Product</h1>
        <h4>สวัสดีคุณ <?php echo $_SESSION['username']; ?></h4>


        <?php
            $username = $_SESSION['username'];
            $product_id = $_POST['updateProduct'];

            // Create Connection
            $conn = new mysqli("34.87.109.220", "werasutk", "password", "db");

            // Check Connection
            if ($conn->connect_error) {
                die("Connection Failed: " . $conn->connect_error);
            }

            // Select data you will update from product table
            $sql = "SELECT * FROM product WHERE product_id='$product_id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        
            // Show data you selected to update
            echo '<form action="update_product.php" method="POST" enctype="multipart/form-data" style="margin-top: 20px; height:609px;">';
            echo '<div class="card mb-4">';
            echo '<article class="card-body mx-auto" style="margin-top: 10px;width: 480px;">';
            echo '<div class="form-group">
                    <label for="product_name">Product Name :</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" value="' . $row['product_name'] . '" minlength="2" placeholder="Product name"
                        pattern="[A-Za-z]{2,}|[ก-๙]{2,}"
                        title="Must be Thai / Eng language and contain at least 2 characters" required>
                </div>';
            echo '<div class="form-group">
                    <label for="unit_price">Price per unit :</label>
                    <input type="number" class="form-control" id="unit_price" name="unit_price" value="' . $row['unit_price'] . '" required>
                </div>';
            echo '<div class="form-group">
                    <label for="amount">Amount :</label>
                    <input type="number" class="form-control" id="amount" name="amount" value="' . $row['amount'] . '">
                </div>';
            echo '<div class="form-group">
                    <label for="unit">Unit (หน่วย) :</label>
                    <input type="text" class="form-control" id="unit" name="unit" value="' . $row['unit'] . '" minlength="2"
                        pattern="[A-Za-z]{2,}|[ก-๙]{2,}"
                        title="Must be Thai / Eng language and contain at least 2 characters" required>
                </div>';
            echo '<div class="form-group">
                    <label for="description">Description :</label>
                    <input type="text" class="form-control" id="description" name="description" value="' . $row['description'] . '">
                </div>';
            echo '<div class="form-group">
                    <label for="image">Image :</label>
                    <input type="file" id="image" name="image">
                </div>';
            echo '<div class="form-group">
				    <center> 
                        <button type="submit" name="update_product" value="' . $row['product_id'] . '" style="margin-top: 20px"class="btn btn-dark">Update</button>
                    </center>
                </div>';
            echo '</article>';
            echo '</div>';
            echo '</form>';
            echo '<div class="btn-group mt-4" style="margin-left: 950px;">
                    <a href="staff.php" class="btn btn-outline-dark" role="button">Back</a>
                    <a href="logout.php" class="btn btn-outline-danger" role="button">Log out</a>
                </div>';
            echo '<footer></footer>';

            // If pressed update button
            if (isset($_POST['update_product'])) {
                $_SESSION['username'] = $username;
                $_SESSION['tye'] = 'staff';
                header('Location: update_product.php');
            }
            

            // Close Connection
            $conn->close();
    ?>
    </div>

</body>
</html>