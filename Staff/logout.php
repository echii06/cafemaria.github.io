<?php
session_start();
require_once 'php_action/core.php';
unset($_SESSION["userId"]);
unset($_SESSION["userName"]);
$url = "index.php";
if(isset($_GET["session_expired"])) {
	$url .= "?session_expired=" . $_GET["session_expired"];
}
header("Location:$url");
?>