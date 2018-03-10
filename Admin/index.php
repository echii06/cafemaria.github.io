<?php
require_once 'db.php';
session_start();

if(isset($_SESSION['userId'])){
    header('location:dashboard.php');
}
include("functions.php");
$message="";
$captcha = true;
if(count($_POST)>0 && isset($_POST["captcha_code"]) && $_POST["captcha_code"]!=$_SESSION["captcha_code"]) {
$captcha = false;
$message = "Enter Correct Captcha Code";
}
$mysqli = new mysqli('localhost','root','','cafemaria');    
$ip = $_SERVER['REMOTE_ADDR'];
$result = $mysqli->query("SELECT count(ip_address) AS failed_login_attempt FROM failed_login WHERE ip_address = '$ip'  AND date BETWEEN DATE_SUB( NOW() , INTERVAL 1 DAY ) AND NOW()");
$row  = $result->fetch_assoc();
$failed_login_attempt = $row['failed_login_attempt'];
$result->free();

if(count($_POST)>0 && $captcha == true) {
    $result = $mysqli->query("SELECT * FROM admin WHERE userName='" . $_POST["userName"] . "' and password = '". $_POST["password"]."'");
    $row  = $result->fetch_assoc();
    $result->free();
    if(is_array($row)) {
        $_SESSION["userId"] = $row["userId"];
        $_SESSION["userName"] = $row["userName"];
        $mysqli->query("DELETE FROM failed_login WHERE ip_address = '$ip'");
    } else {
        $message = "Invalid Username or Password!";
        if ($failed_login_attempt < 3) {
            $mysqli->query("INSERT INTO failed_login (ip_address,date) VALUES ('$ip', NOW())");
        } else {
            $message = "You have tried more than 3 invalid attempts. Enter captcha code.";
        }
    }
}

if(isset($_SESSION["userId"])) {
    if(!isLoginSessionExpired()) {
        header("Location:dashboard.php");
    } else {
        header("Location:logout.php?session_expired=1");
    }
}

if(isset($_GET["session_expired"])) {
    $message = "Login Session is Expired. Please Login Again";
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>

        <meta charset="utf-8">
        <title> Cafe Maria </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- CSS -->
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
        <link rel="stylesheet" href="assests/css/reset.css">
        <link rel="stylesheet" href="assests/css/supersized.css">
        <link rel="stylesheet" href="assests/css/style.css">
        <link rel="icon" href="assests/images/logo.jpg" type="image/x-icon">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>

    <body>

        <div class="page-container">
            <h1>Login</h1>
            <form name="frmUser" action="" method="post">
                <?php if($message!="") { ?>
<div class="message"><?php echo $message; ?></div>
<?php } ?>
                <input type="text" name="userName" class="username" placeholder="Username">
                <input type="password" name="password" class="password" placeholder="Password">
                <?php if (isset($failed_login_attempt) && $failed_login_attempt >= 2) { ?>
                <input name="captcha_code" type="text" placeholder="Captcha Code"><br><br><img src="captcha_code.php" />
                <?php } ?>
                <button type="submit">Sign me in</button>
                <div class="error"><span>+</span></div>
            </form>
            
        </div>

        <!-- Javascript -->
        <script src="assests/js/jquery-1.8.2.min.js"></script>
        <script src="assests/js/supersized.3.2.7.min.js"></script>
        <script src="assests/js/supersized-init.js"></script>
        <script src="assests/js/scripts.js"></script>

    </body>

</html>

