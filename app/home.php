<?php
    session_start();
    
    if (!$_SESSION['username']){
        header("Location: index.php");
    }else{

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Home page!</h1>
    <h3>สวัสดีคุณ <?php echo $_SESSION['name']; ?></h3>
    <h1>User : <?php echo $_SESSION['username']; ?></h3>
    <a href="logout.php" class="btn btn-info" role="button">Log out</a>
</body>
</html>

    <?php } ?>