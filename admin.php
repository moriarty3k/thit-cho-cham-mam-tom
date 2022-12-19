
<?php 
include('server.php');


if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
}

if ($_SESSION['role'] != 'admin') {
    $_SESSION['msg'] = "You are not admin";
  	header('location: index.php');
} else {
	$_SESSION['success'] = 'Welcome admin';
}





?>
<html>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
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
		
 
    <?php endif ?>
</div>

</body>
</html>
</html>
