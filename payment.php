<?php 
include('server.php');
if (!isset($_SESSION['username'])) {
    header('location:login.php');
}
if (!isset($_SESSION['username'])) {
    header('location:login.php');
}

echo $_SESSION['username'];
echo $_SESSION['balance'];
echo $_SESSION['price'];





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
    <div>
    <form method="post" action="payment.php">
    </form>
    </div>
</body>
</html>