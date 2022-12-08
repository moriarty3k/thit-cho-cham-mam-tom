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





?>
<html>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>

<div class="header">
	<h2>Admin Page</h2>
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
    	<p>
			Welcome 
			<b><?php echo $_SESSION['username']; ?></b>
		</p>
		<p>
			You are: 
			<b><?php echo $_SESSION['role']; //role check ?> </b>
		</p>	
		<p>
			Your balance is: 
			<b><?php echo $_SESSION['balance']; //balance check ?> </b> banana(s)
		</p>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
		<p> <a href="transfer.php" style="color: blue;">money transfer</a> </p>
		<p> <a href="recharge.php" style="color: green;">money recharge</a> </p>
		<p> <a href="product.php" style="color: salmon;">shopping</a> </p>
			<!--cookie check, will delete!! -->
			
			
			<!-- <?php if (isset($_COOKIE['username']) && $_COOKIE['username']==$_SESSION['username']) { 
						echo  'hello again!';
							} else {
						echo 'no cookie 4 u';
					}
			?> -->
 
    <?php endif ?>
</div>

</body>
</html>
</html>