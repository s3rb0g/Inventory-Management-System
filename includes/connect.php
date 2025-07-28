<?php

$db_server  = "localhost";
$db_user    = "root";
$db_pass    = "Qwerty12345";
$db_name    = "system_template";

global $db_conn;
$db_conn = "";

$db_conn = new mysqli($db_server, $db_user, $db_pass, $db_name);
if ($db_conn->connect_error) {
    die("Connection failed: " . $db_conn->connect_error);
}
