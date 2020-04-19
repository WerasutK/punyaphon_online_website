<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style_login.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


    <title>Login Page</title>
</head>

<body>
<center><img src="images/Logo.png" style="width:700px;height:250px;"></center>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3 style="color: black;">Log in</h3>
			</div>
			<div class="card-body">
				<form action="login.php" method="POST">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" name="username" class="form-control" placeholder="username">
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" name="password" class="form-control" placeholder="password">
					</div>
					<div class="form-group">
						<center> 
                            <input type="submit" name="login" value="Login" style="margin-top: 20px" class="btn btn-outline-dark">
                        </center>
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					Don't have an account?<a href="regis.php">Register</a>
				</div>
			</div>
		</div>
	</div>
</div>
<footer></footer>


    <?php

        session_start();
        
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashed_pass = hash('sha512', $password);

            // Create Connection
            $conn = new mysqli("34.87.109.220", "werasutk", "password", "db");

            // Check Connection
            if ($conn->connect_error) {
                die("Connection Failed: " . $conn->connect_error);
            }

            // Check username
            $sql = "SELECT * FROM user WHERE username='$username' AND `password`='$hashed_pass'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_array($result);
                $_SESSION['name'] = $row['firstname'] . " " . $row['lastname']; //Session ชื่อของ Customer
                $_SESSION['username'] = $row['username'];
                header('Location: home.php');
            } else {
                $sql = "SELECT * FROM user WHERE username='$username' AND `password`='$password'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = mysqli_fetch_array($result);
                    $_SESSION['name'] = $row['firstname'] . " " . $row['lastname']; //Session ชื่อของ Staff
                    $_SESSION['username'] = $row['username'];
                    header('Location: staff.php');
                } else {
                    echo "<script language='javascript'>";
                    echo "alert('Incorrect username and password')";
                    echo "</script>";
                }
            }

            // Close Connection
            $conn->close();
        }

    ?>
</body>

</html>