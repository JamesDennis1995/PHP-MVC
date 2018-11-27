<?php
include ('View.php');
$orderDetails = $controller->getOrderDetails();
echo json_encode($orderDetails);
?>