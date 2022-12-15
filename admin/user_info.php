<?php 
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
    }
    if ($_SESSION['role'] != 'admin
    ') {
        $_SESSION['msg'] = "You are not admin";
        header('location: index.php');
    }
    $db_handle = new DBController();
    $user = $db_handle->runQuery("SELECT * FROM users ORDER BY id ASC");

?>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>
<body>
<div style="align:center" class="container table-responsive" >
        <h3>Users Info</h3>
        <table class="table table-bordered" cellpadding="10" cellspacing="1">
            <tbody>
                <tr>
                    <th width="5%">Id</th>
                    <th width="30%">User Name</th>
                    <th width="20%">Email</th>
                    <th width="10%">Role</th>
                    <th width="20%">Balance</th>
                    <th width="10%">Remove</th>
                </tr>
                <?php		
                    foreach ($user as $k => $v){
                ?>
                <tr>
                    <td><?php echo $user[$k]["id"]; ?></td>
                    <td><?php echo $user[$k]["username"]; ?></td>
                    <td style="text-align:right;"><?php echo $user[$k]["email"]; ?></td>
                    <td  style="text-align:right;"><?php echo $user[$k]["role"]; ?></td>
                    <td  style="text-align:right;"><?php echo $user[$k]["balance"]." BNN$"; ?></td>
                    <td style="text-align:center; font-color:red;"><a href="" class="btnRemoveAction" >Remove</a></td>
                </tr>
                <?php } ?>
                	
                
            
            </tbody>
        </table>
    </div>
</body>
</html>