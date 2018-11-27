<?php
include('View.php');
$controller->session();
if (isset($_POST['submit']))
{
$controller->editDetails();
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
<body>
<script>
function address2Changed() {
if (document.getElementById("address2").value != "") {
document.getElementById("leaveblank").checked = false;
document.getElementById("leaveblank").disabled = true;
}
else
{
document.getElementById("leaveblank").disabled = false;
}
console.log("Function called.");
}
</script>
<div id="side">
<a href="Customer.php">Home</a><br>
<a href="Order.php">Place an order</a> <br>
<a href="Check_Orders.php">Check your orders</a> <br>
Edit your details <br>
</div>
<div id="main">
<h2> Edit your Details </h2>
<form action="" method="post">

First Name: <input type="text" id="firstname" name="firstname" value=""/> <br>
Surname: <input type="text" id="surname" name="surname" value=""/> <br>

Password: <input type="password" id="password" name="password" value=""/> <br>

ContactNumber: <input type="text" id="contactnumber" name="contactnumber" value=""/> <br>
Email Address: <input type="email" id="email" name="email" value=""/> <br>

Address Line 1: <input type="text" id="address1" name="address1" value=""/> <br>

Address Line 2: <input type="text" id="address2" name="address2" value="" oninput="address2Changed()"/> <input type="checkbox" id="leaveblank" name="leaveblank" value="LeaveBlank">Leave blank <br>

Town/City: <input type="text" id="towncity" name="towncity" value=""/> <br>
County: <input type="text" id="county" name="county" value=""/> <br>

Postcode: <input type="text" id="postcode" name="postcode" value=""/> <br>

<?php echo $controller->error; ?> <br>
<input type="submit" id="submit" name="submit" value="Submit"/>
</div>
</form>
</body>
</html>