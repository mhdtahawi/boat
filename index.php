<?php

require("controller/BoatController.php");


session_start();



$controller = new BoatController(new Boat());

if (isset($_SESSION['loggedin'])) {

    $action = $_GET['action'] ?? null;

    switch ($action) {

        case "delete":
            $controller->delete();
            break;

        case "update":
            $controller->update();
            break;

        case "create":
            $controller->create();

            break;
        case "read":
        default:
            $controller->list_all($_SESSION['userid']);
    }


} else {
    $_SESSION['redirect'] = "index.php";
    header("Location: log-in.php");
    exit();

}
