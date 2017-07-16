<?php
session_start();


if (isset($_POST['submit'])) {



    $connection = include('db.php');

    $username = $_POST['user'];
    $password = $_POST['pass'];


    $query = $connection->prepare("SELECT * FROM users WHERE usr_name = ?");
    $query->bind_param('s', $username);



    $query->execute();
    $row = $query->get_result();




    if ($row->num_rows > 0) { // user exists, now check the password.

        $row = $row->fetch_assoc();

        $hash = $row["usr_pass_hash"];



        if (password_verify($password, $hash)) { // successful login, or hacked :D
            $_SESSION["error"] = false;
            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = $username;
            $_SESSION["userid"] = $row["id"];
            echo("pass correct");


            header("Location: " . (
                isset($_SESSION['redirect']) ? $_SESSION['redirect'] : "index.php"));

            exit ();

        } else {
            $_SESSION["log-error"] = true; //I won't say which :P
        }
    }


}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php
if (isset($_SESSION['message'])) {

    print '<p>' . htmlentities($_SESSION['message']) . '</p>';
    unset($_SESSION['message']);
}
?>
<div class="container">
    <div class="row vertical-center">
        <div class="col-md-4 col-md-offset-4 text-center">
            <h3>Welcome</h3>
            <form method="post">
                <div class="input-group">
                    <input type="text" id="user" name="user" class="form-control" placeholder="user name" required>
                    <input type="password" id="pass" name="pass" class="form-control" placeholder="Password" required>
                    <input type="submit" id="submit" name="submit" class="form-control" value="Submit">
                </div>
            </form>
            <?php if (isset($_SESSION['log-error']) && $_SESSION['log-error']): ?>
                <div class="form-errors">

                    <p>Unknown username or password! </p>

                </div>
            <?php endif; ?>
            <a href="sign-up.php">sign up</a>
        </div>
    </div>
</div>
</body>

</html>