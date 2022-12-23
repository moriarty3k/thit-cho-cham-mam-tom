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
    $current_password = $_POST['current-password'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];
    $query = "SELECT * FROM users WHERE username='$username '";
    $results = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($results);
    if ($new_password != $confirm_password) {
        $_SESSION['error'] = "The new password and confirmation do not match";
    }
    if ($current_password == $new_password) {
        $_SESSION['error'] = "The current password and confirmation do not match";
    }
    if (password_verify($current_password,$user['password'])) {
        $password = password_hash($new_password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = '$password' WHERE username = '$username'";
            mysqli_query($db, $query);
            $_SESSION['success'] = "Change password successfully";
        header('location:profile.php');
    } else {
        $_SESSION['error'] = "The current password do not match";
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

<form method="post" action="change-password.php">
    <!-- notification message -->
	<?php if (isset($_SESSION['success'])) : ?>
      <div class=" success" >
      	<p>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</p>
      </div>	
  	<?php endif ?>
	  <?php if (isset($_SESSION['error'])) : ?>
      <div class="error" >
      	<p>
          <?php 
          	echo $_SESSION['error']; 
          	unset($_SESSION['error']);
          ?>
      	</p>
      </div>
  	<?php endif ?>

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
    <div class="input-group">
  		<button class='btn' type="submit" name="submit">Change Password</button>
  	</div>
    
</form>