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

    echo "<a href='logout.php' class='btn btn-outline-primary' role='button'>Log out</a>";
    
    echo "<h1>Home page!</h1>";
    echo "<h3>สวัสดีคุณ" . $_SESSION['name'] . "</h3>";
    echo "<h1>User : " . $_SESSION['username'] .  "</h3>";
    $id = $_POST['add_product'];
    $amount = $_POST['amount'];
    $_SESSION['amount'] = $amount;
    $sql = "SELECT * FROM product WHERE product_id = '$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $_SESSION['Total_Price'] = $row['unit_price']*$amount;
    echo "<p>คุณได้ทำการสั่งซื้อสินค้า : " . $row['product_name'] . " จำนวน " . $amount . " ชิ้น<p>"; //ชื่อ และ จำนวนสินค้าที่ลูกค้าสั่ง
    echo "<p>ราคารวม " . $_SESSION['Total_Price'] . " บาท<p>";
    echo '<form action="history_cust.php" method="POST" enctype="multipart/form-data">';
    echo '<div class="form-group">
            <label for="image">แนบรูปภาพชำระเงิน :</label>
            <input type="file" id="image" name="image">
            </div>';  // แนบรูปภาพสลิป
    echo "<button type='submit' class='btn btn-info px-4' style='margin-top:20px;' name='confirm' value='1'>ส่ง</button>"; //ส่งใบสลิป
    echo "</form>";
    echo '<form action="history_cust.php" method="POST">';
    echo "<button type='submit' class='btn btn-info px-4' style='margin-top:20px;' name='later' value='1'>ชำระภายหลัง</button>"; //ส่งภายหลัง
    echo "</form>";
    echo '<form action="home.php" method="POST">';
    echo "<button type='submit' class='btn btn-info px-4' style='margin-top:20px;' name='later' value='1'>ยกเลิก</button>"; //ส่งภายหลัง
    echo "</form>";


    // Close Connection
    $conn->close();
?>
</body>
</html>