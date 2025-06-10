<?php
include_once("controller.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/modelo/vehiculo-model.php");

class VehiculoController extends Controller
{
    private $usuarioController;

    public function __construct()
    {
        parent::__construct();
    }

    public function listarVehiculos()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $vehiculos = VehiculoModel::get_vehiculos_usuario($id_usuario);
        $data['vehiculos'] = $vehiculos;
        $this->vista->show('listar-vehiculos', $data);
    }

    public function insertarVehiculo()
    {
        $error = '';
        $data = [];
        $data['marcas'] = VehiculoModel::getMarca() ?? [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $matricula = $_POST['matricula'] ?? null;
            $marca = $_POST['marca'] ?? null;
            $modelo = $_POST['modelo'] ?? null;
            $anio = $_POST['anio'] ?? null;
            $id_usuario = $_SESSION['id_usuario'] ?? null;

            $data['matricula'] = $matricula;
            $data['marca'] = $marca;
            $data['modelo'] = $modelo;
            $data['anio'] = $anio;

            if (!$matricula || !preg_match("/^[0-9]{4}[A-Z]{3}$/", $matricula)) {
                $error .= 'La matrícula debe tener el formato 1234ABC.';
            }

            if (VehiculoModel::existeMatricula($matricula)) {
                $error .= 'Ya existe un vehículo con esa matrícula.';
            }

            if (!$marca || !in_array($marca, $data['marcas'])) {
                $error .= 'Selecciona una marca válido.';
            }

            if (!$modelo || strlen($modelo) > 30) {
                $error .= 'El modelo debe tener menos de 30 caracteres.';
            }

            if (!$anio || !is_numeric($anio) || $anio < 1900 || $anio > date("Y")) {
                $error .= 'El año debe ser válido.';
            }

            if (empty($error)) {
                $vehiculo = new Vehiculo($id_usuario, $matricula, $marca, $modelo, $anio);
                $insertado = VehiculoModel::insertar_vehiculo($vehiculo);
                if ($insertado) {
                    $this->listarVehiculos();
                    return;
                } else {
                    $error .= "No se pudo insertar el vehículo. Asegúrate de no superar el límite de 3 vehículos.";
                }
            }
        }

        $data['errores'] = $error;
        $this->vista->show('formulario-vehiculo', $data);
    }


    public function eliminarVehiculo()
    {
        $id_vehiculo = $_GET['id'] ?? null;
        $id_usuario = $_SESSION['id_usuario'] ?? null;

        if (!$id_vehiculo) {
            $error = 'Vehículo no válido.';
        } elseif (VehiculoModel::vehiculoRelacionadoConEvento($id_vehiculo, $id_usuario)) {
            $error = 'No puedes eliminar este vehículo porque está relacionado con un evento activo. Mínimo un vehículo relacionado con la marca.';
        }

        if (!empty($error ?? '')) {
            $data = [
                'vehiculos' => VehiculoModel::get_vehiculos_usuario($id_usuario),
                'errores' => $error
            ];
            $this->vista->show('listar-vehiculos', $data);
            return;
        }

        $eliminado = VehiculoModel::eliminar_vehiculo($id_usuario, $id_vehiculo);

        if ($eliminado) {
            $this->listarVehiculos();
        } else {
            $data = [
                'vehiculos' => VehiculoModel::get_vehiculos_usuario($id_usuario),
                'errores' => 'No se pudo eliminar el vehículo.'
            ];
            $this->vista->show('listar-vehiculos', $data);
        }
    }



    public function editarVehiculo()
    {
        $data['marcas'] = VehiculoModel::getMarca() ?? [];
        $id_vehiculo = $_GET['id'] ?? null;
        if (!$id_vehiculo) {
            $_SESSION['error'] = "ID de vehículo no válido.";
            header("Location: ?controller=VehiculoController&action=listarVehiculos");
            exit;
        }

        $vehiculo = VehiculoModel::get_vehiculo($id_vehiculo);
        $data['vehiculo'] = $vehiculo;
        $this->vista->show('formulario-modificar-vehiculo', $data);
    }

    public function actualizarVehiculo()
    {
        $data['marcas'] = VehiculoModel::getMarca() ?? [];

        $id_vehiculo = $_POST['id_vehiculo'] ?? null;
        $id_usuario = $_SESSION['id_usuario'] ?? null;
        $matricula = $_POST['matricula'] ?? null;
        $marca = $_POST['marca'] ?? null;
        $modelo = $_POST['modelo'] ?? null;
        $anio = $_POST['anio'] ?? null;

        $error = '';

        if (!$id_vehiculo) {
            $error .= 'Vehículo no válido.';
        }

        if (!$matricula || !preg_match("/^[0-9]{4}[A-Z]{3}$/", $matricula)) {
            $error .= 'La matrícula debe tener el formato 1234ABC.';
        }

        if (VehiculoModel::existeMatricula($matricula, $id_vehiculo)) {
            $error .= 'Ya existe un vehículo con esa matrícula.';
        }

        if (!$marca || strlen($marca) > 30) {
            $error .= 'La marca debe tener menos de 30 caracteres.';
        }

        if (!$modelo || strlen($modelo) > 30) {
            $error .= 'El modelo debe tener menos de 30 caracteres.';
        }

        if (!$anio || !is_numeric($anio) || $anio < 1900 || $anio > date("Y")) {
            $error .= 'El año debe ser válido.';
        }

        $vehiculoActual = VehiculoModel::get_vehiculo($id_vehiculo);

        if ($vehiculoActual && VehiculoModel::vehiculoRelacionadoConEvento($id_vehiculo, $id_usuario)) {
            if ($vehiculoActual->getMarca() !== $marca) {
                $error .= 'No puedes modificar la marca de este vehículo porque está relacionada con un evento activo. Mínimo un vehículo con esta marca.';
            }
        }

        if (empty($error)) {
            $vehiculo = new Vehiculo($id_usuario, $matricula, $marca, $modelo, $anio, $id_vehiculo);
            $actualizado = VehiculoModel::actualizar_vehiculo($vehiculo);
            if ($actualizado) {
                $this->listarVehiculos();
                return;
            } else {
                $error .= "No se pudo actualizar el vehículo.";
            }
        }

        $data['errores'] = $error;
        $data['vehiculo'] = new Vehiculo($id_usuario, $matricula, $marca, $modelo, $anio, $id_vehiculo);
        $this->vista->show('formulario-modificar-vehiculo', $data);
    }
}
