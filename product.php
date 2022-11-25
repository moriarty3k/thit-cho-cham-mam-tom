<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'wokwokwokwok');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}



$sql = "SELECT id, name, price, image FROM products";
$result = $db->query($sql);





$db->close();   
?> 

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
    <link rel="stylesheet" type="text/css" href="/css/product.css">
</head>
<!--Changing the number in the column_# class changes the number of columns-->
<body>
    <div id="wrap">
        <div id="columns" class="columns_4">
        <?php  if ($result->num_rows > 0) : ?> 
            <?php while($row = $result->fetch_assoc()) : ?>
                <figure>
                    <img class="img" src="<?php echo $row['image']?>">
                    <span class="id">ID: <?php echo $row['id'] ?></span>
                    <figcaption><?php echo $row['name'] ?></figcaption>
                    <span class="price"><?php echo $row['price'] ?> banana</span>
                    <a class="button" href="#">Add to Cart</a>
                </figure>
            <?php endwhile ?>
        <?php endif ?>
        </div>
    </div>

</body>


<!-- <body>
    <?php  if ($result->num_rows > 0) : ?>    
         //output data of each row 
            <?php while($row = $result->fetch_assoc()) : ?>
                <div class="product">
                    <img src="<?php echo $row['image']?>" alt="product image">
                    <div class="container">  
                        <p>ID: <?php echo $row['id'] ?></p>
                        <p>Name: <?php echo $row['name'] ?></p>
                        <p>Price: <?php echo $row['price'] ?> banana</p>
                    </div>
                </div>
            <?php endwhile ?>
        
    <?php endif ?>
        
</body> -->
</html>