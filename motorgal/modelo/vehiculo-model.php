<?php
include_once("conexionBD.php");
class Vehiculo
{
    private int $id_vehiculo;
    private int $id_usuario;
    private string $matricula;
    private string $marca;
    private string $modelo;
    private int $anio;

    function __construct(int $id_usuario, string $matricula, string $marca, string $modelo, int $anio, int $id = null)
    {
        if (isset($id)) {
            $this->id_vehiculo = $id;
        }
        $this->id_usuario = $id_usuario;
        $this->matricula = $matricula;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->anio = $anio;
    }

    /**
     * Get the value of id_vehiculo
     */
    public function getId_vehiculo()
    {
        return $this->id_vehiculo;
    }

    /**
     * Set the value of id_vehiculo
     *
     * @return  self
     */
    public function setId_vehiculo($id_vehiculo)
    {
        $this->id_vehiculo = $id_vehiculo;

        return $this;
    }

    /**
     * Get the value of id_usuario
     */
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     * Set the value of id_usuario
     *
     * @return  self
     */
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    /**
     * Get the value of matricula
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set the value of matricula
     *
     * @return  self
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get the value of marca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set the value of marca
     *
     * @return  self
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get the value of modelo
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set the value of modelo
     *
     * @return  self
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get the value of anio
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set the value of anio
     *
     * @return  self
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }
}

class VehiculoModel
{

    public static function obtener_tipos_vehiculo(): array
    {
        $pdo = conexionBD::get();
        $sql = "SELECT modelo FROM vehiculos";
        $modelo = [];

        try {
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $modelo = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error obteniendo modelo de vehículo: " . $e->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }

        return $modelo;
    }

    public static function get_vehiculo(int $id_vehiculo): ?Vehiculo
    {
        $pdo = conexionBD::get();
        $sql = "SELECT id_vehiculo, id_usuario, matricula, marca, modelo, anio FROM vehiculos WHERE id_vehiculo = ?";
        $vehiculo = null;

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $id_vehiculo, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                $vehiculo = new Vehiculo(
                    $resultado['id_usuario'],
                    $resultado['matricula'],
                    $resultado['marca'],
                    $resultado['modelo'],
                    $resultado['anio'],
                    $resultado['id_vehiculo']
                );
            }
        } catch (PDOException $e) {
            error_log("Error obteniendo vehículo por ID: " . $e->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }

        return $vehiculo;
    }


    public static function tiene_vehiculos(int $id_usuario): bool
    {
        $pdo = conexionBD::get();
        $sql = "SELECT COUNT(*) as total FROM vehiculos WHERE id_usuario = ?";
        $toret = false;

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $id_usuario, PDO::PARAM_INT);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            if ($row && $row['total'] > 0) {
                $toret = true;
            }
        } catch (PDOException $e) {
            error_log("Error comprobando vehículos del usuario: " . $e->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }

        return $toret;
    }


    public static function get_vehiculos_usuario(int $id_usuario): array
    {
        $vehiculos = [];
        $pdo = conexionBD::get();
        $sql = "SELECT id_vehiculo, id_usuario, matricula, marca, modelo, anio FROM vehiculos WHERE id_usuario = ?";

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $id_usuario, PDO::PARAM_INT);
            $statement->execute();
            foreach ($statement as $row) {
                $vehiculo = new Vehiculo(
                    $row['id_usuario'],
                    $row['matricula'],
                    $row['marca'],
                    $row['modelo'],
                    $row['anio'],
                    $row['id_vehiculo']
                );
                $vehiculos[] = $vehiculo;
            }
        } catch (PDOException $th) {
            error_log("Error obteniendo vehículos de la BD. " . $th->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }
        return $vehiculos;
    }

    public static function actualizar_vehiculo(Vehiculo $vehiculo): bool
    {
        $pdo = conexionBD::get();
        $sql = "UPDATE vehiculos SET matricula = ?, marca = ?, modelo = ?, anio = ? WHERE id_vehiculo = ? AND id_usuario = ?";
        $toret = false;

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $vehiculo->getMatricula(), PDO::PARAM_STR);
            $statement->bindValue(2, $vehiculo->getMarca(), PDO::PARAM_STR);
            $statement->bindValue(3, $vehiculo->getModelo(), PDO::PARAM_STR);
            $statement->bindValue(4, $vehiculo->getAnio(), PDO::PARAM_STR);
            $statement->bindValue(5, $vehiculo->getId_vehiculo(), PDO::PARAM_INT);
            $statement->bindValue(6, $vehiculo->getId_usuario(), PDO::PARAM_INT);
            $toret = $statement->execute();
        } catch (PDOException $e) {
            error_log("Error actualizando vehículo: " . $e->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }

        return $toret;
    }

    public static function eliminar_vehiculo(int $id_usuario, int $id_vehiculo): bool
    {
        $pdo = conexionBD::get();
        $sql = "DELETE FROM vehiculos WHERE id_usuario = ? AND id_vehiculo = ?";
        $eliminado = false;

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $id_usuario, PDO::PARAM_INT);
            $statement->bindValue(2, $id_vehiculo, PDO::PARAM_INT);
            $eliminado = $statement->execute();
        } catch (PDOException $e) {
            error_log("Error eliminando vehículo: " . $e->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }

        return $eliminado;
    }

    public static function insertar_vehiculo(Vehiculo $vehiculo): bool
    {
        $pdo = conexionBD::get();
        $insertado = false;

        $sqlCount = "SELECT COUNT(*) as total FROM vehiculos WHERE id_usuario = ?";
        $sqlInsert = "INSERT INTO vehiculos (id_usuario, matricula, marca, modelo, anio) VALUES (?, ?, ?, ?, ?)";

        try {
            $pdo->beginTransaction();

            $stmtCount = $pdo->prepare($sqlCount);
            $stmtCount->execute([$vehiculo->getId_usuario()]);
            $total = $stmtCount->fetchColumn();

            if ($total < 3) {
                $stmtInsert = $pdo->prepare($sqlInsert);
                $insertado = $stmtInsert->execute([
                    $vehiculo->getId_usuario(),
                    $vehiculo->getMatricula(),
                    $vehiculo->getMarca(),
                    $vehiculo->getModelo(),
                    $vehiculo->getAnio()
                ]);
            }

            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            error_log("Error insertando vehículo: " . $e->getMessage());
        } finally {
            $pdo = null;
            $stmtCount = null;
            $stmtInsert = null;
        }

        return $insertado;
    }

    public static function existeMatricula($matricula, $idVehiculoActual = null)
    {
        $pdo = conexionBD::get();
        $query = "SELECT id_vehiculo FROM vehiculos WHERE matricula = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$matricula]);
        $idVehiculo = $stmt->fetchColumn();

        if (!$idVehiculo) {
            return false;
        }

        if ($idVehiculo == $idVehiculoActual) {
            return false;
        }

        return true;
    }


    public static function getMarca(): array
    {
        $pdo = conexionBD::get();
        $marcas = [];

        try {
            $sql = "SHOW COLUMNS FROM vehiculos LIKE 'marca'";
            $stmt = $pdo->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && isset($row['Type'])) {
                $type = $row['Type'];

                if (preg_match("/^enum\((.*)\)$/i", $type, $matches)) {
                    $enumValues = $matches[1];

                    $enumValues = str_getcsv($enumValues, ',', "'");

                    foreach ($enumValues as $value) {
                        $marcas[] = trim($value);
                    }
                }
            }
        } catch (PDOException $e) {
            error_log("Error al obtener marcas ENUM: " . $e->getMessage());
        } finally {
            $pdo = null;
        }

        return $marcas;
    }

    public static function vehiculoRelacionadoConEvento(int $id_vehiculo, int $id_usuario): bool
    {
        $pdo = conexionBD::get();
        $sql = "SELECT 1
            FROM vehiculos v
            JOIN eventos e ON e.requisitos = v.marca
            JOIN inscribe i ON i.id_evento = e.id_evento
            WHERE v.id_vehiculo = ?
              AND i.id_usuario = ?
              AND (e.estado_evento = 'ACTIVO' OR e.estado_evento = 'EN PROGRESO') LIMIT 1";

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $id_vehiculo, PDO::PARAM_INT);
            $statement->bindValue(2, $id_usuario, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch() !== false;
        } catch (PDOException $e) {
            error_log("Error comprobando relación vehículo-evento: " . $e->getMessage());
            return false;
        } finally {
            $pdo = null;
            $statement = null;
        }
    }
}
