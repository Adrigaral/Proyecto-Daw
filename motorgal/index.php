<?php
session_start();

include_once("controlador/inicio-controller.php");
include_once("controlador/usuario-controller.php");
include_once("controlador/vehiculo-controller.php");
include_once("controlador/evento-controller.php");
include_once("controlador/inscribe-controller.php");

include_once("modelo/usuario-model.php");

$controller = 'InicioController';
$action = 'principal';

if (isset($_REQUEST['controller']) && isset($_REQUEST['action'])) {
    $controller = $_REQUEST['controller'];
    $action = $_REQUEST['action'];
}

$usuario = null;

$id = $_SESSION['id_usuario'] ?? null;
if ($id) {
    $usuario = UsuarioModel::get_usuario($id);
}

$accionesPublicas = [
    'InicioController' => ['principal'],
    'UsuarioController' => ['altaForm', 'altaUsuario', 'loginForm', 'login']
];

$esPublico = isset($accionesPublicas[$controller]) && in_array($action, $accionesPublicas[$controller]);

if ($esPublico || ($usuario instanceof Usuario && UsuarioModel::tienePermiso($usuario, $controller, $action))) {
    try {
        $object = new $controller();
        $object->$action();
    } catch (Throwable $th) {
        $object = new InicioController();
        $object->principal();
    }
} else {
    $object = new InicioController();
    $object->principal();
}
