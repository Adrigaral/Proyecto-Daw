<?php
include_once("conexionBD.php");

class Evento
{
    private int $id_evento;
    private int $id_usuario;
    private string $titulo;
    private string $descripcion;
    private DateTime $fecha_inicio_evento;
    private DateTime $fecha_fin_evento;
    private string $estado_evento;
    private int $limite_plazas;
    private string $requisitos; // Modelo de coche
    private string $lugar;
    private float $precio;
    private string $foto_evento;

    public function __construct(int $id_usuario, string $titulo, string $descripcion, DateTime $fecha_inicio_evento, DateTime $fecha_fin_evento, string $estado_evento, int $limite_plazas, string $requisitos, string $lugar, float $precio, string $foto_evento, int $id = null)
    {
        if (isset($id)) {
            $this->id_evento = $id;
        }
        $this->id_usuario = $id_usuario;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->fecha_inicio_evento = $fecha_inicio_evento;
        $this->fecha_fin_evento = $fecha_fin_evento;
        $this->estado_evento = $estado_evento;
        $this->limite_plazas = $limite_plazas;
        $this->requisitos = $requisitos;
        $this->lugar = $lugar;
        $this->precio = $precio;
        $this->foto_evento = $foto_evento;
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
     * Get the value of titulo
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     *
     * @return  self
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of fecha_inicio_evento
     */
    public function getFecha_inicio_evento()
    {
        return $this->fecha_inicio_evento;
    }

    /**
     * Set the value of fecha_inicio_evento
     *
     * @return  self
     */
    public function setFecha_inicio_evento($fecha_inicio_evento)
    {
        $this->fecha_inicio_evento = $fecha_inicio_evento;

        return $this;
    }

    /**
     * Get the value of fecha_fin_evento
     */
    public function getFecha_fin_evento()
    {
        return $this->fecha_fin_evento;
    }

    /**
     * Set the value of fecha_fin_evento
     *
     * @return  self
     */
    public function setFecha_fin_evento($fecha_fin_evento)
    {
        $this->fecha_fin_evento = $fecha_fin_evento;

        return $this;
    }

    /**
     * Get the value of estado_evento
     */
    public function getEstado_evento()
    {
        return $this->estado_evento;
    }

    /**
     * Set the value of estado_evento
     *
     * @return  self
     */
    public function setEstado_evento($estado_evento)
    {
        $this->estado_evento = $estado_evento;

        return $this;
    }

    /**
     * Get the value of limite_plazas
     */
    public function getLimite_plazas()
    {
        return $this->limite_plazas;
    }

    /**
     * Set the value of limite_plazas
     *
     * @return  self
     */
    public function setLimite_plazas($limite_plazas)
    {
        $this->limite_plazas = $limite_plazas;

        return $this;
    }

    /**
     * Get the value of requisitos
     */
    public function getRequisitos()
    {
        return $this->requisitos;
    }

    /**
     * Set the value of requisitos
     *
     * @return  self
     */
    public function setRequisitos($requisitos)
    {
        $this->requisitos = $requisitos;

        return $this;
    }

    /**
     * Get the value of lugar
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set the value of lugar
     *
     * @return  self
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of foto_evento
     */
    public function getFoto_evento()
    {
        return $this->foto_evento;
    }

    /**
     * Set the value of foto_evento
     *
     * @return  self
     */
    public function setFoto_evento($foto_evento)
    {
        $this->foto_evento = $foto_evento;

        return $this;
    }
}

class EventoModel
{
    public static function get_evento(int $id_evento): ?Evento
    {
        $pdo = conexionBD::get();
        $evento = null;

        $sql = "SELECT * FROM eventos WHERE id_evento = :id_evento";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id_evento', $id_evento, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $fecha_inicio = new DateTime($row['fecha_inicio_evento']);
                $fecha_fin = new DateTime($row['fecha_fin_evento']);

                $evento = new Evento(
                    $row['id_usuario'],
                    $row['titulo'],
                    $row['descripcion'],
                    $fecha_inicio,
                    $fecha_fin,
                    $row['estado_evento'],
                    (int)$row['limite_plazas'],
                    $row['requisitos'],
                    $row['lugar'],
                    (float)$row['precio'],
                    $row['foto_evento'],
                    (int)$row['id_evento']
                );
            }
        } catch (PDOException $e) {
            error_log("Error al obtener evento: " . $e->getMessage());
        } finally {
            $pdo = null;
            $stmt = null;
        }

