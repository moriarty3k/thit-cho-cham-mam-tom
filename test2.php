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

$time = date("l").date("h:i:sa");





?>


<html>
<head>
    <title>test</title>
	<link rel="stylesheet" type="text/css" href="/css/chat.css">
</head>
<body>
    <div class="chat-container">
    <div class="chat-header">
        <h2>Chat</h2>
    </div>
    <div class="chat-input">
        <form action="test2.php" method="post">
        <!-- <input type="text" name="message" placeholder="Type a message">
        <button type="submit">Send</button>
        <button type="submit" name="clear">Clear All Messages</button> -->
        <input type="text" name="search" placeholder="Search for user">
        <button type="submit">Search</button>
        </form>
    </div>
    <div class="chat-messages">
        <?php
        if (isset($_POST['search'])) {
            $search = $_POST['search'];
            $sql3 = "SELECT * FROM messages WHERE user='$search' ORDER BY time DESC";
            $result = mysqli_query($db, $sql3);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="message">';
                echo '<p>' . $row['user'] . ': ' . $row['message'] . '</p>';
                echo '<p class="time">' . $row['time'] . '</p>';
                echo '</div>';
              }
            } else {
              echo "No results found.";
            }
            // header("location: test2.php");
        }

        ?>
    </div>
    </div>
</body>
</html>
