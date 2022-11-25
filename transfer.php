<?php 
include('server.php');
//session_start();	
$user_balance = $_SESSION['balance'];
$random = rand(1000,9999);


if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
} 
if (isset($_POST['money_trans'])) {
  
  $captcha = $_REQUEST['captcha'];
  $captchacheck = $_REQUEST['captcha-check'];

    $receiver = mysqli_real_escape_string($db, $_POST['receiver']);
    $amount = mysqli_real_escape_string($db, $_POST['amount']);
    $username = $_SESSION['username'];

    $user_check_query = "SELECT * FROM users WHERE username='$receiver' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user =  mysqli_fetch_assoc($result);

    if (empty($receiver)) {
		array_push($errors, "Receiver is required");
	}
    if (empty($amount)) {
		array_push($errors, "Amount is required");
	}
    if ($amount > $_SESSION['balance'] || $_SESSION['balance'] == 0){
        array_push($errors, "Not enough banana");
  }
    if ($username == $user['username']) {
        array_push($errors, "User Error!!");
  }
  if (empty($captcha) || $captcha != $captchacheck ) { //captcha check
		array_push($errors, "Wrong Captcha");
	}
    if (count($errors) == 0) {
        $receiver_balance = $user['balance'] + $amount;
        $user_balance = $_SESSION['balance'] - $amount;
		    
        $query1 = "UPDATE users SET balance='$receiver_balance' WHERE username='$receiver'";
 	  	    mysqli_query($db, $query1);
        $query2 = "UPDATE users SET balance='$user_balance' WHERE username='$username'";
 	  	    mysqli_query($db, $query2);
    
        $_SESSION['success'] = "Transfer Successfully";
  	    header('location: index.php');
        unset($_SESSION['balance']);
        $_SESSION['balance'] = $user_balance;      
  }
    
    
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Money Transfer</title>
  <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
  <div class="header">
  	<h2>Money Transfer</h2>
  </div>
  <form method="post" action="transfer.php">
  	<?php include('noti.php'); ?>
    <p> Hello: <b><?php echo $_SESSION['username']; ?></b> </p>
    <p> Your balance is: <b><?php echo $user_balance; ?></b> banana </p>
  	<div class="input-group">
  		<label>Receiver</label>
  		<input type="text" name="receiver">
  	</div>
  	<div class="input-group">
  		<label>Amount</label>
  		<input type="text" name="amount" onkeypress="return /[0-9]/i.test(event.key)">
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
    <!-- captcha -->
  	<div class="input-group">
  		<button type="submit" class="btn" name="money_trans">Send</button>
  	</div>
    <p> <a href="index.php" style="color: blue;">home page</a> </p>
    <p> <a href="recharge.php" style="color: green;">money recharge</a> </p>

  </form>
</body>
</html>