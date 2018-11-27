<?php
include ('View.php');
$controller->adminSession();
$orderIDs = $controller->getOrderIDs("admin");
?>
<html>

<head>
<title>Cards 101</title>
<link rel="stylesheet" type="text/css" href="style.css">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<script>
function getOrderDetails(id) {
if (id != "") {
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
var object = JSON.parse(this.responseText);
console.log(object);
var table = "<th>Image</th><th>Stock Code</th><th>Stock Description</th><th>Quantity</th>"
for (i = 0; i < object.length; i++) {
table += "<tr><th><img src='Images/"+ object[i].StockCode +".jpg' style='width: auto; height: 100px' /></th><th>"+ object[i].StockCode +"</th><th>"+ object[i].Description +"</th><th>"+ object[i].Quantity +"</th></tr>";
}
document.getElementById('OrderDetails').innerHTML = table;
document.getElementById('name').innerHTML = object[0].FirstName + " " + object[0].Surname;
if (object[0].Address2 == "") {
document.getElementById('address').innerHTML = object[0].Address1 + ", " + object[0].TownCity + ", "+ object[0].County + ", " + object[0].Postcode;
}
else {
document.getElementById('address').innerHTML = object[0].Address1 + ", " + object[0].Address2 + ", " + object[0].TownCity + ", "+ object[0].County + ", " + object[0].Postcode;
}
document.getElementById('contactnumber').innerHTML = object[0].ContactNumber;
document.getElementById('total').innerHTML = "&pound" + object[0].OrderTotal;
}
};
xhr.open("POST", "GetOrderDetails.php", "true");
xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhr.send('IDs=' + id);
}
else
{
document.getElementById('OrderDetails').innerHTML = "";
document.getElementById('name').innerHTML = "";
document.getElementById('address').innerHTML = "";
document.getElementById('contactnumber').innerHTML = "";
document.getElementById('total').innerHTML = "";
}
}
</script>

<body>

<div id="header">
<h1>Cards 101</h1>
</div>
<div id="side">
<a href="Admin.php">Home</a><br>
<a href="Add_Stock.php">Add Stock</a> <br>
Check Orders <br>
<a href="Change_Admin_Password.php">Change Password</a> <br>
</div>
<div id="main">
<h2> Check Orders </h2>
<form action="" method="post">
<select name="IDs" onchange = "getOrderDetails(this.value)">
<option value=""></option>
<?php
foreach($orderIDs as $option)
{
echo '<option value="'.$option["Id"].'">'.$option["Id"].'</option>';
}
?>
</select> <br>
<b>Placed by:</b> <label id="name"></label> <br>
<b>Address:</b> <label id="address"></label> <br>
<b>Contact Number:</b> <label id="contactnumber"></label> <br>
<b>Order Total:</b> <label id="total"></label> <br>
<table id="OrderDetails">
</table>
</div> <br>

</form>
</body>
</html>