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
</head>
<body>
    <h1>Staff Page</h1>
    <h3>สวัสดีคุณ <?php echo $_SESSION['name']; ?></h3>
    <a href="logout.php" class="btn btn-info" role="button">Log out</a>
</body>
</html>