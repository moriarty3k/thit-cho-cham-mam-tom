<?php 
include('server.php');
//include('remember.php');
//include('access.php');



if (isset($_POST['login_user'])) {
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);
  
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}
  
	if (count($errors) == 0) {
		$query = "SELECT * FROM users WHERE username='$username'";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) {
			$check = mysqli_fetch_assoc($results); //mysqli_fetch_assoc: trả về kết quả của 1 truy vấn sql
				if (password_verify($password,$check['password'])) {
					$_SESSION['username'] = $username;
					$_SESSION['password'] = $password;
					$_SESSION['success'] = "You are now logged in";
					$_SESSION['role'] = $check['role'];
					header('location: index.php');
						
				}else {
		  			array_push($errors, "Wrong password");
				}
		}else {
			array_push($errors, "Wrong username/email");
		}
	}
	if(!empty($_POST["remember"])) {
		setcookie ("username",$_SESSION["username"],time()+ 3600);
		setcookie ("password",$_SESSION["password"],time()+ 3600);
	} 

}


  
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>">
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
	<div class="checkbox">
		<input type='checkbox' name='remember'>
		<label>Remember me</label>	
	</div>
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
  </form>
</body>
</html>