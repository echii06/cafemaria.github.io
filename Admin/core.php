<?php
require_once 'db.php';

echo $_SESSION['userId'];

if(!$_SESSION['userId']){
	header('Location: index.php');
}
?>