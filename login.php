<?php 
include('server.php');

$random = rand(1000,9999);

if (isset($_SESSION['username'])) {
	header('location: index.php');
}
if (isset($_POST['login_user'])) {
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);
	
	$captcha = $_REQUEST['captcha'];
	$captchacheck = $_REQUEST['captcha-check'];
	

	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	if (empty($captcha) || $captcha != $captchacheck ) { //captcha check
		array_push($errors, "Wrong Captcha");
	}
  
	if (count($errors) == 0) {
		$query = "SELECT * FROM users WHERE username='$username'";
		$results = mysqli_query($db, $query); //thực hiện truy vấn db

		if (mysqli_num_rows($results) == 1) {
			$check = mysqli_fetch_assoc($results); //mysqli_fetch_assoc: trả về kết quả của 1 truy vấn sql
				if (password_verify($password,$check['password'])) {
					$_SESSION['username'] = $username;
					$_SESSION['password'] = $password;
					$_SESSION['success'] = "You are now logged in";
					$_SESSION['role'] = $check['role'];
					$_SESSION['balance'] = $check['balance'];
					header('location: index.php');
						
				}else {
		  			array_push($errors, "Wrong password");
				}
		}else {
			array_push($errors, "Wrong username/email");
		}
	}
}
//cookie set
if(!empty($_POST["remember"])) {
	setcookie ("username",$_SESSION["username"],time()+ 3600); //expire time = 1h
	setcookie ("password",$_SESSION["password"],time()+ 3600);
} 

  
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
  <div class="header">
  	<h2>Login</h2>
  </div>
 	<!-- notification message -->
  <!-- <div class='special'>
	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success'	]);
          ?>
      	</h3>
      </div>
	<?php endif ?> 
  </div> -->

  <form method="post" action="login.php">
  	<?php include('noti.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>">
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">
  	</div>
	<!-- captcha -->
	<div class="input-group captcha-code">
		<label>Enter Captcha</label>
		<input type='text' name="captcha"> 
	</div>
	<div class="input-group captcha-code">
		<label>Captcha code:</label>
		<input type="hidden" name="captcha-check" value="<?php echo $random;//lưu random vào $_session?>"> 
		<div class="captcha-ran" ><?php echo $random;?></div>  
	</div>
  	<div class="input-group">
	<!-- captcha -->
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
	<div class="check">
		<input type='checkbox' name='remember'> Remember me
	</div>
	
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
  </form>
</body>
</html>