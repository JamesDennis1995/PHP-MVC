<?php

include('View.php');

$controller->adminSession();
if (isset($_POST['submit'])) {
$controller->changeAdminPassword();
}
?>

<html>

<head>
<title>Cards 101</title>
<link rel="stylesheet" type="text/css" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div id="header">
<h1>Cards 101</h1>
</div>
</head>

<body>
<div id="side">
<a href="Admin.php">Home</a><br>
<a href="Add_Stock.php">Add Stock</a> <br>
<a href="Check_Orders_Admin.php">Check Orders</a> <br>
Change Password <br>
</div>
<div id="main">
<h2>Change Password</h2>
<form action="" method="post">

Old Password: <input type="password" id="oldpassword" name="oldpassword" value=""/> <br>

New Password: <input type="password" id="newpassword" name="newpassword" value=""/> <br>

Confirm New Password: <input type="password" id="confirmnewpassword" name="confirmnewpassword" value=""/> <br>
<input type="submit" id="submit" name="submit" value="Submit"/>
 <br>
<?php echo $controller->error; ?>
</form>

</div>
</body>

</html>
