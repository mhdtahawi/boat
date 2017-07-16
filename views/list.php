<?php

require_once ("header.php");

if (!isset($_SESSION['loggedin']))  {
    $_SESSION['redirect'] = "index.php";
    header("Location: ../log-in.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="css/main.css">
    <title>
        <?php print htmlentities($title) ?>
    </title>
</head>
<body>
<?php
site_header();
if ( isset($_SESSION['message'] ) ){

        print '<p>'.htmlentities($_SESSION['message']).'</p>';
        unset($_SESSION['message']);
}

?>
<div class="jumbotron">
    <h2 class="text-center">Your boats</h2>
<div class="container">
<?php
boat_table_header();
$even = false;
foreach  ($rows as $row) {

    boat_item($row[ "id"], $row["length"], $row["type_name"], $row["propulsion_name"], $even);

    $even = !$even;

}
?>
    <ul id = "pagination">
        <?php if ($has_prev):?>
        <li><a href="<?php echo ($prev_link) ?>">prev</a></li>
        <?php endif; if ($has_next):?>
        <li><a href="<?php echo ($next_link) ?>" >next</a></li>
        <?php endif; ?>
    </ul>
</div>
</div>

</body>


</html>
