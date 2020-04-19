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
    $username = $_SESSION["username"];
    $recieve = $_POST["recieve"]; //recieve date
    $id = $_SESSION["id"];

    date_default_timezone_set("Asia/Bangkok");
    $dt = date("Y-m-d H:i:s");

    
    if (isset($_POST['confirm']) && ($recieve)) {   //ตรวจสอบการกดปุ่ม confirm
        if($recieve < date("Y-m-d", strtotime('+7 day')) && $recieve > date("Y-m-d", strtotime('today'))){ //ตรวจสอบวันที่ระบุ ต้องอยู่ภายใน 7 วันนับจากวันที่สั่ง
            $image = $_FILES['image']['name'];
            if ($image != ""){   //เช็คว่ามีการอัพโหลดรูปภาพ
                // Path to store the uploaded image
                $target = "receipt/".basename($_FILES['image']['name']);

                $status = "checking"; //status รอตรวจสอบการชำระเงิน
                // Insert Data to Database : Payment Table
                $sql = "INSERT INTO payment (`status`, transaction_image, transaction_time, total_price)
                        VALUES ('$status', '$image', '$dt', '$total_price')";
                $result = (($conn->query($sql) === TRUE) && (move_uploaded_file($_FILES['image']['tmp_name'], $target)));
                    
                $sql1 = "INSERT INTO `order` (customer_user_username, recieve_date, product_product_id)
                         VALUES ('$username', '$recieve', $id)";
                $result1 = ($conn->query($sql1) === TRUE);
                    
                if($result && $result1){
                    echo "<script>
                    alert('Successful!');
                    window.location='home.php';
                    </script>";
                }else{
                    echo "<script>
                    alert('Error!');
                    window.location='home.php';
                    </script>";
                }


            }else{      //กรณีไม่ได้แนบรูปภาพ
                echo "<script>
                alert('ไม่ได้แนบรูปภาพ');
                window.location='home.php';
                </script>";
            }
        }else{
        echo "<script>
        alert('ระบุวันรับสินค้าไม่ถูกต้อง');
        window.location='home.php';
        </script>";
        }
    }else{
        echo "<script>
        alert('กรุณาระบุวันรับสินค้า');
        window.location='home.php';
        </script>";
    }
    
    // Close Connection
    $conn->close();
?>
