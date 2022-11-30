<?php
include('server.php');


$query = "SELECT id, name, price, image FROM products";
$result = mysqli_query($db,$query);


if (isset($_POST["add"])) {
    
    if(isset($_SESSION["shopping_cart"])) {  
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
        if(!in_array($_GET["id"], $item_array_id)) {  
              $count = count($_SESSION["shopping_cart"]);  
              $item_array = array(  
                   'item_id'               =>     $_GET["id"],  
                   'item_name'               =>     $_POST["hidden_name"],  
                   'item_price'          =>     $_POST["hidden_price"],  
                   'item_quantity'          =>     $_POST["quantity"]  
              );  
              $_SESSION["shopping_cart"][$count] = $item_array;  
        } else {  
            array_push($success, "Item Already Added");
            header('location: product.php');
            //   echo '<script>alert("Item Already Added")</script>';  
            //   echo '<script>window.location="product.php"</script>';  
        }  
    } else {  
        $item_array = array(  
              'item_id'               =>     $_GET["id"],  
              'item_name'               =>     $_POST["hidden_name"],  
              'item_price'          =>     $_POST["hidden_price"],  
              'item_quantity'          =>     $_POST["quantity"]  
         );  
         $_SESSION["shopping_cart"][0] = $item_array;  
    }  
}  
if(isset($_GET["action"]))  
{  
    if($_GET["action"] == "delete")  
    {  
         foreach($_SESSION["shopping_cart"] as $keys => $values)  
         {  
            if($values["item_id"] == $_GET["id"])  
            {  
                unset($_SESSION["shopping_cart"][$keys]); 
                array_push($success, "Item removed");
                header('location: product.php'); 
                //    echo '<script>alert("Item Removed")</script>';  
                //    echo '<script>window.location="product.php"</script>';  
            }  
         }  
    }

    
} else {
    array_push($errors, "ko");
}
?> 

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
    <link rel="stylesheet" type="text/css" href="/css/product.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>
<!--Changing the number in the column_# class changes the number of columns-->
<body>
    <div id="wrap">
        <div id="columns" class="columns_4">
        <?php  if (mysqli_num_rows($result) > 0) : ?> 
            <?php while($row = mysqli_fetch_assoc($result)) : ?>
                <figure>
                    <form method="post" action="product.php?action=add&id=<?php echo $row["id"]; ?>">
                        <img class="img" src="<?php echo $row['image']?>">
                        <span class="id" name="id">ID: <?php echo $row['id'];?></span>
                        <h4 class="text-info"><?php echo $row["name"]; ?></h4>
                        <input type="text" name="quantity" class="form-control" value="1" />  
                        <h4 class="text-danger">$ <?php echo $row["price"]; ?></h4>
                        <input class="button" type="submit" name="add" value="Add to cart">
                        <input type="hidden" name="hidden_name" value="<?php echo $row['name']?>">
                        <input type="hidden" name="hidden_price" value="<?php echo $row['price']?>">
                    </form>
                </figure>
            <?php endwhile ?>
        <?php endif ?>
        </div>
    </div>
      
    <div style="width:700px; align:center" class="container table-responsive" >
        <h3>Order Details</h3> 
        <table class="table table-bordered">  
            <tr>  
                <th width="40%">Item Name</th>  
                <th width="10%">Quantity</th>  
                <th width="20%">Price</th>  
                <th width="15%">Total</th>  
                <th width="5%">Action</th>  
            </tr>  

            <?php   
            if(!empty($_SESSION["shopping_cart"]))  {  
                $total = 0;  
                foreach($_SESSION["shopping_cart"] as $keys => $values)  
                {  
            ?>  
            <tr>  
                <td><?php echo $values["item_name"]; ?></td>  
                <td><?php echo $values["item_quantity"]; ?></td>  
                <td>$ <?php echo $values["item_price"]; ?></td>  
                <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>  
                <td><a href="product.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>  
            </tr>  
            <?php  
                $total = $total + ($values["item_quantity"] * $values["item_price"]);  
                   }  
            ?>  
            <tr>  
                <td colspan="3" align="right">Total</td>  
                <td align="right">$ <?php echo number_format($total, 2); ?></td>  
                <td></td>  
            </tr>  
            <?php  
            }  
            ?>  
        </table>  
    </div>
</body>



</html>