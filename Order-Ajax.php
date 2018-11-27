<?php
include('View.php');
$stock = $controller->getStock();
if (isset($_POST['stock']) || isset($_POST['addtobasket'])) {
$stockItem = $controller->orderUpdate();
echo json_encode($stockItem);
}
if (isset($_POST['remove']))
{
if (count($_SESSION['basket']) == 0)
{
$controller->error = 'You have nothing in your basket to remove.';
}
else if (!isset($_POST['itemToRemove']) || !isset($_POST['numberToRemove']))
{
$controller->error = 'Please select an item and a quantity.';
}
else
{
$controller->removeItem($stock[$_SESSION['basket'][$_POST['itemToRemove']]->number]["PricePerUnit"]);
}
}
?>