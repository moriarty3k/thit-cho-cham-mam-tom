<<<<<<< HEAD
<?php 

//include('access.php');
//include('remember.php');		
session_start();	

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="header">
	<h2>Home Page</h2>
</div>
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p><strong>Welcome </strong><?php echo $_SESSION['username']; print'. You are: ';echo $_SESSION['role']?></p>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>

</body>
=======
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
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<?php include('navbar.php'); ?>
<div class="header">
	<h2>Home Page</h2>
</div>

<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>	
  	<?php endif ?> 
	  <?php if (isset($_SESSION['error'])) : ?>
      <div class="error" >
      	<h3>
          <?php 
          	echo $_SESSION['error']; 
          	unset($_SESSION['error']);
          ?>
      	</h3>
      </div>	
  	<?php endif ?>

    <!-- logged in user information -->
	
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>
			Welcome 
			<b><?php echo $user['username']; ?></b>
		</p>
		<p>
			You are: 
			<b><?php echo $user['role']; //role check ?> </b>
		</p>	
		<p>
			Your balance is: 
			<b><?php echo $user['balance']; //balance check ?> </b> banana(s)
		</p>
		<?php if ($user['role'] == 'admin') { ?>
			<a href='admin.php'>
				Admin
			</a>
		<?php } ?>
 
    <?php endif ?>
</div>

</body>
>>>>>>> origin/cookies
</html>