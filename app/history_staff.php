<?php

    session_start();

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
<div class="button-2" style="text-align:center;">
    <a href="staff.php" class="btn btn-outline-dark" role="button">Back</a>
<div>
<?php
    // Create Connection
    $conn = new mysqli("34.87.109.220", "werasutk", "password", "db");

    // Check Connection
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }
    $sql = "SELECT * 
    FROM `history` 
    INNER JOIN `order` 
    ON `history`.`history_id` = `order`.`history_history_id`
    INNER JOIN payment
    ON `order`.payment_payment_id = payment.payment_id
    INNER JOIN product
    ON `order`.product_product_id = product.product_id
    INNER JOIN `user`
    ON order.customer_user_username = `user`.`username`";
    
    $result = $conn->query($sql);

    date_default_timezone_set("Asia/Bangkok");
    $dt = date("Y-m-d");
    ?>
    <hr>
    <h2>ประวัติรายการสั่งซื้อ</h2>
    <hr>
    <table style="width:100%">
    <tr>
    <th>History ID</th>
    <th>Name</th>
    <th>Product</th>
    <th>Quantity</th>
    <th>Total Price</th>
    <th>Recieve Date</th>
    <th>Time Remaining</th>
    <th>Status</th>
    </tr>

    <?php
    while($row = $result->fetch_assoc()) { 
        $now = strtotime($dt);
        $mydate = strtotime($row['recieve_date']);
        $remain = ceil(($mydate - $now) / 86400);
        $status_history = $row['status_history'];?>
        <tr>
        <td><?php echo $row['history_id']; ?></td>
        <td><?php echo $row['firstname'] . " ". $row['lastname']; ?></td>
        <td><?php echo $row['product_name']; ?></td>
        <td><?php echo $row['quantity']; ?></td>
        <td><?php echo $row['total_price']; ?></td>
        <td><?php echo $row['recieve_date']; ?></td>
        <?php if (!($status_history === 'finished' || $status_history === 'problem')){
            echo '<td>' .$remain. '</td>'; 
        }else{
            echo '<td>-'; }?></td>

        <?php if ($status_history === 'preparing'){ ?>
            <td><form action="" method="POST">
            <button type='submit' class='btn btn-info px-4' style='margin-top:20px;' name='finished' value='<?php echo $row['history_id']; ?>'>Finished</button>
            </form>
        </td> <?php }else{
            echo '<td>'.$row['status_history'] . '</td>';
        } ?>
        </tr>
    <?php }

    if (isset($_POST['finished'])){
        $history_id = $_POST['finished'];
        $sql = "UPDATE history SET `status_history`='finished'
                WHERE `history`.`history_id`=$history_id";
        $result = ($conn->query($sql) === TRUE);
        if($result){
            echo "<script>
            alert('Successful!');
            window.location='history_staff.php';
            </script>";
        } else {
            echo "<script>
            alert('Error!');
            window.location='history_staff.php';
            </script>";         
        }
    }

        // Close Connection
        $conn->close();
    ?>
</body>
</html>