<?php

include_once("controlador/inicio-controller.php");
include_once("controlador/usuario-controller.php");
include_once("controlador/vehiculo-controller.php");
include_once("controlador/evento-controller.php");
include_once("controlador/inscribe-controller.php");

$controller = 'InicioController';
$action = 'principal';

if (isset($_REQUEST['controller']) && isset($_REQUEST['action'])) {
    $controller = $_REQUEST['controller'];
    $action = $_REQUEST['action'];
}
try {
    $object = new $controller();
    $object->$action();
} catch (\Throwable $th) {
    $object = new InicioController();
    $object->principal();
}
