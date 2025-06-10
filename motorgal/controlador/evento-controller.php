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
        $modelo = $_GET['modelo'] ?? null;
        $lugar = $_GET['lugar'] ?? null;
        $id_usuario = $_SESSION['id_usuario'] ?? null;

        // Paginación
        $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $limite = 6; // Número de eventos por página
        $offset = ($pagina_actual - 1) * $limite;

        EventoModel::actualizar_estados_automaticamente();

        // Obtiene los modelos disponibles para el filtro
        $modelos = VehiculoModel::getMarca();

        // Obtiene el total de eventos (sin paginar)
        $total_eventos = EventoModel::contarEventosFiltrados($id_usuario, $modelo, $lugar);
        $total_paginas = ceil($total_eventos / $limite);

        // Obtiene los eventos filtrados con límite y offset
        $eventos = EventoModel::filtrarEventos($id_usuario, $modelo, $lugar, $limite, $offset);

        // Obtiene el último evento activo
        $ultimo_evento_activo = EventoModel::get_ultimo_evento_activo($id_usuario);

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

    public function lista_eventos_creados()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $lugar = $_GET['lugar'] ?? null;
        $estado = $_GET['estado'] ?? null;
        $requisitoSelect = $_GET['requisitos'] ?? null;

        $pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
        $limite = 6;
        $offset = ($pagina - 1) * $limite;

        EventoModel::actualizar_estados_automaticamente();
        $eventos = EventoModel::filtrarEventosCreados($id_usuario, $requisitoSelect, $lugar, $estado, $limite, $offset);
        $total_eventos = EventoModel::contarEventosCreados($id_usuario, $requisitoSelect, $lugar, $estado);
        $total_paginas = ceil($total_eventos / $limite);

        $requisitos = VehiculoModel::getMarca();

        $data = [
            'eventos' => $eventos,
            'requisitos' => $requisitos,
            'lugar' => $lugar,
            'estado' => $estado,
            'requisito' => $requisitoSelect,
            'pagina_actual' => $pagina,
            'total_paginas' => $total_paginas
        ];

        $this->vista->show('lista-eventos-organizador', $data);
    }

    public function listarEventosUsuario()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $lugar = $_GET['lugar'] ?? null;
        $estado = $_GET['estado'] ?? null;
        $requisitoSelect = $_GET['requisitos'] ?? null;

        $pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
        $limite = 6;
        $offset = ($pagina - 1) * $limite;

        EventoModel::actualizar_estados_automaticamente();
        $eventos = EventoModel::filtrarEventosUsuario($id_usuario, $requisitoSelect, $lugar, $estado, $limite, $offset);
        $total_eventos = EventoModel::contarEventosUsuario($id_usuario, $requisitoSelect, $lugar, $estado);
        $total_paginas = ceil($total_eventos / $limite);

        $requisitos = VehiculoModel::getMarca();

        $data = [
            'eventos' => $eventos,
            'requisitos' => $requisitos,
            'lugar' => $lugar,
            'estado' => $estado,
            'requisito' => $requisitoSelect,
            'pagina_actual' => $pagina,
            'total_paginas' => $total_paginas
        ];

        $this->vista->show('lista-eventos-usuario', $data);
    }


    public function ver_evento()
    {
        $id_evento = $_GET['id'] ?? null;
        $matricula = $_GET['matricula'] ?? null;
        $limite = 6;
        $pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
        $offset = ($pagina - 1) * $limite;

        EventoModel::actualizar_estados_automaticamente();
        $creador = EventoModel::obtenerCreadorEvento($id_evento);
        $inscrito = InscribeModel::estaInscrito($_SESSION['id_usuario'], $id_evento);

        if ($id_evento) {
            $evento = EventoModel::get_evento((int)$id_evento);
            $inscritos = EventoModel::getInscritosEvento((int)$id_evento, $limite, $offset, $matricula);
            $totalInscritos = EventoModel::contarInscritosEvento($id_evento);

            // Calcular total de páginas
            $total_paginas = (int) ceil($totalInscritos / $limite);

            if ($evento) {
                $this->vista->show('detalle-evento', [
                    'evento' => $evento,
                    'creador' => $creador,
                    'inscrito' => $inscrito,
                    'inscritos' => $inscritos,
                    'totalInscritos' => $totalInscritos,
                    'pagina_actual' => $pagina,
                    'total_paginas' => $total_paginas,
                    'matricula' => $matricula
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

    public function crear_evento()
    {
        $error = '';

        $data['requisitos'] = VehiculoModel::getMarca();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = $_SESSION['id_usuario'] ?? null;
            $titulo = trim($_POST['titulo'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $fecha_inicio_evento = $_POST['fecha_inicio_evento'] ?? '';
            $fecha_fin_evento = $_POST['fecha_fin_evento'] ?? '';
            $limite_plazas = (int)($_POST['limite_plazas'] ?? 0);
            $requisito_seleccionado  = $_POST['requisitos'] ?? '';
            $lugar = trim($_POST['lugar'] ?? '');
            $precio = (float)($_POST['precio'] ?? 0);
            $latitud = isset($_POST['latitud']) ? (float)$_POST['latitud'] : null;
            $longitud = isset($_POST['longitud']) ? (float)$_POST['longitud'] : null;
            $foto_evento = '';
            $data['requisitos'] = $requisito_seleccionado;

            if (!$id_usuario || !$titulo || !$descripcion || !$fecha_inicio_evento || !$fecha_fin_evento || !$lugar || !is_numeric($precio) || !is_numeric($latitud) || !is_numeric($longitud)) {
                $error .= "Todos los campos obligatorios deben ser completados.";
            }

            if (empty($error)) {
                try {
                    $fecha_inicio = new DateTime($fecha_inicio_evento);
                    $fecha_fin = new DateTime($fecha_fin_evento);

                    if ($fecha_fin < $fecha_inicio) {
                        $error .= "La fecha de fin no puede ser anterior a la de inicio.";
                    }
                } catch (Exception) {
                    $error .= "Formato de fecha inválido.";
                }
            }

            if ($precio < 0) {
                $error .= "El precio no puede ser negativo.<br>";
            }

            $ext = strtolower(pathinfo($_FILES['foto_evento']['name'], PATHINFO_EXTENSION));
            $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (in_array($ext, $permitidas)) {
                $nombreArchivo = uniqid('evento_') . '.' . $ext;
                $rutaSubida = realpath(__DIR__ . '/../img/uploads');

                if ($rutaSubida && is_dir($rutaSubida) && is_writable($rutaSubida)) {
                    $destino = $rutaSubida . '/' . $nombreArchivo;

                    if (move_uploaded_file($_FILES['foto_evento']['tmp_name'], $destino)) {
                        $foto_evento = $nombreArchivo;
                    } else {
                        $error .= "Error al mover la imagen subida.<br>";
                    }
                } else {
                    $error .= "El directorio de subida no existe o no tiene permisos de escritura.<br>";
                }
            } else {
                $error .= "Formato de imagen no permitido.<br>";
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
                    $requisito_seleccionado,
                    $lugar,
                    $precio,
                    $foto_evento,
                    $latitud,
                    $longitud
                );

                $creado = EventoModel::crearEvento($evento);
                if ($creado) {
                    $_SESSION['mensaje'] = "Evento creado correctamente.";
                    header('Location: index.php?controller=EventoController&action=lista_eventos_creados');
                    return;
                } else {
                    $error .= "Error al crear el evento.";
                }
            }
        }

        if (!empty($error)) {
            $data['errores'] = $error;
        }
        $this->vista->show('formulario-crear-evento', $data);
    }


    public function modificar_evento()
    {
        $id_evento = $_GET['id'] ?? $_POST['id_evento'] ?? null;
        $error     = '';
        $data      = [];

        EventoModel::actualizar_estados_automaticamente();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $fechaInicio = trim($_POST['fecha_inicio_evento'] ?? '');
            $fechaFin = trim($_POST['fecha_fin_evento'] ?? '');
            $lugar = trim($_POST['lugar'] ?? '');
            $limitePlazas = ($_POST['limite_plazas'] !== '') ? (int)$_POST['limite_plazas'] : null;
            $requisitos = $_POST['requisitos'] ?? null;
            $precio = (float)($_POST['precio'] ?? 0);
            $latitud = isset($_POST['latitud'])  ? (float)$_POST['latitud'] : null;
            $longitud = isset($_POST['longitud']) ? (float)$_POST['longitud'] : null;

            $foto_evento = $_POST['foto_evento_actual'] ?? null;

            if (!empty($_FILES['foto_evento']['name'])) {
                $extPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $ext = strtolower(pathinfo($_FILES['foto_evento']['name'], PATHINFO_EXTENSION));

                if (!in_array($ext, $extPermitidas)) {
                    $error .= "Formato de imagen no permitido.<br>";
                } else {
                    $nombreArchivo = uniqid('evento_') . '.' . $ext;
                    $rutaSubida    = realpath(__DIR__ . '/../img/uploads');

                    if ($rutaSubida && is_dir($rutaSubida) && is_writable($rutaSubida)) {
                        $destino = $rutaSubida . '/' . $nombreArchivo;

                        if (move_uploaded_file($_FILES['foto_evento']['tmp_name'], $destino)) {
                            $foto_evento = $nombreArchivo;
                        } else {
                            $error .= "Error al mover la imagen subida.<br>";
                        }
                    } else {
                        $error .= "El directorio de subida no existe o no tiene permisos de escritura.<br>";
                    }
                }
            }

            if (!$titulo || !$descripcion || !$fechaInicio || !$fechaFin || !$lugar || !is_numeric($precio) || $precio < 0 || !is_numeric($latitud)  || !is_numeric($longitud)) {
                $error .= "Todos los campos obligatorios deben ser completados.<br>";
            }

            if (empty($error)) {
                try {
                    $dtInicio = new DateTime($fechaInicio);
                    $dtFin    = new DateTime($fechaFin);

                    if ($dtFin < $dtInicio) {
                        $error .= "La fecha de fin no puede ser anterior a la de inicio.<br>";
                    }
                } catch (Exception) {
                    $error .= "Formato de fecha inválido.<br>";
                }
                $inscritosActuales = EventoModel::contarInscritosEvento($id_evento);

                if ($limitePlazas !== null && $limitePlazas < $inscritosActuales) {
                    $error .= "No puedes fijar el límite de plazas a {$limitePlazas} porque ya hay {$inscritosActuales} inscritos.<br>";
                }
            }

            if (empty($error)) {
                $ok = EventoModel::actualizar_evento(
                    (int)$id_evento,
                    $dtInicio,
                    $dtFin,
                    $lugar,
                    $titulo,
                    $descripcion,
                    $limitePlazas,
                    $requisitos,
                    $precio,
                    $foto_evento,
                    $latitud,
                    $longitud
                );

                if ($ok) {
                    $_SESSION['mensaje'] = "Evento actualizado correctamente.";
                    header("Location: index.php?controller=EventoController&action=lista_eventos_creados");
                    exit;
                }
                $error .= "No se pudo actualizar el evento.<br>";
            }

            if ($error !== '') {
                $_SESSION['errores'] = $error;
                header("Location: index.php?controller=EventoController&action=modificar_evento&id=" . urlencode($id_evento));
                exit;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $id_evento) {
            $evento = EventoModel::get_evento((int)$id_evento);

            if ($evento) {
                $data['evento'] = $evento;
                $data['requisitos'] = VehiculoModel::getMarca();
            } else {
                $_SESSION['errores'] = "Evento no encontrado.";
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
        $id_evento = $_GET['id'] ?? null;
        $error = '';

        EventoModel::actualizar_estados_automaticamente();

        if (!$id_evento) {
            $error .= "Falta el ID del evento.";
        }

        if (empty($error)) {
            $resultado = EventoModel::eliminar_o_cancelar_evento($id_evento);
            if ($resultado) {
                $_SESSION['mensaje'] = "Evento eliminado o cancelado correctamente. Ten en cuenta que si el evento cuenta con inscripciones, el evento no se elimina pero sí se cancela.";
            } else {
                $error .= "No se pudo eliminar o cancelar el evento.";
            }
        }

        if (!empty($error)) {
            $_SESSION['errores'] = $error;
        }

        header("Location: index.php?controller=EventoController&action=lista_eventos_creados");
        exit;
    }
}
