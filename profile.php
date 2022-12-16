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
$query = "SELECT * FROM users WHERE username='$username '";
$results = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($results);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css">
    
<body>
<?php include('navbar.php'); ?>
<div class="header">
	<h2>Profile</h2>
</div>
<div class="content" >
    <img class='avt' src="/user-img/<?php echo $user['image']?>">
    <p>
		Welcome 
		<b><?php echo $user['username']; ?></b>
	</p>
    <p>
		You are:   
		<b><?php echo $user['role']; ?></b>
	</p>
    <p>
		Your email address:   
		<b><?php echo $user['email']; ?></b>
	</p>
    <?php if($user['role'] == 'user'){?>
        <a href='upgrade.php' >Buy VIP</a>
    <?php } ?>
</div>