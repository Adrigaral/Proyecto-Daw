<?php
include_once("conexionBD.php");

class inscribe
{
    private int $id_usuario;
    private int $id_evento;
    private DateTime $fecha_inscripcion;

    public function __construct(int $id_usuario, int $id_evento, DateTime $fecha_inscripcion, int $id_u = null, int $id_e = null)
    {
        if (isset($id_u)) {
            $this->id_usuario = $id_u;
        }
        if (isset($id_e)) {
            $this->id_evento = $id_e;
        }
        $this->id_usuario = $id_usuario;
        $this->id_evento = $id_evento;
        $this->fecha_inscripcion = $fecha_inscripcion;
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
     * Get the value of id_evento
     */
    public function getId_evento()
    {
        return $this->id_evento;
    }

    /**
     * Set the value of id_evento
     *
     * @return  self
     */
    public function setId_evento($id_evento)
    {
        $this->id_evento = $id_evento;

        return $this;
    }

    /**
     * Get the value of fecha_inscripcion
     */
    public function getFecha_inscripcion()
    {
        return $this->fecha_inscripcion;
    }

    /**
     * Set the value of fecha_inscripcion
     *
     * @return  self
     */
    public function setFecha_inscripcion($fecha_inscripcion)
    {
        $this->fecha_inscripcion = $fecha_inscripcion;

        return $this;
    }
}

class InscribeModel
{

    public static function estaInscrito(int $id_usuario, int $id_evento): bool
    {
        $pdo = conexionBD::get();
        $sql = "SELECT COUNT(*) FROM inscribe WHERE id_usuario = ? AND id_evento = ?";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_usuario, $id_evento]);
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            error_log("Error al comprobar inscripción: " . $e->getMessage());
            return false;
        } finally {
            $pdo = null;
        }
    }

    public static function get_usuarios_y_vehiculos_inscritos(int $id_evento): array
    {
        $resultados = [];
        $pdo = conexionBD::get();

        $sql = "
        SELECT 
            u.id_usuario, 
            u.dni, 
            u.nombre, 
            v.id_vehiculo, 
            v.marca, 
            v.modelo, 
            v.matricula 
        FROM 
            inscribe i
            INNER JOIN usuarios u ON i.id_usuario = u.id_usuario
            LEFT JOIN vehiculos v ON u.id_usuario = v.id_usuario
            LEFT JOIN eventos e ON e.id_evento = i.id_evento
        WHERE 
            i.id_evento = ? AND requisitos = v.marca
        ORDER BY u.id_usuario
    ";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_evento]);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id_usuario = $row['id_usuario'];

                if (!isset($resultados[$id_usuario])) {
                    $resultados[$id_usuario] = [
                        'id_usuario' => $id_usuario,
                        'dni' => $row['dni'],
                        'nombre' => $row['nombre'],
                        'vehiculos' => []
                    ];
                }

                if (!empty($row['id_vehiculo'])) {
                    $resultados[$id_usuario]['vehiculos'][] = [
                        'id_vehiculo' => $row['id_vehiculo'],
                        'marca' => $row['marca'],
                        'modelo' => $row['modelo'],
                        'matricula' => $row['matricula']
                    ];
                }
            }
        } catch (PDOException $e) {
            error_log("Error obteniendo inscritos: " . $e->getMessage());
        } finally {
            $pdo = null;
        }

        return array_values($resultados);
    }

    public static function inscribirseEvento(Inscribe $inscripcion): bool
    {
        $toret = false;
        $pdo = conexionBD::get();

        try {
            // Comprobar que el evento está ACTIVO
            $sqlEstado = "SELECT estado_evento FROM eventos WHERE id_evento = ?";
            $stmtEstado = $pdo->prepare($sqlEstado);
            $stmtEstado->execute([$inscripcion->getId_evento()]);
            $estado = $stmtEstado->fetchColumn();

            if ($estado !== 'ACTIVO') {
                return false;
            }

            // Insertar la inscripción
            $sqlInsert = "INSERT INTO inscribe (id_usuario, id_evento, fecha_inscripcion) VALUES (?, ?, ?)";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->bindValue(1, $inscripcion->getId_usuario());
            $stmtInsert->bindValue(2, $inscripcion->getId_evento());
            $stmtInsert->bindValue(3, $inscripcion->getFecha_inscripcion()->format('Y-m-d H:i:s'));

            if ($stmtInsert->execute()) {
                $toret = true;
            }
        } catch (PDOException $e) {
            $toret = false;
            error_log("Error al inscribirse al evento: " . $e->getMessage());
        } finally {
            $pdo = null;
        }

        return $toret;
    }


    public static function quitarInscripcion(int $id_usuario, int $id_evento): bool
    {
        $pdo = conexionBD::get();

        try {
            // Verificar si el evento está ACTIVO
            $sqlEstado = "SELECT estado_evento FROM eventos WHERE id_evento = ?";
            $stmtEstado = $pdo->prepare($sqlEstado);
            $stmtEstado->execute([$id_evento]);
            $estado = $stmtEstado->fetchColumn();

            if ($estado === false) {
                // No se encontró el evento
                return false;
            }

            if ($estado !== 'ACTIVO') {
                return false;
            }

            // Eliminar la inscripción
            $sqlDelete = "DELETE FROM inscribe WHERE id_usuario = ? AND id_evento = ?";
            $stmtDelete = $pdo->prepare($sqlDelete);
            $stmtDelete->bindValue(1, $id_usuario, PDO::PARAM_INT);
            $stmtDelete->bindValue(2, $id_evento, PDO::PARAM_INT);

            $stmtDelete->execute();
            return $stmtDelete->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al quitar inscripción: " . $e->getMessage());
            return false;
        } finally {
            $pdo = null;
        }
    }
}
