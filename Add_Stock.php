<?php
include('View.php');
$controller->adminSession();
if (isset($_POST['submit']))
{
$controller->addStock();
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
Add Stock <br>
<a href="Check_Orders_Admin.php">Check Orders</a> <br>
<a href="Change_Admin_Password.php">Change Password</a> <br>
</div>
<div id="main">
<h2> Add Stock </h2>
<form action="" method="post" enctype="multipart/form-data">

Code: <input type="text" id="code" name="code"/> <br>

Description: <input type="text" id="description" name="description"/> <br>

Price per unit (£): <input type="text" id="priceunit" name="priceunit"/> <br>

Image: <input type="file" id="image" name="image" /><br />
<img id="preview" src="" hidden="hidden" style="width:auto; height:150px" /> <br />
<?php echo $controller->error; ?> <br>
<input type="submit" id="submit" name="submit" value="Submit"/>
</form>

</div>
</body>

</html>
