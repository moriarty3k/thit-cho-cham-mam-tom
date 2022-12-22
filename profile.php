<?php 
include('server.php');
if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: login.php");
}
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username='$username'";
$results = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($results);

if(isset($_POST['submit'])) {

    // Get the file details
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTempName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];

    // Allow certain file formats
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png');

    // Check if the file is the correct type and within the allowed size
    if (in_array($fileActualExt, $allowed) && $fileError === 0 && $fileSize < 500000) {

        // Generate a new file name to avoid conflicts
        $fileNameNew = uniqid('', true) . "." . $fileActualExt;

        // Set the file path where the file will be stored
        $fileDestination = './UserImg/' . $fileNameNew;

        // Move the uploaded file to the desired location
        move_uploaded_file($fileTempName, $fileDestination);

        // Update the user's profile image in the database
        $query2 = "UPDATE users SET image='$fileDestination' WHERE username= '$username' ";
		mysqli_query($db, $query2);

        // Redirect the user back to the profile page
        header("location: profile.php");

    } else {
        // Display an error message if the file is the wrong type or too large
        echo "Error: File must be a jpeg, png, or jpg and must be under 500KB.";
    }

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css">
    
<body>
<?php include('navbar.php'); ?>
<div class="header">
	<h2>Profile</h2>
</div>
<div class="content" >
    <img class='avt' src="/UserImg/<?php echo $user['image']?>">
	<form method="post" action="profile.php">
		<input type="file" name="file">
		<input type="submit" name="submit" value="submit">
	</form>
    <p>
		Welcome 
		<b><?php echo $user['username']; ?></b>
	</p>
    <p>
		You are:   
		<b><?php echo $user['role']; ?></b>
	</p>
    <p>
		Your email address:   
		<b><?php echo $user['email']; ?></b>
	</p>
    <?php if($user['role'] == 'user'){?>
        <a href='upgrade.php' >Buy VIP</a>
    <?php } ?>
</div>