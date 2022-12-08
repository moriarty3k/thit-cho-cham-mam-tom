<?php 
include('server.php');
if (!isset($_SESSION['username'])) {
    header('location:login.php');
}
if (!isset($_SESSION['cart_item'])) {
    header('location:product.php');
}
if (isset($_POST['pay'])) {
    $query1 = "UPDATE users SET balance='$user_balance' WHERE username='$user'";
            mysqli_query($db, $query1);
    //header('location:index.php');
}




?>
<!DOCTYPE html>
<html>
<head>
    <?php include('navbar.php') ?>
    <title>Payment</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
    <div class="header">
  	    <h2>Payment</h2>
    </div>
   
    
    <form method="post" action="payment.php">
        <?php  if (isset($_SESSION['username'])) : ?>
            <p>
                Welcome 
                <b><?php echo $_SESSION['username']; ?></b>
            </p>
            <p>
                You are: 
                <b><?php echo $_SESSION['role']; //role check ?> </b>
            </p>	
            <p>
                Your balance is: 
                <b><?php echo $_SESSION['balance']; //balance check ?> </b> banana(s)
            </p>
            <p>
                You need to pay: 
                <b style="color:red"><?php echo $_SESSION['price'];?> </b> banana(s)
            </p>
            <div class="input-group">
                <button type="submit" class="btn" name="pay">Pay</button>
            </div>
        <?php endif ?>
        
    </form>
   
    
</body>
</html>