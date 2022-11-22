<?php 
include('server.php');

if (isset($_POST['reg_user'])) {
	// receive all input values from the form
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
	$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
	$role = 'samuel';
	$balance = 0;
  
  
	// form validation: ensure that the form is correctly filled ...
	// by adding (array_push()) corresponding error unto $errors array
	if (empty($username)) { array_push($errors, "Username is required"); }
	if (empty($email)) { array_push($errors, "Email is required"); }
	if (empty($password_1)) { array_push($errors, "Password is required"); }
	if ($password_1 != $password_2) {
	  array_push($errors, "The two passwords do not match");
	}
  
	// first check the database to make sure 
	// a user does not already exist with the same username and/or email
	$user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
	$result = mysqli_query($db, $user_check_query); //thực hiện truy vấn từ database
	$user = mysqli_fetch_assoc($result);  //mysqli_fetch_assoc: trả về kết quả của 1 truy vấn sql
	


	if ($user) { // if user exists
	  if ($user['username'] === $username) {
		array_push($errors, "Username already exists");
	  }
  
	  if ($user['email'] === $email) {
		array_push($errors, "email already exists");
	  }
	}
  
	// Finally, register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = password_hash($password_1, PASSWORD_DEFAULT);//crypt_blowfish $2y$
   
		$query = "INSERT INTO users (username, email, password, role, balance) 
	   			  VALUES('$username', '$email', '$password', '$role', $balance)";
 	  	mysqli_query($db, $query);
 
		$_SESSION['username'] = $username;
		$_SESSION['role'] = $role;
		$_SESSION['success'] = "Successful Registration";
		$_SESSION['balance'] = $balance;

		header('location: index.php');
		
	}
  }
  
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>
	
  <form method="post" action="register.php">
  	<?php include('noti.php'); ?>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>