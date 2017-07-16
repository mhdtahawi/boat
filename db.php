<?php

$connection = new mysqli("localhost", "root", "","bms");

if (!$connection) {
    die("No connection to database");
}
return $connection;


