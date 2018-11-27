<?php
include ('View.php');
$controller->session();
$orderIDs = $controller->getOrderIDs("customer");
$orderDetails = $controller->getOrderDetails();
?>
<html>

<head>
<title>Cards 101</title>
<link rel="stylesheet" type="text/css" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script>
function getOrderDetails(id) {
if (id != "") {
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
var object = JSON.parse(this.responseText);
console.log(object);
var table = "<th>Image</th><th>Stock Code</th><th>Stock Description</th><th>Quantity</th>";
for (i = 0; i < object.length; i++) {
table += "<tr><th><img src='Images/"+ object[i].StockCode +".jpg' style='width: auto; height: 100px' /></th><th>"+ object[i].StockCode +"</th><th>"+ object[i].Description +"</th><th>"+ object[i].Quantity +"</th></tr>";
}
document.getElementById('OrderDetails').innerHTML = table;
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
document.getElementById('total').innerHTML = "";
}
}
</script>
</head>

<body>

<div id="header">
<h1>Cards 101</h1>
</div>
<div id="side">
<a href="Customer.php">Home</a><br>
<a href="Order.php">Place an order</a> <br>
Check your orders <br>
<a href="Edit_Details.php">Edit your details</a> <br>
</div>
<div id="main">
<h2> Check Your Orders </h2>
<form action="" method="post">
<select name="IDs" onchange = "getOrderDetails(this.value)">
<option value=""></option>
<?php
foreach($orderIDs as $option)
{
echo '<option value="'.$option["Id"].'"';
if (isset($_POST['IDs']) && $option['Id'] == $_POST['IDs'] && $_POST['IDs'] != "") {
echo 'selected';
}
echo '>'.$option["Id"].'</option>';
}
?>
</select> <br>
<table id="OrderDetails">
</table> <br>
<b>Order Total:</b> <label id="total"> </label> <br>
<a href="Customer.php">Back</a>
</form>
</div>
</body>
</html>