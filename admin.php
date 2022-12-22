<?php 
include('server.php');


if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
}

if ($_SESSION['role'] != 'admin') {
    $_SESSION['msg'] = "You are not admin";
  	header('location: index.php');
} else {
	$_SESSION['success'] = 'Welcome admin';
}
$query = "SELECT * FROM users";
$result = mysqli_query($db, $query);


?>
<html>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<link rel="stylesheet" type="text/css" href="/css/product.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>
<body>
	
	<div style="align:center" class="container table-responsive" >
        <h3>User Details</h3>
        <table class="table table-bordered" cellpadding="10" cellspacing="1">
            <tbody>
                <tr>
                    <th style="text-align:center;" width="5%">ID</th>
                    <th style="text-align:center;" width="20%">Userame</th>
                    <th style="text-align:center;" width="30%">Email</th>
                    <th style="text-align:center;" width="10%">Role</th>
                    <th style="text-align:center;" width="10%">Balance</th>
                    <th style="text-align:center;" width="5%">Action</th>
                </tr>	
			<?php
				while ($row = mysqli_fetch_assoc($result)) {
			?>
			<tr>
				<td><?php echo $row['id'] ?></td>
				<td><?php echo $row['username'] ?></td>
				<td>
					<form action='admin.php' method='post'>
						<input type='email' name='email' value="<?php echo $row['email'] ?>">
					</form>
				</td>
				<td>
					<form action='admin.php' method='post'>
						<input type='role' name='role' value="<?php echo $row['role'] ?>">
					</form>
				</td>
				<td>
					<form action='admin.php' method='post'>
						<input type='balance' name='balance' value="<?php echo $row['balance'] ?>">
					</form>
				</td>
				<td>
					<form action='admin.php' method='post'>
						<input type='submit' value='update'>
						<input type='submit' value='delete'>
					</form>	
				</td>
			</tr>
		<?php
			}

			if (isset($_POST['update'])) {
				echo $_SESSION['username'];
			}
		?>
		</table>



</body>
</html>
</html>
