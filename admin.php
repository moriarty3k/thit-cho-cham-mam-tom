<?php 
include('server.php');



if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
}
if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
}
if ($_SESSION['role'] != 'admin') {
    $_SESSION['msg'] = "You are not admin";
  	header('location: index.php');
}

echo "hello"




?>
<html>
<a href="index.php">Home</a>
</html>