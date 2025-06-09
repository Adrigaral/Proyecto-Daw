<?php
include_once("controller.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/controlador/usuario-controller.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/controlador/evento-controller.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/modelo/inscribe-model.php");
class InscribeController extends Controller
{
    public function verInscritos()
    {
        $id_evento = $_GET['id_evento'] ?? null;

        if ($id_evento) {
            $inscritos = InscribeModel::get_usuarios_y_vehiculos_inscritos($id_evento);
            $this->vista->show('inscritos-evento', ['inscritos' => $inscritos]);
        } else {
            $this->vista->show('error', ['mensaje' => 'ID de evento no proporcionado.']);
        }
    }

    public function inscribirse()
    {
        session_start();
        $id_usuario = $_POST['id_usuario'] ?? null;
        $id_evento = $_POST['id_evento'] ?? null;

        EventoModel::actualizar_estados_automaticamente();

        if (!$id_usuario || !$id_evento) {
            $_SESSION['error'] = "Faltan datos para inscribirse.";
            header("Location: index.php?controller=EventoController&action=ver_evento&id=$id_evento");
            exit;
        }

        $evento = EventoModel::get_evento($id_evento);
        if (!$evento) {
            $_SESSION['error'] = "Evento no encontrado.";
            header("Location: index.php?controller=EventoController&action=ver_evento&id=$id_evento");
            exit;
        }
        $marcaRequerida = $evento->getRequisitos();

        $vehiculosUsuario = VehiculoModel::get_vehiculos_usuario($id_usuario);

        $puedeInscribirse = false;
        foreach ($vehiculosUsuario as $vehiculo) {
            if (strtolower($vehiculo->getMarca()) === strtolower($marcaRequerida)) {
                $puedeInscribirse = true;
                break;
            }
        }

        if ($puedeInscribirse) {
            $fecha_inscripcion = new DateTime();
            $inscripcion = new Inscribe($id_usuario, $id_evento, $fecha_inscripcion);

            $resultado = InscribeModel::inscribirseEvento($inscripcion);
            if ($resultado) {
                $_SESSION['mensaje'] = "Te has inscrito correctamente en el evento.";
            } else {
                $_SESSION['error'] = "No es posible inscribirse en este evento.";
            }
        } else {
            $_SESSION['error'] = "No puedes inscribirte: necesitas un coche de la marca '$marcaRequerida'.";
        }

        header("Location: index.php?controller=EventoController&action=ver_evento&id=$id_evento");
        exit;
    }




    public function quitarInscripcion()
    {
        session_start();

        $id_usuario = $_POST['id_usuario'] ?? null;
        $id_evento = $_POST['id_evento'] ?? null;

        EventoModel::actualizar_estados_automaticamente();

        if (!$id_usuario || !$id_evento) {
            $_SESSION['error'] = "Faltan datos para quitar la inscripción.";
            header("Location: index.php?controller=EventoController&action=lista_eventos_activos");
            exit;
        }

        $resultado = InscribeModel::quitarInscripcion($id_usuario, $id_evento);

        if ($resultado) {
            $_SESSION['mensaje'] = "Te has desinscrito correctamente del evento.";
        } else {
            $_SESSION['error'] = "No es posible quitar la inscripción. Asegúrate de que el evento esté ACTIVO.";
        }

        header("Location: index.php?controller=EventoController&action=ver_evento&id=" . urlencode($id_evento));
        exit;
    }


    public function inscribir_usuario()
    {
        $id_evento = $_POST['id_evento'] ?? null;
        $id_usuario = $_SESSION['id_usuario'] ?? null;

        EventoModel::actualizar_estados_automaticamente();

        $error = '';
        if (!$id_evento || !$id_usuario) {
            $error = "Datos de inscripción inválidos.";
        } else {
            $id_creador = EventoModel::obtenerCreadorEvento($id_evento);

            if ($id_creador === null) {
                $error = "El evento no existe.";
            } elseif ($id_creador == $id_usuario) {
                $error = "No puedes inscribirte a tu propio evento.";
            } else {
                $fecha_inscripcion = new DateTime();
                $inscripcion = new Inscribe($id_usuario, $id_evento, $fecha_inscripcion);

                $resultado = InscribeModel::inscribirseEvento($inscripcion);
                if ($resultado) {
                    $_SESSION['mensaje'] = "Te has inscrito correctamente en el evento.";
                } else {
                    $error = "No es posible inscribirse en este evento. Verifica si el evento está activo.";
                }
            }
        }

        $data = [];
        if ($error) {
            $data['errores'] = $error;
        }

        $this->vista->show('lista-eventos', $data);
    }
}
