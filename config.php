<?php
$rootpath = "http://shop";

$hostname = "shop";
$username = "root";
$password = "";
$database = "shopdb";

$mysqli_conn = new mysqli($hostname, $username, $password, $database);

if ($mysqli_conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli_conn->connect_error;
    exit();
}

require_once("assets/config/dquerys.class.php");

$conn = new DBquery($mysqli_conn);

if(!isset($_SESSION)) {
    session_start();
}

//Set Defaults
if(!isset($_SESSION["admin"])){
    $_SESSION["admin"] = false;
}
if(!isset($_SESSION["adminuser"])){
    $_SESSION["adminuser"] = false;
}
if(!isset($_SESSION["cart"])){
    $_SESSION["cart"] = [];
}
if(!isset($_SESSION["lang"])){
    $_SESSION["lang"] = "en";
}

//Include Language File
require_once("assets/language/" . $_SESSION["lang"] . ".php");

//TODO: Language Support
//TODO: Cart Server Based (Stored in Session)
//TODO: STORY Site
//TODO: Admin Page add Product & List Products
//TODO: CSS Optimization