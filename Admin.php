<?php
include('View.php');
$controller->adminSession();
if (isset($_GET['logout']))
{
$controller->logout("admin");
}
?>
<html>

<form>

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
Home<br>
<a href="Add_Stock.php">Add Stock</a> <br>
<a href="Check_Orders_Admin.php">Check Orders</a> <br>
<a href="Change_Admin_Password.php">Change Password</a> <br>
</div>
<div id="main">
<h2> Admin Home </h2>
<b id="welcome"><?php echo $_SESSION['message_admin'];?></b><br>
<input type="submit" id="logout" name="logout" value="Log Out"/>
</div>
</body>

</form>

</html>
