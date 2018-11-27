<?php
class Item
{
public $number;
public $code;
public $quantity;
public $total;
public function __construct($number, $code, $quantity, $total) {
$this->number = $number;
$this->code = $code;
$this->quantity = $quantity;
$this->total = $total;
}
}
class Controller
{
private $model;
public $error = '';
public $description = '';
public $price = '';
public $number;
public function __construct($model){
$this->model = $model;
}
public function createAccount() {
if ($_POST['firstname'] == null || $_POST['surname'] == null || $_POST['password'] == null || $_POST['contactnumber'] == null || $_POST['email'] == null || $_POST['address1'] == null || $_POST['towncity'] == null || $_POST['county'] == null || $_POST['postcode'] == null)
{
$this->error = "You must enter something for all fields.";
}
else
{
$result = $this->model->createAccount();
if ($result == "failure")
{
$this->error = "That email address is already in use.";
}
if ($result == "success")
{
$this->error = "Record successfully inserted! <br>To log in, click <b>New User</b> and enter your details.<br>";
}
}
}
public function login() {
if (empty($_POST['email']) || empty($_POST['password']))
{
$this->error = "Email or password is invalid.";
}
else
{
$rows = $this->model->login();
if ($rows == 1)
{
session_start();
$_SESSION['message']="Welcome.";
$_SESSION['email']=$_POST['email'];
$_SESSION['password']=$_POST['password'];
$_SESSION['basket']=array();
header("location: Customer.php");
}
else
{
$this->error = "Email or password is invalid.";
}
}
}
public function getStock() {
$stock = $this->model->getStock();
return $stock;
}
public function adminLogin() {
if (empty($_POST['adminpassword'])) {
$this->error = 'Password is invalid.';
}
else
{
$rows = $this->model->adminLogin();
if ($rows == 1) {
session_start();
$_SESSION['login_admin']="Admin";
$_SESSION['message_admin']="Welcome.";
header("location:Admin.php");
}
else {
$this->error = 'Password is invalid.';
}
}
}
public function session() {
$row = $this->model->session();
$_SESSION['Id']=$row['Id'];
$login_session=$row['Email'];

if (!isset($login_session))
{
header('Location: Login.php');
}
}
public function adminSession() {
session_start();
if(!isset($_SESSION['login_admin'])) {
header("location: Admin_Login.php");
}
}
public function addStock() {
$target_dir = "Images/";
$target_file = $target_dir . basename($_POST['code'] . ".jpg");
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if ($_POST['code'] == null || $_POST['description'] == null || $_POST['priceunit'] == null || $_FILES['image'] == null || $imageFileType != "jpg") {
$this->error = 'You must enter something for all fields, and the uploaded image must be JPG.';
}
else
{
$message = $this->model->addStock($target_file);
if ($message == "failure") {
$this->error = 'That stock code is already in use.';
}
if ($message == "success")
{
$_SESSION['message_admin'] = 'New stock item successfully added.';
header("location: Admin.php");
}
}
}
public function orderUpdate() {
if ($_POST['stock'] == "") {
$this->description = '';
$this->price = '';
}
else
{
$this->number = $_POST['stock'];
$stock = $this->getStock();
$this->description = $stock[$this->number]["Description"];
$this->price = $stock[$this->number]["PricePerUnit"];
return $stock[$this->number];
}
}
public function addToBasket($stock) {
$i = 0;
$present = false;
if ($_POST['stock'] == "") {
$this->error = "You must select an item first.";
}
else if (!isset($_POST['quantity']) || $_POST['quantity'] == "")
{
$this->error = "Please enter a quantity.";
}
else {
while ($present == false && $i < count($_SESSION['basket'])) {
if ($_SESSION['basket'][$i]->code == $stock[$this->number]["Code"]) {
$present = true;
$_SESSION['basket'][$i]->quantity += $_POST['quantity'];
$_SESSION['basket'][$i]->total = number_format($_SESSION['basket'][$i]->quantity * $stock[$this->number]["PricePerUnit"], 2);
}
if ($present == false) {
$i++;
}
}
if ($present == false) {
$itemToAdd = new Item($_POST['stock'], $stock[$this->number]["Code"], $_POST['quantity'], number_format($_POST['quantity'] * $stock[$this->number]["PricePerUnit"], 2));
$_SESSION['basket'][] = $itemToAdd;
}
return $_SESSION['basket'];
}
}
public function removeItem($pricePerUnit) {
if ($_POST['numberToRemove'] == "All")
{
array_splice($_SESSION['basket'], $_POST['itemToRemove'], 1);
}
else
{
$_SESSION['basket'][$_POST['itemToRemove']]->quantity -= $_POST['numberToRemove'];
$_SESSION['basket'][$_POST['itemToRemove']]->total = $_SESSION['basket'][$_POST['itemToRemove']]->quantity * $pricePerUnit;
}
}
public function placeOrder() {
$_SESSION['basket'] = $_POST['basket'];
$message = $this->model->placeOrder();
if ($message == "success") {
$_SESSION['message'] = "Order successfully placed.";
header("location: Customer.php");
}
}
public function getOrderIDs($category) {
$orderIDs = $this->model->getOrderIDs($category);
return $orderIDs;
}
public function getOrderDetails () {
if (isset($_POST['IDs']) && $_POST['IDs'] != "") {
$orderDetails = $this->model->getOrderDetails();
return $orderDetails;
}
else {
return array();
}
}
public function editDetails() {
if ($_POST['firstname'] == null && $_POST['surname'] == null && $_POST['password'] == null && $_POST['contactnumber'] == null && $_POST['email'] == null && $_POST['address1'] == null && $_POST['address2'] == null && $_POST['towncity'] == null && $_POST['county'] == null && $_POST['postcode'] == null)
{
$this->error = "You must enter something for at least one field.";
}
else
{
$result = $this->model->editDetails();
if ($result == "failure")
{
$this->error = "That email address is already in use.";
}
if ($result == "success")
{
$_SESSION['message'] = "Your details have been successfully updated.";
header("location: Customer.php");
}
}
}
public function changeAdminPassword() {
if ($_POST['newpassword'] != $_POST['confirmnewpassword']) {
$this->error = "New Password and Confirm New Password do not match.";
}
else {
$message = $this->model->changeAdminPassword();
if ($message == "failure") {
$this->error = "Incorrect current password.";
}
else {
$_SESSION['message_admin']="Admin password successfully changed. Please notify other admins.";
header("location: Admin.php");
}
}
}
public function logout($category) {
session_start();
if(session_destroy()) {
if ($category == "customer") {
header("location: Login.php");
}
else
{
header("location: Admin_Login.php");
}
}
}
}
?>