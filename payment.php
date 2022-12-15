<?php 
include('server.php');
$discount = 0;


if (!isset($_SESSION['username'])) {
    $_SESSION['error'] = "You need to login first!";
    header('location:login.php');
}

if (!isset($_SESSION['cart_item'])) {
    header('location:product.php');
}

if ($_SESSION['balance']  < $_SESSION['price']) {
    $_SESSION['error'] = "You don't have enough money!";
    header('location:index.php');
    
} else {
    if (isset($_POST['pay'])) {
        $new_balance = $_SESSION['balance'] - $_SESSION['price'];
        $query1 = "UPDATE users SET balance='$new_balance' WHERE username=' ". $_SESSION['username'] ." '";
                mysqli_query($db, $query1);
        foreach($_SESSION['cart_item'] as $k=>$v){
            //$new_amount = $_SESSION["cart_item"][$k]["amount"] -  $_SESSION["cart_item"][$k]["quantity"];
            if($_SESSION["cart_item"][$k]['amount'] < $_SESSION["cart_item"][$k]["quantity"]){
                $new_amount = 0;
            } else {
                $new_amount = $_SESSION["cart_item"][$k]["amount"] -  $_SESSION["cart_item"][$k]["quantity"];
            }
            $code = $_SESSION["cart_item"][$k]["code"];
            $query1 = "UPDATE products SET amount='$new_amount' WHERE code='$code'";
                mysqli_query($db, $query1);
        }
        $_SESSION['balance'] = $new_balance;
        

        $_SESSION['success'] = "Successful Payment";
        unset($_SESSION['cart_item']);
        header('location:index.php');
    }
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
                <b><?php echo $_SESSION['role']?> </b>
            </p>	
            <p>
                Your balance is: 
                <b><?php echo $_SESSION['balance']; //balance check ?> </b> banana(s)
            </p>
            
            <p> Discount: 
                <b>
                    <?php 
                    
                    if($_SESSION['role'] = 'admin'){
                        $discount = 90/100;
                        echo '90%';
                    } else if ($_SESSION['role'] = 'vip'){
                        $discount = 30/100;
                        echo '30%';
                    } else {
                        $discount = 0;
                        echo '0%';
                    }
                    ?>
                </b>
            </p>
            
            <p>
                You need to pay: 
                <b style="color:red">
                <?php 
                    $_SESSION['price'] -= $_SESSION['price']*$discount; 
                    echo $_SESSION['price'];
                ?> 
                </b> banana(s)
            </p>
            <div class="input-group">
                <button type="submit" class="btn" name="pay">Pay</button>
            </div>
        <?php endif ?>
        
    </form>
   
    
</body>
</html>