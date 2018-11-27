<?php
include('Model.php');
include('Controller.php');
class View
{
private $model;
private $controller;
public function __construct($controller,$model) {
$this->controller = $controller;
$this->model = $model;
}
}
$model = new Model();
$controller = new Controller ($model);
$view = new View ($controller, $model);
?>