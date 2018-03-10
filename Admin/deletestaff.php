<?php
include("functions.php");
if(isset($_SESSION["userId"])) {
	if(isLoginSessionExpired()) {
		header("Location:logout.php?session_expired=1");
	}
}
require_once("db.php");
$sql = "DELETE FROM staff WHERE userId='" . $_GET["userId"] . "'";
mysqli_query($conn,$sql);
header("Location:accounts.php");
?>