        return $evento;
    }


    public static function get_ultimo_evento_activo(): ?Evento
    {
        $pdo = conexionBD::get();
        $evento = null;

        $sql = "SELECT * FROM eventos WHERE id_evento = (SELECT MAX(id_evento) FROM eventos WHERE estado_evento = 'ACTIVO')";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $evento = new Evento(
                    $row['id_usuario'],
                    $row['titulo'],
                    $row['descripcion'],
                    new DateTime($row['fecha_inicio_evento']),
                    new DateTime($row['fecha_fin_evento']),
                    $row['estado_evento'],
                    $row['limite_plazas'],
                    $row['requisitos'],
                    $row['lugar'],
                    (float)$row['precio'],
                    $row['foto_evento'],
                    (int)$row['id_evento']
                );
            }
        } catch (PDOException $e) {
            error_log("Error al obtener el último evento activo: " . $e->getMessage());
        } finally {
            $pdo = null;
            $stmt = null;
        }

        return $evento;
    }



    public static function get_eventos(): array
    {
        $pdo = conexionBD::get();
        $sql = "SELECT * FROM eventos";
        $eventos = [];

        try {
            $stmt = $pdo->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $evento = new Evento(
                    $row['id_usuario'],
                    $row['titulo'],
                    $row['descripcion'],
                    new DateTime($row['fecha_inicio_evento']),
                    new DateTime($row['fecha_fin_evento']),
                    $row['estado_evento'],
                    (int)$row['limite_plazas'],
                    $row['requisitos'],
                    $row['lugar'],
                    (float)$row['precio'],
                    $row['foto_evento'],
                    (int)$row['id_evento']
                );
                $eventos[] = $evento;
            }

            return $eventos;
        } catch (PDOException $e) {
            error_log("Error al obtener eventos: " . $e->getMessage());
        } finally {
            $pdo = null;
            $stmt = null;
        }
        return $eventos;
    }

    public static function get_eventos_activos(): array
    {
        $pdo = conexionBD::get();
        $eventos = [];

        $sql = "SELECT * FROM eventos WHERE estado_evento = 'ACTIVO'";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $evento = new Evento(
                    $row['id_usuario'],
                    $row['titulo'],
                    $row['descripcion'],
                    new DateTime($row['fecha_inicio_evento']),
                    new DateTime($row['fecha_fin_evento']),
                    $row['estado_evento'],
                    $row['limite_plazas'],
                    $row['requisitos'],
                    $row['lugar'],
                    (float)$row['precio'],
                    $row['foto_evento'],
                    (int)$row['id_evento']
                );
                $eventos[] = $evento;
            }
        } catch (PDOException $e) {
            error_log("Error al obtener eventos activos: " . $e->getMessage());
        } finally {
            $pdo = null;
            $stmt = null;
        }

        return $eventos;
    }

    public static function crearEvento(Evento $evento): bool
    {
        $pdo = conexionBD::get();
        $sql = "INSERT INTO eventos (id_usuario, titulo, descripcion, fecha_inicio_evento, fecha_fin_evento, estado_evento, limite_plazas, requisitos, lugar)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $evento->getId_usuario(),
                $evento->getTitulo(),
                $evento->getDescripcion(),
                $evento->getFecha_inicio_evento()->format('Y-m-d H:i:s'),
                $evento->getFecha_fin_evento()->format('Y-m-d H:i:s'),
                $evento->getEstado_evento(),
                $evento->getLimite_plazas(),
                $evento->getRequisitos(),
                $evento->getLugar()
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al crear evento: " . $e->getMessage());
            return false;
        } finally {
            $pdo = null;
            $stmt = null;
        }
    }

    public static function filtrarEventos(?string $modelo = null, ?string $lugar = null, int $limite = 6, int $offset = 0): array
    {
        $pdo = conexionBD::get();
        $resultados = [];

        $sql = "SELECT * FROM eventos WHERE estado_evento = 'ACTIVO'";
        $parametros = [];

        if ($modelo) {
            $sql .= " AND requisitos = ?";
            $parametros[] = $modelo;
        }

        if ($lugar) {
            $sql .= " AND lugar LIKE ?";
            $parametros[] = '%' . $lugar . '%';
        }

        $sql .= " ORDER BY fecha_inicio_evento DESC LIMIT ? OFFSET ?";
        $parametros[] = $limite;
        $parametros[] = $offset;

        try {
            $stmt = $pdo->prepare($sql);

            // Vincular los parámetros
            $i = 1;
            foreach ($parametros as $param) {
                if ($i > count($parametros) - 2) { // Los dos últimos son limite y offset
                    $stmt->bindValue($i, $param, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($i, $param);
                }
                $i++;
            }

            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultados[] = new Evento(
                    $row['id_usuario'],
                    $row['titulo'],
                    $row['descripcion'],
                    new DateTime($row['fecha_inicio_evento']),
                    new DateTime($row['fecha_fin_evento']),
                    $row['estado_evento'],
                    $row['limite_plazas'],
                    $row['requisitos'],
                    $row['lugar'],
                    $row['precio'],
                    $row['foto_evento'],
                    (int)$row['id_evento']
                );
            }
        } catch (PDOException $e) {
            error_log("Error al filtrar eventos: " . $e->getMessage());
        } finally {
            $pdo = null;
        }

        return $resultados;
    }

    public static function contarEventosFiltrados(?string $modelo = null, ?string $lugar = null): int
    {
        $pdo = conexionBD::get();
        $sql = "SELECT COUNT(*) FROM eventos WHERE estado_evento = 'ACTIVO'";
        $parametros = [];

        if ($modelo) {
            $sql .= " AND requisitos = ?";
            $parametros[] = $modelo;
        }

        if ($lugar) {
            $sql .= " AND lugar LIKE ?";
            $parametros[] = '%' . $lugar . '%';
        }

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($parametros);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error al contar eventos filtrados: " . $e->getMessage());
            return 0;
        } finally {
            $pdo = null;
        }
    }


    public static function actualizar_evento(int $id_evento, DateTime $nueva_fecha_inicio, DateTime $nueva_fecha_fin, string $nuevo_lugar, string $nuevo_titulo, string $nueva_descripcion, float $precio, string $foto_evento): bool
    {
        $pdo = conexionBD::get();
        $sql = "UPDATE eventos 
            SET fecha_inicio_evento = ?, 
                fecha_fin_evento = ?, 
                lugar = ?, 
                titulo = ?, 
                descripcion = ?,
                precio = ?,
                foto_evento = ?
            WHERE id_evento = ? AND estado_evento = 'ACTIVO'";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $nueva_fecha_inicio->format('Y-m-d'));
            $stmt->bindValue(2, $nueva_fecha_fin->format('Y-m-d'));
            $stmt->bindValue(3, $nuevo_lugar);
            $stmt->bindValue(4, $nuevo_titulo);
            $stmt->bindValue(5, $nueva_descripcion);
            $stmt->bindValue(6, $precio);
            $stmt->bindValue(7, $foto_evento);
            $stmt->bindValue(6, $id_evento, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error actualizando evento: " . $e->getMessage());
            return false;
        } finally {
            $pdo = null;
            $stmt = null;
        }
    }

    public static function actualizar_estado_evento(int $id_evento, string $nuevo_estado): bool
    {
        $pdo = conexionBD::get();
        $sql = "UPDATE eventos SET estado_evento = ? WHERE id_evento = ?";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, strtoupper($nuevo_estado));
            $stmt->bindValue(2, $id_evento, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error actualizando estado del evento: " . $e->getMessage());
            return false;
        } finally {
            $pdo = null;
            $stmt = null;
        }
    }

    public static function actualizar_estados_automaticamente(): void
    {
        $pdo = conexionBD::get();

        try {
            // Actualizar a EN PROGRESO
            $sqlProgreso = "UPDATE eventos SET estado_evento = 'EN PROGRESO' WHERE estado_evento = 'ACTIVO' AND fecha_inicio_evento <= NOW() AND fecha_fin_evento >= NOW()";
            $pdo->exec($sqlProgreso);

            // Actualizar a FINALIZADO
            $sqlFinalizado = "UPDATE eventos SET estado_evento = 'FINALIZADO' WHERE estado_evento IN ('ACTIVO', 'EN PROGRESO') AND fecha_fin_evento < NOW()";
            $pdo->exec($sqlFinalizado);
        } catch (PDOException $e) {
            error_log("Error actualizando estados automáticamente: " . $e->getMessage());
        } finally {
            $pdo = null;
        }
    }

    public static function eliminar_o_cancelar_evento(int $id_evento): bool
    {
        $pdo = conexionBD::get();

        try {
            // Comprobar si hay inscripciones asociadas
            $sqlCheck = "SELECT COUNT(*) FROM inscripciones WHERE id_evento = ?";
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->execute([$id_evento]);
            $inscripciones = $stmtCheck->fetchColumn();

            if ($inscripciones > 0) {
                // Si hay inscripciones, cambiar estado a CANCELADO
                $sqlUpdate = "UPDATE eventos SET estado_evento = 'CANCELADO' WHERE id_evento = ?";
                $stmtUpdate = $pdo->prepare($sqlUpdate);
                return $stmtUpdate->execute([$id_evento]);
            } else {
                // Si no hay inscripciones, eliminar el evento
                $sqlDelete = "DELETE FROM eventos WHERE id_evento = ?";
                $stmtDelete = $pdo->prepare($sqlDelete);
                return $stmtDelete->execute([$id_evento]);
            }
        } catch (PDOException $e) {
            error_log("Error al eliminar o cancelar evento: " . $e->getMessage());
            return false;
        } finally {
            $pdo = null;
        }
    }

    public static function obtenerEventosUsuario($id_usuario)
    {
        $pdo = conexionBD::get();
        $sql = "SELECT e.id_evento, e.titulo, e.descripcion, e.estado_evento, e.requisitos, e.lugar, e.precio, e.foto_evento, i.fecha_inscripcion FROM `eventos` e 
                LEFT JOIN inscribe i on i.id_evento = e.id_evento 
                WHERE i.id_usuario = ?";
        $resultados = [];

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultados[] = new Evento(
                    $row['id_usuario'],
                    $row['titulo'],
                    $row['descripcion'],
                    new DateTime($row['fecha_inicio_evento']),
                    new DateTime($row['fecha_fin_evento']),
                    $row['estado_evento'],
                    $row['limite_plazas'],
                    $row['requisitos'],
                    $row['lugar'],
                    $row['precio'],
                    $row['foto_evento'],
                    (int)$row['id_evento']
                );
            }
        } catch (PDOException $e) {
            error_log("Error al obtener a los eventos inscritos del usuario: " . $e->getMessage());
        } finally {
            $pdo = null;
            $stmt = null;
        }

        return $resultados;
    }

    public static function obtenerCreadorEvento(int $id_evento): ?int
    {
        $pdo = conexionBD::get();
        $sql = "SELECT id_usuario FROM eventos WHERE id_evento = ?";

        $resultado = null;

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $id_evento, PDO::PARAM_INT);
            $stmt->execute();
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($fila) {
                $resultado = (int)$fila['id_usuario'];
            }
        } catch (PDOException $e) {
            error_log("Error al obtener el creador del evento: " . $e->getMessage());
        } finally {
            $pdo = null;
            $stmt = null;
        }

        return $resultado;
    }
}
