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
$username = $_SESSION['username'];



if (isset($_POST['submit'])) {
    // Retrieve the old and new passwords from the form
    $current_password = $_POST['current-password'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];
    $query = "SELECT * FROM users WHERE username='$username '";
    $results = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($results);
    if ($new_password == $confirm_password) {
        array_push($errors, "Invalid card number");
        echo $new_password;
      }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<?php include('navbar.php'); ?>
<div class="header">
	<h2>Change Password</h2>
</div>

<form action="change-password.php" method="post">

    <?php include('noti.php'); ?>


    <div class="input-group">
        <label>Current Password:</label>
        <input type="password" name="current-password" id="current-password" required>
    </div>
    <div class="input-group">
        <label>New Password:</label>
        <input type="password" name="new-password" id="new-password" required>
    </div>
    <div class="input-group">
        <label>Confirm Password:</label>
        <input type="password" name="confirm-password" id="confirm-password" required>
    </div>
    
    <input class='btn' type="submit" value="Change Password">
</form>