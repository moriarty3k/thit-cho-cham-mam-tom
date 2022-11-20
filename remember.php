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

