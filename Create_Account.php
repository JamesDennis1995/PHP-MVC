<?php
include ('View.php');
if (isset($_POST['createaccount']))
{
$controller->createAccount();
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
<a href="Start.php">Start</a><br>
New User<br>
<a href="Login.php">Existing User</a> <br>
<a href="Admin_Login.php">Admin</a> <br>
</div>
<div id="main">
<form action="" method="post">

<h2>Create an Account</h2>
First Name: <input type="text" id="firstname" name="firstname" value=""/><br>
Surname: <input type="text" id="surname" name="surname" value=""/><br>

Password: <input type="password" id="password" name="password" value=""/><br>

Contact Number: <input type="text" id="contactnumber" name="contactnumber" value=""/><br>

Email Address: <input type="text" id="email" name="email"/><br>

Address Line 1: <input type="text" id="address1" name="address1"/><br>

Address Line 2: <input type="text" id="address2" name="address2"/><br>

Town/City: <input type="text" id="towncity" name="towncity"/><br>

County: <input type="text" id="county" name="county" value=""/><br>
Postcode: <input type="text" id="postcode" name="postcode"/><br>

<span>
<?php echo $controller->error; ?> 
</span> <br>
<input type="submit" id="createaccount" name="createaccount" value="Submit"/><br>


</form>

</div>
</body>

</html>
