<?php
session_start();

session_destroy();

$sign_error = false;
if (isset($_POST['submit'])) {


    $connection = include('db.php');



    $username = $_POST['user'];
    $query = $connection->prepare("SELECT * FROM users WHERE usr_name=?");
    $query->bind_param('s', $username);
    $query->execute();
    $query->store_result();



    if ($query->num_rows > 0) {

        $sign_error = true;
        $error_message = "Username is already taken";
    }

    else {
        $fname = $_POST['first-name'];
        $lname = $_POST['last-name'];
        $pass = $_POST['pass'];
        $query->close();
        $q= $connection->prepare("INSERT INTO users (fname, lname, usr_name, usr_pass_hash) values (?,?,?,?)");
        var_dump($connection->error);
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $q->bind_param('ssss', $fname, $lname, $username, $hash);

        $q->execute();
        header("Location: index.php");



    }

/*
    $query = "SELECT * FROM users WHERE usr_name = ?";

    $query_result = $connection->query($query);


    if (mysqli_num_rows($query_result) == 1) { // user exists, now check the password.

        $row = $query_result->fetch_assoc();

        $hash = $row["usr_pass_hash"];

        if (password_verify($password, $hash)) { // successful login, or hacked :D
            $_SESSION["error"] = false;
            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = $username;
            $_SESSION["userid"] = $row["id"];


            header("Location: " . (
                isset($_SESSION['redirect']) ? $_SESSION['redirect'] : "index.php"));

            exit ();

        } else {
            $_SESSION["log-error"] = true; //I won't say which :P
        }
    }

*/
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Sign up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
<div class="container">
    <div class="row vertical-center">
        <div class="col-md-4 col-md-offset-4 text-center">
            <h3>Welcome</h3>
            <form method="post">
                <div class="input-group">
                    <input type="text" id="first-name" name="first-name" class="form-control" placeholder="First name"
                           required>
                    <input type="text" id="last-name" name="last-name" class="form-control" placeholder="Last name"
                           required>
                    <input type="text" id="user" name="user" class="form-control" placeholder="user name" required>
                    <input type="password" id="pass" name="pass" class="form-control" placeholder="Password" required>
                    <input type="password" id="pass_confirm" name="pass_confirm"
                           class="form-control" placeholder="Password" required>
                    <input type="submit" id="submit" name="submit" class="form-control" value="Submit">
                </div>
            </form>

            <?php if ($sign_error): ?>
                <div class="form-errors">
                    <p><?php echo($error_message); ?></p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<script>
    var password = document.getElementById("pass")
        , confirm_password = document.getElementById("pass_confirm");

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;

</script>
</body>

</html>