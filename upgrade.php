<?php 
include('server.php');
if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}

$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username='$username '";
$results = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($results);
if ($user['role'] == 'vip') {
    $_SESSION['error'] = 'You are already VIP';
    header('location:index.php');
} else if ($user['role'] == 'admin') {
    $_SESSION['success'] = 'You are admin';
    header('location:index.php');
}
if (isset($_POST['upgrade'])) {
    if($user['balance'] < 5000 ){
        $_SESSION['error'] = 'Not enough money!';
        header('location:index.php');
    } else {
        $new_balance = $user['balance'] - 5000;
        $query1 = "UPDATE users SET balance='$new_balance' WHERE username='$username '";
                mysqli_query($db, $query1);
        $query2 = "UPDATE users SET role='vip' WHERE username='$username '";
                mysqli_query($db, $query2);
        $_SESSION['success'] = 'Upgrade successful!';
        header('location:index.php');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('navbar.php') ?>
    <title>Upgrade</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
    <div class="header">
  	    <h2>Upgrade</h2>
    </div>
   
    
    <form method="post" action="upgrade.php">
        <?php  if (isset($_SESSION['username'])) : ?>
            <p>
                Welcome 
                <b><?php echo $_SESSION['username']; ?></b>
            </p>
            <p>
                You are: 
                <b><?php echo $user['role']?> </b>
            </p>	
            <p>
                Your balance is: 
                <b><?php echo $user['balance']; //balance check ?> </b> banana(s)
            </p>
            <p>
                You need to pay: 
                <b style="color:red"> 5000 bananas </b> 
                to become VIP!!
            </p>
            <div class="input-group">
                <button type="submit" class="btn" name="upgrade">Upgrade account</button>
            </div>
        <?php endif ?>
        
    </form>
   
    
</body>
</html>