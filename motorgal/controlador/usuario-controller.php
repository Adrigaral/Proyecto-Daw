<?php
include_once("controller.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/modelo/usuario-model.php");
class UsuarioController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function inicio()
    {
        $this->vista->show('inicio-usuario');
    }

    public function logout()
    {
        // Eliminamos todas las variables de sesión
        session_unset();

        // Obtenemos los parámetros de la cookie de sesión
        $params = session_get_cookie_params();

        // Eliminamos la cookie de sesión
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

        // Eliminamos también la cookie personalizada de tiempo (t_reset)
        setcookie("t_reset", '', time() - 42000, "/", "", true, true);

        // Destruimos la sesión
        session_destroy();

        // Redirigimos al usuario a la página de inicio de sesión
        header("Location: index.php");
    }


    public function altaForm()
    {
        //$this->restart_sesion();
        $this->vista->show('alta-usuario');
    }

    public function loginForm()
    {
        $this->vista->show('inicio-usuario');
    }


    public function login()
    {
        $username = $_POST['username'] ?? null;
        $contrasinal = $_POST['contrasinal'] ?? null;
        $error = "";

        if ($username && $contrasinal) {
            $tipo_usuario = UsuarioModel::comprobar_usuario($username, $contrasinal);
            $id_usuario = UsuarioModel::get_id_usuario($username);
            $_SESSION['id_usuario'] = $id_usuario;
            $_SESSION['loged'] = $username;
            $_SESSION['tipo'] = $tipo_usuario;

            // Cookies seguras
            $params = session_get_cookie_params();
            setcookie(session_name(), session_id(), $params["lifetime"], $params["path"], $params["domain"], true, true);
            setcookie("t_reset", "on", time() + 600, "", "", true, true);

            header("Location: index.php?controller=EventoController&action=lista_eventos_activos");
            exit;
        } else {
            $error .= 'Faltan campos del formulario.';
        }

        $data['errores'] = $error;
        $this->vista->show('inicio-usuario', $data);
    }


    public function altaUsuario()
    {

        //Recuperar campos
        $dni = $_POST['dni'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $correo_electronico = $_POST['correo_electronico'] ?? null;
        $username = $_POST['username'] ?? null;
        $contrasinal = $_POST['contrasinal'] ?? null;
        $tipo_usuario = isset($_POST['tipo_usuario']) ? 2 : 1;
        $foto_perfil = "../img/Porsche.jpg";
        $estado_usuario = 'ACTIVO';
        $error = '';

        //Validar campos
        if (!isset($dni) || !UsuarioModel::validarDNI($dni)) {
            $error .= 'El dni no es válido.';
        }
        if (UsuarioModel::existe_dni($dni)) {
            $error .= "El dni ya existe.";
        }
        if (!isset($nombre) || strlen($nombre) > 50) {
            $error .= 'El nombre completo tiene que tener menos de 50 caracteres.';
        }
        if (isset($correo_electronico)) {
            $correo_electronico = filter_var($correo_electronico, FILTER_VALIDATE_EMAIL);
            if (!$correo_electronico) {
                $error .= 'Formato del email incorrecto';
            }
        }
        if (!isset($username) || strlen($username) > 30) {
            $error .= 'El nombre de usuario tiene que tener menos de 30 caracteres.';
        }
        if (UsuarioModel::existe_username($username)) {
            $error .= "El nombre de usuario ya existe.";
        }
        if (!isset($contrasinal) || strlen($contrasinal) < 8) {
            $error .= 'La contraseña debe tener como mínimo 8 caracteres.';
        }

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = uniqid() . '_' . basename($_FILES['foto']['name']);
            $rutaFinal = '../img/uploads/' . $nombreArchivo;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFinal)) {
                $foto_perfil = $rutaFinal;
            }
        }

        $data = [];

        if (empty($error)) {
            $usuario = new Usuario($dni, $nombre, $correo_electronico, $username, $contrasinal, $tipo_usuario, $estado_usuario, $foto_perfil);
            $insertado = UsuarioModel::insertar_usuario($usuario);
            if ($insertado) {
                $id_usuario = UsuarioModel::get_id_usuario($username);
                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION['loged'] = $username;
                $_SESSION['tipo'] = $tipo_usuario;
    
                // Cookies seguras
                $params = session_get_cookie_params();
                setcookie(session_name(), session_id(), $params["lifetime"], $params["path"], $params["domain"], true, true);
                setcookie("t_reset", "on", time() + 600, "", "", true, true);
    
                header("Location: index.php?controller=EventoController&action=lista_eventos_activos");
                exit;
            } else {
                $error .= "Error al insertar el usuario en la base de datos.";
            }
        }

        if (!empty($error)) {
            $data['errores'] = $error;
            $this->vista->show('alta-usuario', $data);
        }
    }

    public function cambia_correo()
    {

        //Recuperar campos
        $correo_electronico = $_POST['correo_electronico'] ?? null;
        $error = '';

        //Validar campos
        if (isset($correo_electronico)) {
            $correo_electronico = filter_var($correo_electronico, FILTER_VALIDATE_EMAIL);
            if (!$correo_electronico) {
                $error .= 'Formato del email incorrecto';
            }
        }

        $data = [];

        if (empty($error)) {
            $id_usuario = $_SESSION['id_usuario'];
            $actualizado = UsuarioModel::actualizar_campo($id_usuario, 'correo_electronico', $correo_electronico);
            if ($actualizado) {
                $this->vista->show('perfil-usuario');
            } else {
                $error .= "Error al actualizar el correo del usuario en la base de datos.";
            }
        }

        if (!empty($error)) {
            $data['errores'] = $error;
        }
        $this->vista->show('perfil-usuario', $data);
    }

    public function cambia_contra()
    {

        //Recuperar campos
        $contrasinal_actual = $_POST['contrasinal_actual'] ?? null;
        $nueva_contrasinal = $_POST['nueva_contrasinal'] ?? null;
        $error = '';

        //Validar campos
        if (isset($contrasinal_actual) && isset($nueva_contrasinal)) {
            $id_usuario = $_SESSION['id_usuario'];
            $usuario = UsuarioModel::get_usuario($id_usuario);
            if ($usuario) {
                $hash_contrasinal = $usuario->getContrasinal();
                // Comparar contraseñas con sha1
                if (sha1($contrasinal_actual) === $hash_contrasinal) {
                    $nuevo_hash = sha1($nueva_contrasinal);
                } else {
                    $error .= "La contraseña actual es incorrecta.";
                }
            } else {
                $error .= "Usuario no encontrado.";
            }
        }


        $data = [];

        if (empty($error)) {
            $id_usuario = $_SESSION['id_usuario'];
            $actualizado = UsuarioModel::actualizar_campo($id_usuario, 'contrasinal', $nuevo_hash);
            if ($actualizado) {
                $this->vista->show('perfil-usuario');
            } else {
                $error .= "Error al actualizar la contraseña del usuario en la base de datos.";
            }
        }

        if (!empty($error)) {
            $data['errores'] = $error;
        }
        $this->vista->show('perfil-usuario', $data);
    }

    public function cambia_foto()
    {

        $error = '';

        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $archivo = $_FILES['foto_perfil'];
            $nombre_original = basename($archivo['name']);
            $extension = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));

            // Validar extensión permitida
            $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($extension, $extensiones_permitidas)) {
                $error .= "Formato de archivo no permitido. ";
            } else {
                $nuevo_nombre = uniqid('foto_', true) . '.' . $extension;
                $ruta_subida = __DIR__ . '/../public/img/uploads/' . $nuevo_nombre;

                // Mover el archivo
                if (!move_uploaded_file($archivo['tmp_name'], $ruta_subida)) {
                    $error .= "Error al guardar la imagen.";
                }
            }
        } else {
            $error .= "No se pudo subir la imagen.";
        }

        $data = [];

        if (empty($error)) {
            $id_usuario = $_SESSION['id_usuario'];
            $actualizado = UsuarioModel::actualizar_campo($id_usuario, 'foto_perfil', $nuevo_nombre);

            if ($actualizado) {
                $this->vista->show('perfil-usuario');
                return;
            } else {
                $error .= "Error al actualizar la foto de perfil en la base de datos.";
            }
        }

        if (!empty($error)) {
            $data['errores'] = $error;
        }
        $this->vista->show('perfil-usuario', $data);
    }

    public function cambia_estado()
    {
        $id_usuario = $_SESSION['id_usuario'] ?? null;
        $error = '';

        if ($id_usuario) {
            $usuario = UsuarioModel::get_usuario($id_usuario);
            if ($usuario) {
                $estado_actual = $usuario->getEstado_usuario();
                $nuevo_estado = ($estado_actual === 'ACTIVO') ? 'BLOQUEADO' : 'ACTIVO';
            } else {
                $error .= "Usuario no encontrado.";
            }
        } else {
            $error .= "Datos incompletos para actualizar el estado.";
        }

        // Mostrar resultado
        $data = [];

        if (empty($error)) {
            $actualizado = UsuarioModel::actualizar_campo($id_usuario, 'estado_usuario', $nuevo_estado);

            if ($actualizado) {
                $this->vista->show('perfil-usuario');
                return; // Terminar para evitar seguir con la ejecución
            } else {
                $error .= "Error al actualizar la foto de perfil en la base de datos.";
            }
        }

        if (!empty($error)) {
            $data['errores'] = $error;
        }
        $this->vista->show('lista-usuarios', $data);
    }
}
