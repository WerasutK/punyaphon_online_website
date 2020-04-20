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
    <title>Document</title>
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
    $conn = new mysqli("34.87.109.220", "werasutk", "password", "db");

    // Check Connection
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    echo "<div class='btn-group'><h1>Home</h1> </div>" . "<a href='logout.php' class='btn btn-outline-danger' role='button'> Log out</a> </div>";
    echo "<hr>"."<h4>สวัสดีคุณ " . $_SESSION['name']  ."  :)". "</h4>";
    echo "<h5>User : " . $_SESSION['username'] .  "</h5>";

    $sql = "SELECT * FROM product";
    $result = $conn->query($sql);

    echo "<div class='container'>";
    echo "<div class='row'>";

    while($row = $result->fetch_assoc()) {
        echo "<div class='col-md-4'>";
        echo "<div class='card' style='width: 20srem;'>";
        echo "<h5 class='card-title'>" . $row['product_name'] . "</h5>";
        echo "<img class='card-img-top' src='" . $row['image'] . "'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-text'>ราคา : " . $row['unit_price'] . " บาท</h5>";
        echo "<p class='card-text'>จำนวนที่เหลือ : " . $row['amount'] ." ". $row['unit'] .  "</p>";  // จำนวนที่เหลือ
        echo "</div>";
        echo "<div class='card-body'>";
        echo '<form action="order_confirm.php" method="POST">';
        echo '<input type="text" name="amount" class="form-control" value="1"/>';
        echo "<button type='submit' class='btn btn-info px-4'style='margin-top:20px;'name='add_product' value=".$row['product_id'].">สั่งซื้อ</button>"; //กดปุ่ม Submit จะส่งค่า ID และ จำนวนที่สั่งไปยังหน้า order
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
?>
</body>
</html>
