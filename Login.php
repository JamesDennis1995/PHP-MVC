<?php
include('View.php');
if(isset($_SESSION['email']))
{
header("location: Customer.php");
}
if (isset($_POST['submit']))
{
$controller->login();
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
<a href="Create_Account.php">New User</a><br>
Existing User <br>
<a href="Admin_Login.php">Admin</a> <br>
</div>
<div id="main">
<h2> Login </h2>

<form action="" method="post">

<label for="email">Email</label>
<input type="text" id="email" name="email"
value="" maxlength="40" />
<br>

<label for="password">Password</label>
<input type="password" id="password" name="password" maxlength="20" />
<br>


<input name="submit" type="submit" value="Login" />
<br>

<span>
<?php echo $controller->error; ?> <br>
</span>
</form>

</div>
</body>

</html>
