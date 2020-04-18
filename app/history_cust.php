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

    $total_price = $_SESSION['Total_Price']; //total price

    //ถ้ามีค่า confirm และ image  คือการส่งสลิปโอนเงินแล้ว
    if (isset($_POST['confirm']) && (isset($_FILES['image']['name']) != "")) {
        $image = $_FILES['image']['name'];
        // Path to store the uploaded image
        $target = "receipt/".basename($_FILES['image']['name']);

        $status = "checking"; //status รอตรวจสอบการชำระเงิน
        // Insert Data to Database : Payment Table
        $sql = "INSERT INTO payment (`status`,transaction_image ,total_price)
                VALUES ('$status', '$image', '$total_price')";
        if (($conn->query($sql) === TRUE)) {
            if ((move_uploaded_file($_FILES['image']['tmp_name'], $target))) {
                echo '<script language="javascript">';
                echo 'alert("success!")';
                echo '</script>';
            }else{
                echo "<script language='javascript'>";
                    echo "alert('There was a problem!')";
                    echo "</script>";
                
            }
            
        }
    }else if (isset($_POST['later'])){  //ถ้ามีค่า later คือการจ่ายภายหลัง
        $status = "waiting"; //status สำหรับรอการจ่ายเงิน
        // Insert Data to Database : Payment Table
        $sql = "INSERT INTO payment (`status` ,total_price)
                VALUES ('$status', '$total_price')";
        if (($conn->query($sql) === TRUE)) {
            echo '<script language="javascript">';
            echo 'alert("success!")';
            echo '</script>';
    }else{
        echo "<script language='javascript'>";
            echo "alert('There was a problem!')";
            echo "</script>";
        
        }
    }else{  //กรณีที่เหลือ เช่น กดผิดปุ่ม
        echo "<script language='javascript'>";
        echo "alert('กดผิดปุ่ม')";
        echo "</script>";
    }
    $sql = "SELECT * FROM history"; //Select เฉพาะ history ของลูกค้าคนนั้น (ยังไม่ได้ทำ)
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
?>