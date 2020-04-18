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

    $sql = "SELECT * FROM history"; //Select เฉพาะ history ของลูกค้าคนนั้น (ยังไม่ได้ทำ)
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $amount = $_SESSION['amount'];
    $test = $_POST['confirm'];

    if (isset($_POST['confirm'])) {
        $image = $_FILES['image']['name'];
        $status = "Checking"; //status รอตรวจสอบการชำระเงิน
        $total_price = $row['unit_price']*$amount;
        // Insert Data to Database : Payment Table
        $sql = "INSERT INTO payment (`status`,transaction_image ,total_price)
                VALUES ('$status', '$image', '$total_price')";
        if (($conn->query($sql) === TRUE)) {
            echo '<script language="javascript">';
            echo 'alert("success!")';
            echo '</script>';
        }
    }
    if (isset($_POST['later'])){
        $status = "Waiting"; //status สำหรับรอการจ่ายเงิน
        $total_price = $row['unit_price']*$amount;
        // Insert Data to Database : Payment Table
        $sql = "INSERT INTO payment (`status` ,total_price)
                VALUES ('$status', '$total_price')";
        if (($conn->query($sql) === TRUE)) {
            echo '<script language="javascript">';
            echo 'alert("success!")';
            echo '</script>';
    }
}

?>