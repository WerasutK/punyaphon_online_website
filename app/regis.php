<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <title>Register System</title>
</head>

<body>
    <div class="container mt-4">
        <h1>Register Member</h1>
        <hr>
        <form action="regis.php" method="POST">
            <div class="form-group">
                <label for="firstname">First name :</label>
                <input type="text" class="form-control" id="firstname" name="firstname" minlength='2' pattern="[A-Za-z]{2,}|[ก-๙]{2,}" title="Must be Thai / Eng language and contain at least 2 characters" required>
            </div>
            <div class="form-group">
                <label for="lastname">Lastname :</label>
                <input type="text" class="form-control" id="lastname" name="lastname" minlength='2' pattern="[A-Za-z]{2,}|[ก-๙]{2,}" title="Must be Thai / Eng language and contain at least 2 characters" required>
            </div>
            <div class="form-group">
                <label for="username">Username :</label>
                <input type="text" class="form-control" id="username" name="username" pattern="[A-Za-z0-9]{1,}" required>
            </div>
            <div class="form-group">
                <label for="password">Password :</label>
                <input type="password" class="form-control" id="password" name="password" pattern=".{6,}" title="Must contain at least 6 characters" required>
            </div>
            <!-- <div class="form-group">
                <label for="repeat-password">Repeat-Password :</label>
                <input type="password" class="form-control" id="repeat-password" name="repeat-password" require>
            </div> -->
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="address">Address :</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="form-group">
                <label for="phone1">Phone Number :</label>
                <input type="tel" class="form-control" id="phone1" name="phone1" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" title="Only 10 numbers"
                    required>
            </div>
            <div class="form-group">
                <label for="phone2">Phone Number (Optional) :</label>
                <input type="tel" class="form-control" id="phone2" name="phone2" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" title="Only 10 numbers">
            </div>
            <button type="submit" class="btn btn-primary" name="register">Register</button>
            <br><br>
            <p>I have an acoount. Let me <a href="login.php">Log in</a>.</p>
        </form>
    </div>

    <?php
        
        if (isset($_POST['register'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            // $repeatPass = $_POST['repeat-password'];
            $hashed_pass = hash('sha512', $password);
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $phone1 = $_POST['phone1'];
            $phone2 = $_POST['phone2'];
            $address = $_POST['address'];
            $type = 'customer';

            // Create Connection
            $conn = new mysqli("34.87.109.220", "werasutk", "password", "db");
            $conn1 = new mysqli("34.87.109.220", "werasutk", "password", "db");

            // Check Connection
            if ($conn->connect_error) {
                die("Connection Failed: " . $conn->connect_error);
            }
            if ($conn1->connect_error) {
                die("Connection Failed: " . $conn1->connect_error);
            }

            // Check username
            $sql = "SELECT * FROM user WHERE username='$username'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<script language="javascript">';
                echo 'alert("This username is alread exist!")';
                echo '</script>';
                return 0;
            }

            // Insert Data
            $sql = "INSERT INTO user (username, `password`, firstname, lastname, email, phone1, phone2, `type`)
                    VALUES ('$username', '$hashed_pass', '$firstname', '$lastname', '$email', '$phone1', '$phone2', '$type')";
            $sql1 = "INSERT INTO customer (user_username, `address`)
                     VALUES ('$username', '$address')";

            if (($conn->query($sql) === TRUE) && ($conn1->query($sql1) ===TRUE )) {
                echo '<script language="javascript">';
                echo 'alert("You registered success!")';
                echo '</script>';
            } elseif ($conn->query($sql) === TRUE) {
                echo ("Error: " . $sql1 . "<br>" . $conn1->error);
            } else {
                echo ("Error: " . $sql . "<br>" . $conn->error);
                echo ("Error: " . $sql1 . "<br>" . $conn1->error);
            }

            // Close Connection
            $conn->close();
            $conn1->close();
        }

    ?>
</body>

</html>