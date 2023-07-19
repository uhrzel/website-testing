<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
include "conn.php";
if (isset($_GET['submit'])) {
    $username = $_GET['username'];
    $password = $_GET['password'];
    $sql = "INSERT INTO login(username, password)VALUES('$username','$password')";
    if ($conn->query($sql)) {
        header('location: index.html');
    } else {
        echo '<script>alert("Cannot be login")</script>';
    }
}
?>

<body>
    <center>
        <div class="container">
            <div class="form">
                <form action="" method="get">
                    <div class="label">
                        <label for="username">username</label>
                    </div>
                    <div class="input">
                        <input type="text" name="username" placeholder="Username or Email Address" required>
                    </div>
                    <div class="label">
                        <label for="password">password</label>
                    </div>
                    <div class="input">
                        <input type="text" name="password" placeholder="password" required>
                    </div>
                    <button name="submit">submit</button>
                </form>

            </div>
        </div>
    </center>
</body>

</html>