<?php
include('View.php');
$controller->session();
if (isset($_POST['logout']))
{
$controller->logout("customer");
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
Home<br>
<a href="Order.php">Place an order</a> <br>
<a href="Check_Orders.php">Check your orders</a> <br>
<a href="Edit_Details.php">Edit your details</a> <br>
</div>
<div id="main">
<h2> Customer Home </h2>
<form action="" method="post">
<b id="welcome"><?php echo $_SESSION['message'];?></b><br>
<input type="submit" id="logout" name="logout" value="Log Out"/>
</form>
</div>
</body>

</html>