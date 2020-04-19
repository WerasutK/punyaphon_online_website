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

    <link rel="stylesheet" href="css/style_staff.css">

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
        <h1>Administrator Page</h1>
        <h3>สวัสดีคุณ <?php echo $_SESSION['username']; ?></h3>
        <div class="btn-group" style="margin-top:10px;">
            <form action="create_product.php" method="POST">
                <input type="submit" name="createProduct" value="Create New Product" class="btn btn-primary">
            </form>
            <p class="line"></p>
            <a href="logout.php" class="btn btn-outline-danger" style="margin-left: 8px;height: 38px;" role="button">Log out</a>
        </div>
    </div>
    <hr>
    <?php
        // Create Connection
        $conn = new mysqli("34.87.109.220", "werasutk", "password", "db");

        // Check Connection
        if ($conn->connect_error) {
            die("Connection Failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM product";
        $result = $conn->query($sql);

        echo "<div class='container'>";
        echo "<div class='row'>";

        while($row = $result->fetch_assoc()) {
            echo "<div class='col-md-4'>";
            echo "<div class='card' style='width: 18rem;'>";
            echo "<h5 class='card-title'>" . $row['product_name'] ."</h5>";
            echo "<img class='card-img-top' src='" . $row['image'] . "'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-text'>ราคา : " . $row['unit_price'] . " บาท</h5>";
            echo "<p class='card-text'>จำนวนที่เหลือ : " . $row['amount'] ." ". $row['unit'] .  "</p>";  // จำนวนที่เหลือ
            echo "</div>";
            echo "<div class='card-body'>";
            echo '<form action="update_product_page.php" method="POST">';
            echo "<center> <button type='submit' class='btn btn-dark px-4' style='width:130px;' name='updateProduct' value=".$row['product_id'].">Update</button> </center>"; // If submitted, will send product_id to ...
            echo '</form>';
            echo '<form action="delete_product.php" method="POST">';
            echo "<center> <button type='submit' class='btn btn-outline-dark px-4' style='width:130px;' name='deleteProduct' value=".$row['product_id'].">Delete</button> </center>"; // If submitted, will send product_id to ...
            echo '</form>';
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
        echo "<footer></footer>";

        // Close Connection
        $conn->close();

        // If Create Product button was pressed
        if (isset($_POST['createProduct'])) {
            // Session staff username
            $username = $_SESSION['username'];
            $_SESSION['username'] = $username;
            header("Location: create_product.php");
        }

        // If Update Product button was pressed
        if (isset($_POST['updateProduct'])) {
            // Session staff username
            $username = $_SESSION['username'];
            $_SESSION['username'] = $username;
            header("Location: update_product_page.php");
        }

        // If Delete Product button was pressed
        if (isset($_POST['deleteProduct'])) {
            // Session staff username
            $username = $_SESSION['username'];
            $_SESSION['username'] = $username;
            header("Location: delete_product.php");
        }

    ?>

</body>
</html>