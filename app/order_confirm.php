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
    <title>Order page</title>
    <link rel="stylesheet" href="css/style_order.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Prompt&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            margin-top: 30px;
            text-align: center;
        }
        img {
            width: 100px;
        }

        h3{
            margin-top: 30px;
        }

        h4{
            margin-top: 4px;
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
    
    echo "<div class='btn-group'><h1>Order</h1>"."<a href='logout.php' class='btn btn-outline-danger' style='height: 38px;margin-left: 6px;margin-top:8px;' role='button'>Log out</a></div>";
    echo "<h3>สวัสดีคุณ " . $_SESSION['name'] . "</h3>";
    echo "<h4>User : " . $_SESSION['username'] . "</h4>";
    echo "<hr>";
    $_SESSION['id'] = $_POST['add_product'];
    $_SESSION['amount'] = $_POST['amount'];
    $sql = "SELECT * FROM product WHERE product_id = ". $_SESSION['id'];
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $_SESSION['Total_Price'] = $row['unit_price']*$_SESSION['amount'];
    $_SESSION['product_name'] = $row['product_name'];
    
    echo '<form action="order_create.php" method="POST" enctype="multipart/form-data">';
    echo "<p>คุณได้ทำการสั่งซื้อสินค้า : " . $_SESSION['product_name'] . " จำนวน " . $_SESSION['amount'] . " " . $row['unit'] . "<p>"; //ชื่อ และ จำนวนสินค้าที่ลูกค้าสั่ง
    echo "<p>ราคารวม " . $_SESSION['Total_Price'] . " บาท<p>";
    ?> 
    <div style="border: 3px dashed #f08080;background-color:#FFFFFF">
    <p>เลขบัญชี : 008-8-95417-3</p>
    <p>ชื่อบัญชี : นางสาวนัทธวดี สุขเทียบ</p>
    <p>ธนาคาร : กสิกร</p>
    </div>
    <?php
    echo '<div class="form-group-prepend" style="margin-left: 145px;margin-top: 40px;">
            <label for="image">แนบรูปภาพชำระเงิน :</label>
            <input type="file" id="image" name="image">
            </div>';  // แนบรูปภาพสลิป
    echo "<div class='form-group'>
            <label for='recieve'>ระบุวันรับสินค้า:</label>
            <input type='date' id='recieve' name='recieve'>
            </div>";  //ระบุวันที่รับสินค้า
    echo "<button type='submit' class='btn btn-info px-4'' name='confirm' value='1'>ส่ง</button>"; //ส่งใบสลิป
    echo '</form>';
    echo '<form action="home.php" method="POST">';
    echo "<button type='submit' class='btn btn-secondary px-4' name='later' value='1'>ยกเลิก</button>"; //ยกเลิกรายการ
    echo "</form>";
    // Close Connection
    $conn->close();
?>
</body>
</html>