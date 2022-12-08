<?php
include("server.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
        case "add":
            if(!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM products WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
                
                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                                if($productByCode[0]["code"] == $k) {
                                    if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                        $_SESSION["cart_item"][$k]["quantity"] = 0;
                                    }
                                    $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                                    header('location:product.php');
                                }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                        header('location:product.php');
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                    header('location:product.php');
                } 
            }
        break;
        case "remove":
            if(!empty($_SESSION["cart_item"])) {
                foreach($_SESSION["cart_item"] as $k => $v) {
                        if($_GET["code"] == $k)
                            unset($_SESSION["cart_item"][$k]);				
                        if(empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                }
                header('location:product.php');
            }
        break;
        case "empty":
            unset($_SESSION["cart_item"]);
            header('location:product.php');
        break;	
    }
}
    ?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shopping</title>
    <link rel="stylesheet" type="text/css" href="/css/product.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>
<body>
    <div id="wrap">
        <div id="columns" class="columns_4">
            <?php
            $product_array = $db_handle->runQuery("SELECT * FROM products ORDER BY id ASC");
                if (!empty($product_array)) { 
                    foreach($product_array as $key=>$value){
            ?>
                <figure>
                    <form method="post" action="product.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                        <img class="img"src="<?php echo $product_array[$key]["image"]; ?>">
                        
                        <div class="text-info"><?php echo $product_array[$key]["name"]; ?></div>
                        <div class="text-danger"><?php echo $product_array[$key]["price"]." BNN$"; ?></div>
                        <input type="text" class="form-control" name="quantity" value="1" />
                        <input type="submit" name="add" value="Add to Cart" class="button" />
                        
                    </form>
                </figure>        
                
            <?php
                    }
                }
            ?>
        <div>
    </div>


    <div id="shopping-cart">
    <a id="btnEmpty" href="product.php?action=empty">Empty Cart</a>
    <?php
        if(isset($_SESSION["cart_item"])){
            $total_quantity = 0;
            $total_price = 0;
    ?>	
    <div style="align:center" class="container table-responsive" >
        <h3>Order Details</h3>
        <table class="table table-bordered" cellpadding="10" cellspacing="1">
            <tbody>
                <tr>
                    <th style="text-align:left;">Name</th>
                    <th style="text-align:left;">Code</th>
                    <th style="text-align:right;" width="5%">Quantity</th>
                    <th style="text-align:right;" width="10%">Unit Price</th>
                    <th style="text-align:right;" width="10%">Price</th>
                    <th style="text-align:center;" width="5%">Remove</th>
                </tr>	
                <?php		
                    foreach ($_SESSION["cart_item"] as $item){
                        $item_price = $item["quantity"]*$item["price"];
                ?>
                    <tr>
                        <!-- <td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td> -->
                        <td><?php echo $item["name"]; ?></td>
                        <td><?php echo $item["code"]; ?></td>
                        <td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
                        <td  style="text-align:right;"><?php echo $item["price"]." BNN$"; ?></td>
                        <td  style="text-align:right;"><?php echo number_format($item_price,2)." BNN$"; ?></td>
                        <td style="text-align:center; font-color:red;"><a href="product.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction" >Remove Item</a></td>
                    </tr>
                <?php
                        $total_quantity += $item["quantity"];
                        $total_price += ($item["price"]*$item["quantity"]);
                        
                        }
                        $_SESSION["price"] = $total_price;
                ?>
                <tr>
                    <td colspan="2" align="right">Total:</td>
                    <td align="right"><?php echo $total_quantity; ?></td>
                    <td align="right" colspan="2"><strong><?php echo number_format($total_price, 2)." BNN$"; ?></strong></td>
                    <td style="text-align:center;"><a href="payment.php" class="">Buy now!!</a></td>
                </tr>
            </tbody>
        </table>
    </div>		
    <?php
        } else {
    ?>
        <div class="no-records">Your Cart is Empty</div>
    <?php 
        }
    ?>
    </div>

    
</body>
</html>
