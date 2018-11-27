<?php
class Model
{
public $con;
public function __construct(){
$this->string = "My name's James. Click here.";
}
public function dbConnect() {
$this->con = new PDO('mysql:dbname=james;host=localhost', 'James Dennis', 'Xernea$716');
$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
if (!$this->con)
{
die("Connection failed: " . mysql_connect_error());
}
}
public function createAccount(){
$this->dbConnect();
$sql = $this->con->prepare("SELECT * FROM Customer WHERE Email = :email");
$sql->bindParam(':email', $_POST['email']);
$sql->execute() or die($sql->errorInfo());
if ($sql->rowCount() >= 1)
{
return "failure";
}
else
{
$password = $_POST['password'];
$sql2 = $this->con->prepare("INSERT INTO customer (FirstName, Surname, Password, ContactNumber, Email, Address1, Address2, TownCity, County, Postcode) VALUES (:firstname, :surname, :password, :contactnumber, :email, :address1, :address2, :towncity, :county, :postcode)");
$sql2->bindParam(':firstname', $_POST['firstname']);
$sql2->bindParam(':surname', $_POST['surname']);
$sql2->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
$sql2->bindParam(':contactnumber', $_POST['contactnumber']);
$sql2->bindParam(':email', $_POST['email']);
$sql2->bindParam(':address1', $_POST['address1']);
$sql2->bindParam(':address2', $_POST['address2']);
$sql2->bindParam(':towncity', $_POST['towncity']);
$sql2->bindParam(':county', $_POST['county']);
$sql2->bindParam(':postcode', $_POST['postcode']);
$sql2->execute() or die($sql2->errorInfo());
return "success";
}
}
public function login() {
$this->dbConnect();
$sql = $this->con->prepare("SELECT * FROM customer WHERE Email=:email");
$sql->bindParam(':email', $_POST['email']);
$sql->execute() or die($sql->errorInfo());
if ($sql->rowCount() == 0) {
return $sql->rowCount();
}
else
{
$row = $sql->fetch();
if (password_verify($_POST['password'], $row['Password'])) {
return 1;
}
else
{
return 0;
}
}
}
public function adminLogin() {
$this->dbConnect();
session_start();

$sql = $this->con->prepare("SELECT * FROM adminpassword") or die(mysql_error());
$sql->execute() or die($sql->errorInfo());
$row = $sql->fetch();
if (password_verify($_POST['adminpassword'], $row['AdminPassword'])) {
return 1;
}
else
{
return 0;
}
}
public function addStock($target_file) {
$this->dbConnect();
$sql = $this->con->prepare("SELECT * FROM stock WHERE Code = :code");
$sql->bindParam(':code', $_POST['code']);
$sql->execute() or die($sql->errorInfo());
if ($sql->rowCount() >= 1)
{
return "failure";
}
else
{
$sql2 = $this->con->prepare("INSERT INTO stock (Code, Description, PricePerUnit) VALUES (:code, :description, :priceunit)");
$sql2->bindParam(':code', $_POST['code']);
$sql2->bindParam(':description', $_POST['description']);
$sql2->bindParam(':priceunit', $_POST['priceunit']);
if ($sql2->execute() && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
return "success";
} else {
return "failure";
}
}
}
public function getStock() {
$this->dbConnect();
$sql = $this->con->prepare("SELECT * FROM stock");
$sql->execute()or die($sql->errorInfo());
$stock = $sql->fetchAll();
return $stock;
}
public function session() {
$this->dbConnect();
session_start();

$ses_sql = $this->con->prepare("SELECT * FROM customer WHERE Email=:email_check");
$ses_sql->bindParam(':email_check', $_SESSION['email']);

$ses_sql->execute() or die ($ses_sql->errorInfo());
$row = 
$ses_sql->fetch();
return $row;
}
public function placeOrder() {
$this->dbConnect();
$sql = $this->con->prepare("SELECT * FROM orders");
$sql->execute() or die($sql->errorInfo());
$orderNumber = $sql->rowCount() + 1;
$orderTotal = 0;
for ($i = 0; $i < count($_SESSION['basket']); $i++)
{
$orderTotal += $_SESSION['basket'][$i][total];
}
$sql2 = $this->con->prepare("INSERT INTO orders (Customer, OrderTotal) VALUES (:customer, :orderTotal)");
$sql2->bindParam(':customer', $_SESSION['Id']);
$sql2->bindParam(':orderTotal', $orderTotal);
$sql2->execute() or die($sql2->errorInfo());
for ($j = 0; $j < count($_SESSION['basket']); $j++)
{
$sql3 = $this->con->prepare("INSERT INTO orderstock (OrderID, StockCode, Quantity) VALUES (:orderNumber, :stockCode, :quantity)");
$sql3->bindParam(':orderNumber', $orderNumber);
$sql3->bindParam(':stockCode', $_SESSION['basket'][$j][code]);
$sql3->bindParam(':quantity', $_SESSION['basket'][$j][quantity]);
$sql3->execute() or die($sql3->errorInfo());
}
return "success";
}
public function getOrderIDs($category) {
$this->dbConnect();
if ($category == "customer") {
$sql = $this->con->prepare("SELECT Id FROM orders WHERE Customer = :ID");
$sql->bindParam(':ID', $_SESSION['Id']);
}
else {
$sql = $this->con->prepare("SELECT Id FROM orders ORDER BY ID ASC");
}
$sql->execute()or die($sql->errorInfo());
$orderIDs = $sql->fetchAll();
return $orderIDs;
}
public function getOrderDetails() {
$this->dbConnect();
$sql = $this->con->prepare("SELECT orders.Id, customer.FirstName, customer.Surname, customer.ContactNumber, customer.Address1, customer.Address2, customer.TownCity, customer.County, customer.Postcode, orderstock.StockCode, stock.Description, orderstock.Quantity, orders.OrderTotal FROM stock INNER JOIN ((customer INNER JOIN orders ON customer.ID = orders.Customer) INNER JOIN orderstock ON orders.ID = orderstock.OrderID) ON stock.Code = orderstock.StockCode WHERE orders.ID = :ID");
$sql->bindParam(':ID', $_POST['IDs']);
$sql->execute()or die($sql->errorInfo());
$orderDetails = $sql->fetchAll();
return $orderDetails;
}
public function editDetails() {
$this->dbConnect();
$sql = $this->con->prepare("SELECT * FROM customer WHERE Email = :email");
$sql->bindParam(':email', $_POST['email']);
$sql->execute() or die($sql->errorInfo());
if ($sql->rowCount() >= 1)
{
return "failure";
}
else
{
$sql2 = $this->con->prepare("SELECT * FROM customer WHERE Id = :ID");
$sql2->bindParam(':ID', $_SESSION['Id']);
$sql2->execute() or die($sql2->errorInfo());
$row = $sql2->fetch();
if ($_POST['firstname'] == "") {
$firstname = $row['FirstName'];
}
else {
$firstname = $_POST['firstname'];
}
if ($_POST['surname'] == "") {
$surname = $row['Surname'];
}
else {
$surname = $_POST['surname'];
}
if ($_POST['password'] == "") {
$password = $row['Password'];
}
else {
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
}
if ($_POST['contactnumber'] == "") {
$contactnumber = $row['ContactNumber'];
}
else {
$contactnumber = $_POST['contactnumber'];
}
if ($_POST['email'] == "") {
$email = $row['Email'];
}
else {
$email = $_POST['email'];
$_SESSION['email'] = $_POST['email'];
}
if ($_POST['address1'] == "") {
$address1 = $row['Address1'];
}
else {
$address1 = $_POST['address1'];
}
if ($_POST['address2'] == "" && !isset($_POST['leaveblank'])) {
$address2 = $row['Address2'];
}
else {
$address2 = $_POST['address2'];
}
if ($_POST['towncity'] == "") {
$towncity = $row['TownCity'];
}
else {
$towncity = $_POST['towncity'];
}
if ($_POST['county'] == "") {
$county = $row['County'];
}
else {
$county = $_POST['county'];
}
if ($_POST['postcode'] == "") {
$postcode = $row['Postcode'];
}
else {
$postcode = $_POST['postcode'];
}
$sql3 = $this->con->prepare("UPDATE customer SET FirstName=:firstname, Surname=:surname, Password=:password, ContactNumber=:contactnumber, Email=:email, Address1=:address1, Address2=:address2, TownCity=:towncity, County=:county, Postcode=:postcode WHERE Id = :ID");
$sql3->bindParam(':firstname', $firstname);
$sql3->bindParam(':surname', $surname);
$sql3->bindParam(':password', $password);
$sql3->bindParam(':contactnumber', $contactnumber);
$sql3->bindParam(':email', $email);
$sql3->bindParam(':address1', $address1);
$sql3->bindParam(':address2', $address2);
$sql3->bindParam(':towncity', $towncity);
$sql3->bindParam(':county', $county);
$sql3->bindParam(':postcode', $postcode);
$sql3->bindParam(':ID', $_SESSION['Id']);
$sql3->execute() or die($sql3->errorInfo());
return "success";
}
}
public function changeAdminPassword() {
$this->dbConnect();
$sql = $this->con->prepare("SELECT * FROM adminpassword");
$sql->execute() or die($sql->errorInfo());
$row = $sql->fetch();
if (!password_verify($_POST['oldpassword'], $row['AdminPassword'])) {
return "failure";
}
else {
$sql2 = $this->con->prepare("UPDATE AdminPassword SET AdminPassword=:newpassword WHERE ID > 0");
$sql2->bindParam(':newpassword', password_hash($_POST['newpassword'], PASSWORD_DEFAULT));
$sql2->execute() or die($sql2->errorInfo());
return "success";
}
}
}
?>