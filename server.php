
<?php

session_start();




// initializing variables
$username = "";
$email    = "";
$errors = array(); 
$success = array();


// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'wokwokwokwok'); 

class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "wokwokwokwok";
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
}
// REGISTER USER
// if (isset($_POST['reg_user'])) {
//   // receive all input values from the form
//   $username = mysqli_real_escape_string($db, $_POST['username']);
//   $email = mysqli_real_escape_string($db, $_POST['email']);
//   $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
//   $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);


//   // form validation: ensure that the form is correctly filled ...
//   // by adding (array_push()) corresponding error unto $errors array
//   if (empty($username)) { array_push($errors, "Username is required"); }
//   if (empty($email)) { array_push($errors, "Email is required"); }
//   if (empty($password_1)) { array_push($errors, "Password is required"); }
//   if ($password_1 != $password_2) {
// 	array_push($errors, "The two passwords do not match");
//   }

//   // first check the database to make sure 
//   // a user does not already exist with the same username and/or email
//   $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
//   $result = mysqli_query($db, $user_check_query); //thực hiện truy vấn từ database
//   $user = mysqli_fetch_assoc($result);
  
//   if ($user) { // if user exists
//     if ($user['username'] === $username) {
//       array_push($errors, "Username already exists");
//     }

//     if ($user['email'] === $email) {
//       array_push($errors, "email already exists");
//     }
//   }

//   // Finally, register user if there are no errors in the form
//   if (count($errors) == 0) {
//   	$password = password_hash($password_1, PASSWORD_DEFAULT);//encrypt the password before saving in the database
   

//   	$query = "INSERT INTO users (username, email, password) 
//   			  VALUES('$username', '$email', '$password')";
//   	mysqli_query($db, $query);
//   	$_SESSION['username'] = $username;
//   	$_SESSION['success'] = "You are now logged in";
    
//   	header('location: index.php');
//   }
// }

// LOGIN USER

// if (isset($_POST['login_user'])) {
//   $username = mysqli_real_escape_string($db, $_POST['username']);
//   $password = mysqli_real_escape_string($db, $_POST['password']);

//   if (empty($username)) {
//   	array_push($errors, "Username is required");
//   }
//   if (empty($password)) {
//   	array_push($errors, "Password is required");
//   }

//   if (count($errors) == 0) {
//   	$query = "SELECT * FROM users WHERE username='$username'";
//   	$results = mysqli_query($db, $query);
//   	if (mysqli_num_rows($results) == 1) {
//       $check = mysqli_fetch_assoc($results); //mysqli_fetch_assoc: trả về kết quả của 1 truy vấn sql
//       if (password_verify($password,$check['password'])) {
//   	    $_SESSION['username'] = $username;
//   	    $_SESSION['success'] = "You are now logged in";
//         $_SESSION['privileges'] = $check['rank'];
       

//   	    header('location: index.php');
//       }else {
//         array_push($errors, "Wrong password");
//       }
//   	}else {
//   		array_push($errors, "Wrong username/email");
//   	}
//   }
// }

// ?>