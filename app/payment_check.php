<?php

    //session_start();

    //if (!isset($_SESSION['username'])) {
    //    header('Location: login.php');
    //}

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
    $sql = "SELECT * FROM payment WHERE `status` ='checking'";
    $result = $conn->query($sql);
    echo '<table style="width:100%">';
    echo '<tr>';
    echo '<th>Payment ID</th>';
    echo '<th>Status</th>';
    echo '<th>Image</th>';
    echo '<th>Datetime</th>';
    echo '<th>Total Price</th>';
    echo '<th>Valid</th>';
    echo '<th>Invalid</th>';
    echo '</tr>';
    while($row = $result->fetch_assoc()) { ?>
        <tr>
        <td><?php echo $row['payment_id']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td><img src="receipt/<?php echo $row['transaction_image']; ?>" class='img' alt='' width='200' height></td>
        <td><?php echo $row['transaction_time']; ?></td>
        <td><?php echo $row['total_price']; ?></td>
        <td><form action="" method="POST">
            <button type='submit' class='btn btn-info px-4' style='margin-top:20px;' name='valid' value='<?php echo $row['payment_id']; ?>'>ผ่าน</button>
            </form>
        </td>
        <td><form action="" method="POST">
            <button type='submit' class='btn btn-info px-4' style='margin-top:20px;' name='invalid' value='<?php echo $row['payment_id']; ?>'>ไม่ผ่าน</button>
            </form>
        </td>
        </tr>
    <?php }
   
    $dt = date("Y-m-d H:i:s");

    if (isset($_POST['valid'])){
        $payment_id = $_POST['valid'];
        $sql = "UPDATE payment SET `status`='valid'
                WHERE payment_id=$payment_id";
        $result = ($conn->query($sql) === TRUE);

        $status = "preparing";

        $sql1 = "INSERT INTO `history` (`datetime`, `status`)
                VALUES ('$dt','$status')";
        $result1 = ($conn->query($sql1) === TRUE);

        $sql2 = "SELECT history_id FROM history ORDER BY history_id DESC LIMIT 1";
        $result2 = $conn->query($sql2);
        $row = mysqli_fetch_array($result2);
        $history_id = $row['history_id'];

        $sql3 = "UPDATE `order` SET `history_history_id`= $history_id 
                WHERE payment_payment_id=$payment_id";
        $result3 = ($conn->query($sql3) === TRUE);

        if($result3){
            echo "<script>
            alert('Successful!');
            window.location='payment_check.php';
            </script>";
        } else {
            echo "<script>
            alert('Error!');
            window.location='payment_check.php';
            </script>";         
        }


    }else if (isset($_POST['invalid'])){
        $payment_id = $_POST['invalid'];
        $sql = "UPDATE payment SET `status`='invalid'
                WHERE payment_id=$payment_id";
        $result = ($conn->query($sql) === TRUE);
        
        $status = "problem";

        $sql1 = "INSERT INTO `history` (`datetime`, `status`)
                VALUES ('$dt', '$status')";
        $result1 = ($conn->query($sql1) === TRUE);
        
        
        $sql2 = "SELECT history_id FROM history ORDER BY history_id DESC LIMIT 1";
        $result2 = $conn->query($sql2);
        $row = mysqli_fetch_array($result2);
        $history_id = $row['history_id'];

        $sql3 = "UPDATE `order` SET history_history_id=$history_id 
                WHERE payment_payment_id=$payment_id";
        $result3 = ($conn->query($sql3) === TRUE);

        if($result3){
            echo "<script>
            alert('Successful!');
            window.location='payment_check.php';
            </script>";
        } else {
            echo "<script>
            alert('Error!');
            window.location='payment_check.php';
            </script>";         
        }
    }


    // Close Connection
    $conn->close();
    ?>
</body>
</html>

