<?php
require_once("modelo/usuario-model.php");
require_once("controlador/inicio-controller.php");
require_once("controlador/usuario-controller.php");
require_once("controlador/vehiculo-controller.php");
require_once("controlador/evento-controller.php");
require_once("controlador/inscribe-controller.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = $_REQUEST['controller'] ?? 'InicioController';
$action = $_REQUEST['action'] ?? 'principal';

if (!isset($_REQUEST['controller']) && !isset($_REQUEST['action'])) {
    if (!empty($_SESSION['loged'])) {
        header('Location: index.php?controller=EventoController&action=lista_eventos_activos');
        exit;
    }
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

if (
    isset($_SESSION['loged']) && $controller === 'UsuarioController' &&
    in_array($action, ['loginForm', 'login', 'altaForm', 'altaUsuario'])
) {
    header('Location: index.php?controller=EventoController&action=lista_eventos_activos');
    exit;
}

$esPublico = isset($accionesPublicas[$controller]) && in_array($action, $accionesPublicas[$controller]);

if ($esPublico || ($usuario instanceof Usuario && UsuarioModel::tienePermiso($usuario, $controller, $action))) {
    try {
        $obj = new $controller();
        $obj->$action();
    } catch (Throwable $th) {
        (new InicioController())->principal();
    }
} else {
    (new InicioController())->principal();
}
