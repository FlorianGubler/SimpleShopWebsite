<?php
$rootpath = "http://shop";
$pathname = "/";

$hostname = "shop";
$username = "root";
$password = "";
$database = "shopdb";

$mysqli_conn = new mysqli($hostname, $username, $password, $database);

if ($mysqli_conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli_conn->connect_error;
    exit();
}

require_once("assets/dbquerys/dquerys.class.php");

$conn = new DBquery($mysqli_conn);

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_GET["sessclr"]) && $_GET["sessclr"] == "true"){
    $_SESSION = [];
}

//Set Defaults
if(!isset($_SESSION["admin"])){
    $_SESSION["admin"] = false;
    $_SESSION["adminid"] = null;
    $_SESSION["adminuser"] = false;

} else if($_SESSION["admin"]){
    $_SESSION["adminuser"] = $conn->getUserData($_SESSION["adminid"]);
}
if(!isset($_SESSION["cart"])){
    $_SESSION["cart"] = [];
}
if(!isset($_SESSION["lang"])){
    $_SESSION["lang"] = "en";
}

//Include Language File
$texte = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . $pathname .  "assets/language/" . $_SESSION["lang"] . ".json"));

//TODO: Payment