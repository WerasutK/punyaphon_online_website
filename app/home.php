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
    <title>Home page</title>
    <link rel="stylesheet" href="css/style_home.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Prompt&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            text-align: center;

        }
        footer{
            margin-top: 100px; 
        }
        img {
            width: 100px;
        }
    </style>
</head>
<body>

<?php
    // Create Connection
    $conn = new mysqli("34.87.109.220", "panyaphol", "password", "db");

    // Check Connection
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    } ?>

    <?php
    echo "<div class='container mt-4'>";
    echo"<div class='btn-group'>
            <h1>Home</h1>
        <div class='col-md-2'>
            <div class='button-1'> 
                <a href='history_cust.php' class='btn btn-outline-dark' role='button'>History</a>
                <a href='logout.php' class='btn btn-outline-danger' style='margin-top: 5px;' role='button'> Log out</a>
            </div>
        </div>";
    
    echo "</div>";
    echo "<h4 style='margin-top: 20px;'>สวัสดีคุณ " . $_SESSION['name']  ."  :)". "</h4>";
    echo "<h5>User : " . $_SESSION['username'] .  "</h5>";
    echo "<hr>";

    $sql = "SELECT * FROM product";
    $result = $conn->query($sql);

    echo "<div class='container'>";
    echo "<div class='row'>";

    while($row = $result->fetch_assoc()) {
        echo "<div class='col-md-4'>";
        echo "<div class='card' style='width: 100%;height:550px'>";
        echo "<h5 class='card-title'>" . $row['product_name'] . "</h5>";
        echo "<center>";
        echo "<img style='width:60%; height:80%;' class='card-img-top' src='product/" . $row['image'] . "'>";
        echo "</center>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-text'>ราคา : " . $row['unit_price'] . " บาท</h5>";
        echo "<p class='card-text'>จำนวนที่เหลือ : " . $row['amount'] ." ". $row['unit'] .  "</p>";  // จำนวนที่เหลือ
        echo "<p class='card-text'>คำอธิบาย : " . $row['description'];
        echo "</div>";
        echo "<div class='card-body'>";
        echo '<form action="order_confirm.php" method="POST">';
        $amount = $row['amount'];
        if ($amount === '0'){
            echo "<h4 class='card-text'>Out of Stock!</h4>";
        }else{
            echo '<input type="number" name="amount" class="form-control" value="1"/>';
            echo "<button type='submit' class='btn btn-info px-4'style='margin-top:10px;'name='add_product' value=".$row['product_id'].">สั่งซื้อ</button>"; //กดปุ่ม Submit จะส่งค่า ID และ จำนวนที่สั่งไปยังหน้า order
            echo '</form>';
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    echo "<footer></footer>";
    // Close Connection
    $conn->close();
?>
</body>
</html>
