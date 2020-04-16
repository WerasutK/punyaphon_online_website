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
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="form-group">
                <label for="lastname">Lastname :</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <div class="form-group">
                <label for="username">Username :</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password :</label>
                <input type="password" class="form-control" id="password" name="password" required>
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
                <label for="phone1">Phone Number :</label>
                <input type="tel" class="form-control" id="phone1" name="phone1" pattern="[0-9]{3}[0-9]{3}[0-9]{4}"
                    required>
            </div>
            <div class="form-group">
                <label for="phone2">Phone Number (Optional) :</label>
                <input type="tel" class="form-control" id="phone2" name="phone2" pattern="[0-9]{3}[0-9]{3}[0-9]{4}">
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
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $phone1 = $_POST['phone1'];
            $phone2 = $_POST['phone2'];
            $type = 'customer';

            // Create Connection
            $conn = new mysqli("34.87.109.220", "werasutk", "password", "db");

            // Check Connection
            if ($conn->connect_error) {
                die("Connection Failed: " . $conn->connect_error);
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
                    VALUES ('$username', '$password', '$firstname', '$lastname', '$email', '$phone1', '$phone2', '$type')";

            if ($conn->query($sql) === TRUE) {
                echo '<script language="javascript">';
                echo 'alert("You registered success!")';
                echo '</script>';
            } else {
                echo ("Error: " . $sql . "<br>" . $conn->error);
            }

            // Close Connection
            $conn->close();
        }

    ?>
</body>

</html>