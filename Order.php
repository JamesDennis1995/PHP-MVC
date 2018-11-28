<?php
include('View.php');
$controller->session();
$stock = $controller->getStock();
if (isset($_POST['placeorder'])) {
$controller->placeOrder();
}
?>
<html>

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script>
var basket = new Array();
function basketUpdate() {
var table = "<th>Image</th><th>Stock Code</th><th>Stock Description</th><th>Quantity</th><th>Total Price</th>";
var itemToRemove = "<option value=''></option>";
var basketHidden = "";
for (i = 0; i < basket.length; i++) {
table += "<tr><th><img src='Images/"+ basket[i].code +".jpg' style='width: auto; height: 100px' /></th><th>"+ basket[i].code +"</th><th>"+ basket[i].description +"</th><th>"+ basket[i].quantity +"</th><th>"+ basket[i].total +"</th></tr>";
itemToRemove += "<option value='"+i+"'>"+basket[i].code+"</option>";
basketHidden += "<input type='text' id='basket["+i+"][code]' name='basket["+i+"][code]' value='"+basket[i].code+"'><input type='text' id='basket["+i+"][quantity]' name='basket["+i+"][quantity]' value='"+basket[i].quantity+"'><input type='text' id='basket["+i+"][total]' name='basket["+i+"][total]' value='"+basket[i].total+"'><br>"
}
document.getElementById('basket').innerHTML = table;
document.getElementById('itemToRemove').innerHTML = itemToRemove;
document.getElementById('basketHidden').innerHTML = basketHidden;
}
function getStock(id) {
if (id != "") {
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
var object = JSON.parse(this.responseText);
document.getElementById('image').hidden = false;
document.getElementById('image').src = "Images/" + object.Code + ".jpg";
document.getElementById('description').innerHTML = object.Description;
document.getElementById('price').innerHTML = "&pound" + object.PricePerUnit;
}
};
xhr.open("POST", "Order-Ajax.php", "true");
xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhr.send('stock=' + id);
}
else
{
document.getElementById('image').hidden = true;
document.getElementById('description').innerHTML = "";
document.getElementById('price').innerHTML = "";
}
}
function addToBasket(id){
if (document.getElementById('stock').SelectedIndex == 0 || document.getElementById('quantity').value == 0) {
document.getElementById('error').innerHTML = "You must select an item and a quantity.";
}
else {
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
var object = JSON.parse(this.responseText);
var total = document.getElementById("quantity").value * object.PricePerUnit;
var found = false;
if (basket.length > 0) {
for(var i = 0; i < basket.length; i++) {
if (basket[i].code == object.Code)
{
found = true;
basket[i].quantity += Number(document.getElementById("quantity").value);
basket[i].total += Number(total.toFixed(2));
break;
}
}
}
if (found == false) {
basket.push({code:object.Code, description:object.Description, quantity:Number(document.getElementById("quantity").value), total:Number(total.toFixed(2))});
}
console.log(basket);
basketUpdate();
}
};
xhr.open("POST", "Order-Ajax.php", "true");
xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhr.send('addtobasket=' + id + '&stock=' + document.getElementById("stock").value + '&quantity=' + document.getElementById("quantity").value);
}
}
function remove() {
if (basket.length == 0) {
document.getElementById('error').innerHTML = "Nothing to remove.";
}
if (document.getElementById('itemToRemove').selectedIndex == 0) {
document.getElementById('error').innerHTML = "You must select an item to remove.";
}
else {
if (document.getElementById('numberToRemove').value == "All") {
basket.splice(document.getElementById('itemToRemove').selectedIndex - 1, 1);
}
else {
var priceOfOne = basket[document.getElementById('itemToRemove').selectedIndex - 1].total / basket[document.getElementById('itemToRemove').selectedIndex - 1].quantity;
basket[document.getElementById('itemToRemove').selectedIndex - 1].quantity -= Number(document.getElementById('numberToRemove').value);
basket[document.getElementById('itemToRemove').selectedIndex - 1].total = priceOfOne * basket[document.getElementById('itemToRemove').selectedIndex - 1].quantity;
}
basketUpdate();
}
}
function removeUpdate() {
var numberToRemove = "";
if (document.getElementById('itemToRemove').value != "" && basket[document.getElementById('itemToRemove').selectedIndex - 1].quantity > 1) {
for (var i = 1; i < basket[document.getElementById('itemToRemove').selectedIndex - 1].quantity; i++) {
numberToRemove += "<option value='"+i+"'>"+i+"</option>";
}
}
numberToRemove += "<option value='All'>All</option>";
document.getElementById("numberToRemove").innerHTML = numberToRemove;
}
</script>
<script>
$(document).ready(function(){
$("#flip").click(function(){
$("#panel").slideToggle("slow");
});
});
</script>
<title>Cards 101</title>
<link rel="stylesheet" type="text/css" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div id="header">
<h1>Cards 101</h1>
</div>
</head>

<body>

<div id="side">
<a href="Customer.php">Home</a><br>
Place an order <br>
<a href="Check_Orders.php">Check your orders</a> <br>
<a href="Edit_Details.php">Edit your details</a> <br>
</div>
<div id="main">
<h2> Place an Order </h2>
<form action="" method="post">
<select id="stock" name="stock" onchange="getStock(this.value)">
<option value=""></option>
<?php
$i = 0;
foreach($stock as $option)
{
echo '<option value="'.$i.'"';
if (isset($_POST['stock']) && $i == $_POST['stock'] && $_POST['stock'] != "") {
echo 'selected';
}
echo '>'.$option["Code"].'</option>';
$i++;
}
?>
</select> <br>
<img id="image" src="" style="width:auto; height:150px" hidden><br>
<b>Description:</b> <label id="description"></label> <br>
<b>Price per unit:</b> <label id="price"></label> <br>
<b>Quantity:</b> <input type="number" id="quantity" name="quantity"><br>
<label id="error"></label> <br>
<div id="flip">Show/hide basket</div>
<div id="panel">
<table id="basket">
</table>
</div><br>
<div id="basketHidden" hidden></div>
<b>Remove item(s)</b><br>
<select id="itemToRemove" name="itemToRemove" onchange = "removeUpdate()">
</select>
<select id="numberToRemove" name="numberToRemove">
</select>
<input type="button" id="remove" name="remove" value="Remove" onclick = "remove()"/>
<br>
<input type="button" id="addtobasket" name="addtobasket" value="Add to Basket" onclick = "addToBasket(this.value)"/>
<input type="submit" id="placeorder" name="placeorder" value="Place Order"/> <br>
</form>
</div>
</body>
</html>