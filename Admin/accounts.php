<?php
include("functions.php");
if(isset($_SESSION["userId"])) {
	if(isLoginSessionExpired()) {
		header("Location:logout.php?session_expired=1");
	}
}
include('includes/header.php');
require_once("db.php");
$sql = "SELECT * FROM admin ORDER BY userid DESC";
$result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html>
<head>
<title>Cafe Maria</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	<center>
<form name="frmUser" method="post" action="">
<div style="width:500px;">
<div class="message"><?php if(isset($message)) { echo $message; } ?></div>
<div align="right" style="padding-bottom:5px;"><a href="addadmin.php" class="link"><img alt='Add' title='Add' src='images/add.png' width='15px' height='15px'/> Add User</a></div>
<table border="0" cellpadding="10" cellspacing="1" width="500" class="tblListForm">
	<tr class="tableheader">
<td align="center">Admin</td>
</tr>
<tr class="listheader">
<td>Username</td>
<td>First Name</td>
<td>Last Name</td>
<td>CRUD Actions</td>
</tr>
<?php
$i=0;
while($row = mysqli_fetch_array($result)) {
if($i%2==0)
$classname="evenRow";
else
$classname="oddRow";
?>
<tr class="<?php if(isset($classname)) echo $classname;?>">
<td><?php echo $row["userName"]; ?></td>
<td><?php echo $row["firstName"]; ?></td>
<td><?php echo $row["lastName"]; ?></td>
<td><a href="editadmin.php?userId=<?php echo $row["userId"]; ?>" class="link"><img alt='Edit' title='Edit' src='images/edit.png' width='15px' height='15px' hspace='10' /></a>  <a href="deleteadmin.php?userId=<?php echo $row["userId"]; ?>"  class="link"><img alt='Delete' title='Delete' src='images/delete.png' width='15px' height='15px'hspace='10' /></a></td>
</tr>
<?php
$i++;
}
?>
</table>
</form>
</div>
<br>
<?php
$sql = "SELECT * FROM staff ORDER BY userid DESC";
$result = mysqli_query($conn,$sql);
?>
<div>
	<center>
<form name="frmUser" method="post" action="">
<div style="width:500px;">
<div class="message"><?php if(isset($message)) { echo $message; } ?></div>
<div align="right" style="padding-bottom:5px;"><a href="addstaff.php" class="link"><img alt='Add' title='Add' src='images/add.png' width='15px' height='15px'/> Add User</a></div>
<table border="0" cellpadding="10" cellspacing="1" width="500" class="tblListForm">
	<tr class="tableheader">
<td align="center">Staff</td>
</tr>
<tr class="listheader">
<td>Username</td>
<td>First Name</td>
<td>Last Name</td>
<td>CRUD Actions</td>
</tr>
<?php
$i=0;
while($row = mysqli_fetch_array($result)) {
if($i%2==0)
$classname="evenRow";
else
$classname="oddRow";
?>
<tr class="<?php if(isset($classname)) echo $classname;?>">
<td><?php echo $row["userName"]; ?></td>
<td><?php echo $row["firstName"]; ?></td>
<td><?php echo $row["lastName"]; ?></td>
<td><a href="editstaff.php?userId=<?php echo $row["userId"]; ?>" class="link"><img alt='Edit' title='Edit' src='images/edit.png' width='15px' height='15px' hspace='10' /></a>  <a href="deletestaff.php?userId=<?php echo $row["userId"]; ?>"  class="link"><img alt='Delete' title='Delete' src='images/delete.png' width='15px' height='15px'hspace='10' /></a></td>
</tr>
<?php
$i++;
}
?>
</table>
</form>
</div>
</div>
</body></html>
