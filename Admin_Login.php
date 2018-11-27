<?php
include('View.php');
if (isset($_POST['submit']))
{
$controller->adminLogin();
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
<a href="Login.php">Existing User</a> <br>
Admin <br>
</div>
<div id="main">
<h2> Login </h2>

<form action="" method="post">

<label for="adminpassword">Password</label>

<input type="password" id="adminpassword" name="adminpassword" maxlength="20" />

<br>

<span>
<?php echo $controller->error; ?>
</span>

<br>
<input name="submit" type="submit" value="Login" />

</form>
</div>
</body>

</html>
