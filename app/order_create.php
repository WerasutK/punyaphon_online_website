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
    $quantity = $_SESSION["amount"];

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

                $sql1 = "SELECT payment_id FROM payment ORDER BY payment_id DESC limit 1";
                $result1 = $conn->query($sql1);
                $row = mysqli_fetch_array($result1);
                $payment_id = $row['payment_id']; #ดึงมา insert ใน order
    
                $sql2 = "INSERT INTO `order` (customer_user_username, recieve_date, payment_payment_id, product_product_id, quantity)
                         VALUES ('$username', '$recieve',$payment_id, $id, $quantity)";
                $result2 = ($conn->query($sql2) === TRUE);

                $status_history = "preparing";
                $sql3 = "INSERT INTO `history` (`datetime`, `status_history`)
                VALUES ('$dt','$status_history')";
                $result3 = ($conn->query($sql3) === TRUE);

                $sql4 = "SELECT history_id FROM history ORDER BY history_id DESC LIMIT 1";
                $result4 = $conn->query($sql4);
                $row = mysqli_fetch_array($result4);
                $history_id = $row['history_id'];

                $sql5 = "UPDATE `order` SET `history_history_id`= $history_id 
                WHERE payment_payment_id=$payment_id";
                $result5 = ($conn->query($sql5) === TRUE);

                $sql6 = "SELECT `amount` FROM product WHERE product_id = $id";
                $result6 = $conn->query($sql6);
                $row = mysqli_fetch_array($result6);
                $amount = $row['amount']; #ดึง amount

                $total_amount = $amount - $quantity;
                $sql7 = "UPDATE `product` SET `amount`= $total_amount
                WHERE product_id=$id";
                $result7 = ($conn->query($sql7) === TRUE);

                if($result7){
                    echo "<script>
                    alert('Successful!');
                    window.location='history_cust.php';
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
