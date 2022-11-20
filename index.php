<?php 

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
			<?php if (isset($_COOKIE['username']) && $_COOKIE['username']==$_SESSION['username']) {
						echo  'hello again!';
							} else {
						echo 'no cookie 4 u';
					}
			?>
 
    <?php endif ?>
</div>

</body>
</html>