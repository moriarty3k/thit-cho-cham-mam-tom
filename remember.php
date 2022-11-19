<?php

if(!empty($_POST["remember"])) {
	setcookie ("username",$_SESSION["username"],time()+ 3600);
	setcookie ("password",$_SESSION["password"],time()+ 3600);
	echo "Cookies Set Successfuly";
} else {
	setcookie("username","");
	setcookie("password","");
	echo "Cookies Not Set";
}

?>

<p><a href="login.php"> Go to Login Page </a> </p>