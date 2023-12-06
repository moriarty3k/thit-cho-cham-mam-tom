<?php
include('server.php');

$user_balance = $_SESSION['balance'];
$user = $_SESSION['username'];



if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
}
if (isset($_POST['money_recharge'])) {
    $cardnum = mysqli_real_escape_string($db, $_POST['card_num']);
    $query = "SELECT * FROM card WHERE cardnumber='$cardnum'";
    $result = mysqli_query($db, $query);
    $card =  mysqli_fetch_assoc($result);

  
    if (empty($cardnum)) { 
		array_push($errors, "Card number is required");
    }
    if (!isset($card['cardnumber'])) {
        array_push($errors, "Invalid card number");
    }
   
    
    if (count($errors) == 0) {
        if ($card['state'] == 0) {
            $user_balance = $_SESSION['balance'] + $card['cardvalue'];
            
            $query1 = "UPDATE users SET balance='$user_balance' WHERE username='$user'";
            mysqli_query($db, $query1);
            $query2 = "UPDATE card SET state='1' WHERE cardnumber='$cardnum'";
            mysqli_query($db, $query2);

            $value = $card['cardvalue'];

            

            $_SESSION['success'] = "Recharge successfully $value bananas";

            header('location: index.php');
            unset($_SESSION['balance']);
            $_SESSION['balance'] = $user_balance; 
            
            // echo $user_balance;
            // echo $_SESSION['balance'];
        } else {
            array_push($errors, "Card has been used!!");
        }
        
    }
    
}





?>
<!DOCTYPE html>
<html>
<head>
  <?php include('navbar.php')?>
  <title>Money Recharge</title>
  <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
  <div class="header">
  	<h2>Money Recharge</h2>
  </div>
  <form method="post" action="recharge.php">
  	<?php include('noti.php'); ?>
    <p> Your balance is: <b><?php echo $user_balance; ?></b> banana(s) </p>
  	<div class="input-group">
  		<label>Card number</label>
  		<input type="text"  onkeypress="return /[0-9]/i.test(event.key)" name="card_num">
  	</div>
    <!-- captcha 
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
	 captcha -->
  	<div class="input-group">
  		<button type="submit" class="btn" name="money_recharge">Recharge</button>
  	</div>
    

  </form>
</body>
</html>