<?php
include_once("controller.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/controlador/usuario-controller.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/modelo/evento-model.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/modelo/vehiculo-model.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/modelo/inscribe-model.php");
class EventoController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function inicio()
    {
        $this->vista->show('eventos');
    }

    public function lista_eventos_activos()
{
    session_start();
    $modelo = $_GET['modelo'] ?? null;
    $lugar = $_GET['lugar'] ?? null;

    // Paginación
    $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $limite = 6; // Número de eventos por página
    $offset = ($pagina_actual - 1) * $limite;

    EventoModel::actualizar_estados_automaticamente();

    // Obtiene los modelos disponibles para el filtro
    $modelos = VehiculoModel::getMarca();

    // Obtiene el total de eventos (sin paginar)
    $total_eventos = EventoModel::contarEventosFiltrados($modelo, $lugar);
    $total_paginas = ceil($total_eventos / $limite);

    // Obtiene los eventos filtrados con límite y offset
    $eventos = EventoModel::filtrarEventos($modelo, $lugar, $limite, $offset);

    // Obtiene el último evento activo
    $ultimo_evento_activo = EventoModel::get_ultimo_evento_activo();

    $id_usuario = $_SESSION['id_usuario'] ?? null;
    $eventos_con_estado = [];

    foreach ($eventos as $evento) {
        $inscrito = false;
        if ($id_usuario) {
            $inscrito = InscribeModel::estaInscrito($id_usuario, $evento->getId_evento());
        }
        $eventos_con_estado[] = [
            'evento' => $evento,
            'inscrito' => $inscrito
        ];
    }

    $this->vista->show('lista-eventos', [
        'eventos' => $eventos_con_estado,
        'modelo' => $modelo,
        'lugar' => $lugar,
        'modelos' => $modelos,
        'ultimo_evento_activo' => $ultimo_evento_activo,
        'pagina_actual' => $pagina_actual,
        'total_paginas' => $total_paginas
    ]);
}


    public function ver_evento()
    {
        session_start();
        $id_evento = $_GET['id'] ?? null;

        EventoModel::actualizar_estados_automaticamente();

        if ($id_evento) {
            $evento = EventoModel::get_evento((int)$id_evento);

            if ($evento) {
                $id_usuario = $_SESSION['id_usuario'] ?? null;
                $inscrito = false;

                if ($id_usuario) {
                    $inscrito = InscribeModel::estaInscrito($id_usuario, $evento->getId_evento());
                }

                $this->vista->show('detalle-evento', [
                    'evento' => $evento,
                    'inscrito' => $inscrito
                ]);
            } else {
                header("Location: index.php?controller=EventoController&action=lista_eventos_activos");
                exit;
            }
        } else {
            header("Location: index.php?controller=EventoController&action=lista_eventos_activos");
            exit;
        }
    }


    public function lista_eventos()
    {
        $modelo = $_GET['modelo'] ?? null;
        $lugar = $_GET['lugar'] ?? null;

        $eventos = EventoModel::filtrarEventos($modelo, $lugar);

        $data = [
            'eventos' => $eventos,
            'modelo' => $modelo,
            'lugar' => $lugar
        ];

        $this->vista->show('lista-eventos', $data);
    }

    public function crear_evento()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = $_SESSION['id_usuario'] ?? null;
            $titulo = trim($_POST['titulo'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $fecha_inicio_evento = $_POST['fecha_inicio_evento'] ?? '';
            $fecha_fin_evento = $_POST['fecha_fin_evento'] ?? '';
            $limite_plazas = (int)($_POST['limite_plazas'] ?? 0);
            $requisitos = $_POST['requisitos'] ?? '';
            $lugar = trim($_POST['lugar'] ?? '');
            $precio = (float)($_POST['precio'] ?? 0);
            $foto_evento = trim($_POST['foto_evento'] ?? '');

            if (!$id_usuario || !$titulo || !$descripcion || !$fecha_inicio_evento || !$fecha_fin_evento || !$lugar || !$precio || !$foto_evento) {
                $error .= "Todos los campos obligatorios deben ser completados.";
            }

            if (empty($error)) {
                try {
                    $fecha_inicio = new DateTime($fecha_inicio_evento);
                    $fecha_fin = new DateTime($fecha_fin_evento);

                    if ($fecha_fin < $fecha_inicio) {
                        $error .= "La fecha de fin no puede ser anterior a la de inicio.";
                    }
                } catch (Exception $e) {
                    $error .= "Formato de fecha inválido.";
                }
            }

            if (empty($error)) {
                $evento = new Evento(
                    $id_usuario,
                    $titulo,
                    $descripcion,
                    $fecha_inicio,
                    $fecha_fin,
                    'ACTIVO',
                    $limite_plazas,
                    $requisitos,
                    $lugar,
                    $precio,
                    $foto_evento
                );

                $creado = EventoModel::crearEvento($evento);
                if ($creado) {
                    $_SESSION['mensaje'] = "Evento creado correctamente.";
                    $this->vista->show('perfil-usuario');
                    return;
                } else {
                    $error .= "Error al crear el evento.";
                }
            }
        }

        $data = [];
        if (!empty($error)) {
            $data['errores'] = $error;
        }
        $this->vista->show('formulario-crear-evento', $data);
    }

    public function modificar_evento()
    {
        $id_evento = $_GET['id_evento'] ?? null;
        $error = '';
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $fecha_inicio_evento = $_POST['fecha_inicio_evento'] ?? '';
            $fecha_fin_evento = $_POST['fecha_fin_evento'] ?? '';
            $lugar = $_POST['lugar'] ?? '';
            $precio = (float)($_POST['precio'] ?? 0);
            $foto_evento = trim($_POST['foto_evento'] ?? '');

            if (empty($titulo) || empty($descripcion) || empty($fecha_inicio_evento) || empty($fecha_fin_evento) || empty($lugar) || empty($precio) || empty($foto_evento)) {
                $error .= "Todos los campos son obligatorios.";
            }

            if (empty($error)) {
                try {
                    $fecha_inicio_dt = new DateTime($fecha_inicio_evento);
                    $fecha_fin_dt = new DateTime($fecha_fin_evento);
                } catch (Exception $e) {
                    $error .= "Formato de fecha inválido.";
                }
            }

            if (empty($error)) {
                $modificado = EventoModel::actualizar_evento(
                    $id_evento,
                    $titulo,
                    $descripcion,
                    $fecha_inicio_dt,
                    $fecha_fin_dt,
                    $lugar,
                    $precio,
                    $foto_evento
                );

                if ($modificado) {
                    $_SESSION['mensaje'] = "Evento actualizado correctamente.";
                    $this->vista->show('lista-eventos');
                    return;
                } else {
                    $error .= "Error al actualizar el evento.";
                }
            }

            if (!empty($error)) {
                $data['errores'] = $error;
            }
        }

        if ($id_evento && $_SERVER['REQUEST_METHOD'] === 'GET') {
            $evento = EventoModel::get_evento($id_evento);
            if ($evento) {
                $data['evento'] = $evento;
            } else {
                $data['errores'] = "Evento no encontrado.";
            }
        }

        $this->vista->show('formulario-modificar-evento', $data);
    }

    public function actualizar_estado_manual()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_evento = $_POST['id_evento'] ?? null;
            $nuevo_estado = $_POST['nuevo_estado'] ?? '';

            $error = '';
            if (!$id_evento || !in_array(strtoupper($nuevo_estado), ['ACTIVO', 'CANCELADO'])) {
                $error = "Datos inválidos para actualizar el estado.";
            } else {
                $resultado = EventoModel::actualizar_estado_evento($id_evento, $nuevo_estado);
                if ($resultado) {
                    $_SESSION['mensaje'] = "Estado del evento actualizado a $nuevo_estado correctamente.";
                } else {
                    $error = "Error al actualizar el estado.";
                }
            }

            $data = [];
            if ($error) {
                $data['errores'] = $error;
            }
            $this->vista->show('lista-eventos', $data);
        }
    }

    public function eliminar_evento()
    {
        $id_evento = $_POST['id_evento'] ?? null;
        $error = '';

        if (!$id_evento) {
            $error = "Falta el ID del evento.";
        }

        if (empty($error)) {
            $resultado = EventoModel::eliminar_o_cancelar_evento((int)$id_evento);
            if ($resultado) {
                $_SESSION['mensaje'] = "Evento eliminado o cancelado correctamente.";
            } else {
                $error = "No se pudo eliminar o cancelar el evento.";
            }
        }

        $data = [];
        if (!empty($error)) {
            $data['errores'] = $error;
        }

        $this->vista->show('lista-eventos', $data);
    }
}
