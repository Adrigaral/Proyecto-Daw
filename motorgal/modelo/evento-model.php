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
    private float $latitud;
    private float $longitud;

    public function __construct(int $id_usuario, string $titulo, string $descripcion, DateTime $fecha_inicio_evento, DateTime $fecha_fin_evento, string $estado_evento, int $limite_plazas, string $requisitos, string $lugar, float $precio, string $foto_evento, float $latitud, float $longitud, int $id = null)
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
        $this->latitud = $latitud;
        $this->longitud = $longitud;
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

    /**
     * Get the value of latitud
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * Set the value of latitud
     *
     * @return  self
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;

        return $this;
    }

    /**
     * Get the value of longitud
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * Set the value of longitud
     *
     * @return  self
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;

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
                    (float)$row['latitud'],
                    (float)$row['longitud'],
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

    public static function get_ultimo_evento_activo(int $id_usuario): ?Evento
    {
        $pdo = conexionBD::get();
        $evento = null;
    
        $sql = "
            SELECT * FROM eventos
            WHERE id_evento = (
                SELECT MAX(id_evento)
                FROM eventos
                WHERE estado_evento = 'ACTIVO'
                  AND id_usuario <> :id_usuario
            )
        ";
    
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
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
                    (float)$row['latitud'],
                    (float)$row['longitud'],
                    (int)$row['id_evento']
                );
            }
        } catch (PDOException $e) {
            error_log("Error al obtener el último evento activo: " . $e->getMessage());
        } finally {
            $pdo = null;
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
                    (int)$row['id_evento'],
                    (float)$row['latitud'],
                    (float)$row['longitud']
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

    public static function get_eventos_activos(int $id_usuario): array
    {
        $pdo = conexionBD::get();
        $eventos = [];

        $sql = "SELECT * FROM eventos 
            WHERE estado_evento = 'ACTIVO' 
            AND id_usuario != :id_usuario";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
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
                    (int)$row['id_evento'],
                    (float)$row['latitud'],
                    (float)$row['longitud']
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
        $sql = "INSERT INTO eventos (id_usuario, titulo, descripcion, fecha_inicio_evento, fecha_fin_evento, estado_evento, limite_plazas, requisitos, lugar, precio, foto_evento, latitud, longitud)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
                $evento->getLugar(),
                $evento->getPrecio(),
                $evento->getFoto_evento(),
                $evento->getLatitud(),
                $evento->getLongitud()
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

    public static function filtrarEventos(
        int      $id_usuario,
        ?string  $modelo = null,
        ?string  $lugar  = null,
        int      $limite = 6,
        int      $offset = 0
    ): array {
        $pdo = conexionBD::get();
        $resultados = [];

        $sql = "SELECT * FROM eventos
                WHERE estado_evento = 'ACTIVO'
                  AND id_usuario <> :id_usuario";

        $parametros = [':id_usuario' => $id_usuario];

        if ($modelo) {
            $sql .= " AND requisitos = :modelo";
            $parametros[':modelo'] = $modelo;
        }

        if ($lugar) {
            $sql .= " AND lugar LIKE :lugar";
            $parametros[':lugar'] = '%' . $lugar . '%';
        }

        $sql .= " ORDER BY fecha_inicio_evento DESC LIMIT :lim OFFSET :off";
        $parametros[':lim'] = $limite;
        $parametros[':off'] = $offset;

        try {
            $stmt = $pdo->prepare($sql);

            foreach ($parametros as $key => $valor) {
                $tipo = in_array($key, [':lim', ':off', ':id_usuario']) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue($key, $valor, $tipo);
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
                    (float)$row['precio'],
                    $row['foto_evento'],
                    (float)$row['latitud'],
                    (float)$row['longitud'],
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


    public static function filtrarEventosUsuario(int $id_usuario, ?string $requisitos = null, ?string $lugar = null, ?string $estado = null, int $limite, int $offset): array
    {
        $pdo = conexionBD::get();
        $eventos = [];

        $sql = "SELECT e.id_evento, e.titulo, e.descripcion, e.estado_evento, e.requisitos, e.lugar, e.precio, e.foto_evento, i.fecha_inscripcion
            FROM eventos e
            LEFT JOIN inscribe i ON i.id_evento = e.id_evento
            WHERE i.id_usuario = ?";

        $parametros = [$id_usuario];

        if ($requisitos) {
            $sql .= " AND e.requisitos LIKE ?";
            $parametros[] = '%' . $requisitos . '%';
        }

        if ($lugar) {
            $sql .= " AND e.lugar LIKE ?";
            $parametros[] = '%' . $lugar . '%';
        }

        if ($estado) {
            $sql .= " AND e.estado_evento = ?";
            $parametros[] = $estado;
        }

        $sql .= " ORDER BY i.fecha_inscripcion DESC LIMIT ? OFFSET ?";
        $parametros[] = $limite;
        $parametros[] = $offset;

        try {
            $stmt = $pdo->prepare($sql);

            // Vincular los parámetros
            $i = 1;
            foreach ($parametros as $param) {
                if ($i > count($parametros) - 2) { // Los dos últimos son LIMIT y OFFSET
                    $stmt->bindValue($i, $param, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($i, $param);
                }
                $i++;
            }

            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $eventos[] = $row;
            }
        } catch (PDOException $e) {
            error_log("Error en al filtrar los eventos en los que está incritos este usuario: " . $e->getMessage());
        } finally {
            $pdo = null;
        }

        return $eventos;
    }

    public static function filtrarEventosCreados(int $id_usuario, ?string $requisitos = null, ?string $lugar = null, ?string $estado = null, int $limite, int $offset): array
    {
        $pdo = conexionBD::get();
        $eventos = [];

        $sql = "SELECT id_evento, titulo, descripcion, estado_evento, requisitos, lugar, precio, foto_evento
            FROM eventos
            WHERE id_usuario = ?";

        $parametros = [$id_usuario];

        if ($requisitos) {
            $sql .= " AND requisitos LIKE ?";
            $parametros[] = '%' . $requisitos . '%';
        }

        if ($lugar) {
            $sql .= " AND lugar LIKE ?";
            $parametros[] = '%' . $lugar . '%';
        }

        if ($estado) {
            $sql .= " AND estado_evento = ?";
            $parametros[] = $estado;
        }

        $sql .= " ORDER BY fecha_inicio_evento DESC LIMIT ? OFFSET ?";
        $parametros[] = $limite;
        $parametros[] = $offset;

        try {
            $stmt = $pdo->prepare($sql);

            // Vincular los parámetros
            $i = 1;
            foreach ($parametros as $param) {
                if ($i > count($parametros) - 2) { // Los dos últimos son LIMIT y OFFSET
                    $stmt->bindValue($i, $param, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($i, $param);
                }
                $i++;
            }

            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $eventos[] = $row;
            }
        } catch (PDOException $e) {
            error_log("Error en al filtrar los eventos creados por este usuario: " . $e->getMessage());
        } finally {
            $pdo = null;
        }

        return $eventos;
    }



    public static function contarEventosFiltrados(
        int     $id_usuario_actual,
        ?string $modelo = null,
        ?string $lugar  = null
    ): int {
        $pdo = conexionBD::get();

        $sql = "SELECT COUNT(*) FROM eventos
                WHERE estado_evento = 'ACTIVO'
                  AND id_usuario <> :id_usuario";    // excluir propios

        $parametros = [':id_usuario' => $id_usuario_actual];

        if ($modelo) {
            $sql .= " AND requisitos = :modelo";
            $parametros[':modelo'] = $modelo;
        }

        if ($lugar) {
            $sql .= " AND lugar LIKE :lugar";
            $parametros[':lugar'] = '%' . $lugar . '%';
        }

        try {
            $stmt = $pdo->prepare($sql);
            foreach ($parametros as $k => $v) {
                $stmt->bindValue($k, $v, ($k === ':id_usuario') ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error al contar eventos filtrados: " . $e->getMessage());
            return 0;
        } finally {
            $pdo = null;
        }
    }


    public static function contarEventosUsuario($id_usuario, $lugar = null, $estado = null, $modelo = null)
    {
        $pdo = conexionBD::get();
        $sql = "SELECT COUNT(*) as total
            FROM eventos e
            LEFT JOIN inscribe i ON i.id_evento = e.id_evento
            WHERE i.id_usuario = :id_usuario";

        $params = [':id_usuario' => $id_usuario];

        if (!empty($lugar)) {
            $sql .= " AND e.lugar LIKE :lugar";
            $params[':lugar'] = '%' . $lugar . '%';
        }

        if (!empty($estado)) {
            $sql .= " AND e.estado_evento = :estado";
            $params[':estado'] = $estado;
        }

        if (!empty($modelo)) {
            $sql .= " AND e.requisitos LIKE :modelo";
            $params[':modelo'] = '%' . $modelo . '%';
        }

        try {
            $stmt = $pdo->prepare($sql);
            foreach ($params as $key => &$value) {
                $stmt->bindParam($key, $value);
            }
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error en contarEventosUsuario: " . $e->getMessage());
            return 0;
        } finally {
            $pdo = null;
            $stmt = null;
        }
    }

    public static function contarEventosCreados($id_usuario, $lugar = null, $estado = null, $modelo = null)
    {
        $pdo = conexionBD::get();
        $sql = "SELECT COUNT(*) as total
            FROM eventos
            WHERE id_usuario = :id_usuario";

        $params = [':id_usuario' => $id_usuario];

        if (!empty($lugar)) {
            $sql .= " AND lugar LIKE :lugar";
            $params[':lugar'] = '%' . $lugar . '%';
        }

        if (!empty($estado)) {
            $sql .= " AND estado_evento = :estado";
            $params[':estado'] = $estado;
        }

        if (!empty($modelo)) {
            $sql .= " AND requisitos LIKE :modelo";
            $params[':modelo'] = '%' . $modelo . '%';
        }

        try {
            $stmt = $pdo->prepare($sql);
            foreach ($params as $key => &$value) {
                $stmt->bindParam($key, $value);
            }
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error en contarEventosCreados: " . $e->getMessage());
            return 0;
        } finally {
            $pdo = null;
            $stmt = null;
        }
    }

    public static function actualizar_evento(int $id_evento, DateTime $nueva_fecha_inicio, DateTime $nueva_fecha_fin, string $nuevo_lugar, string $nuevo_titulo, string $nueva_descripcion, int $limite_plazas, string $nuevos_requisitos, float $precio, string $foto_evento, float $latitud, float $longitud): bool
    {
        $pdo = conexionBD::get();

        $sql = "
        UPDATE eventos
        SET
            titulo              = ?,
            descripcion         = ?,
            fecha_inicio_evento = ?,
            fecha_fin_evento    = ?,
            lugar               = ?,
            limite_plazas       = ?,
            requisitos          = ?,
            precio              = ?,
            foto_evento         = COALESCE(?, foto_evento), -- solo cambia si llega algo
            latitud             = ?,
            longitud            = ?
        WHERE id_evento = ?
          AND estado_evento = 'ACTIVO'
    ";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $nuevo_titulo,
                $nueva_descripcion,
                $nueva_fecha_inicio->format('Y-m-d H:i:s'),
                $nueva_fecha_fin->format('Y-m-d H:i:s'),
                $nuevo_lugar,
                $limite_plazas,
                $nuevos_requisitos,
                $precio,
                $foto_evento,
                $latitud,
                $longitud,
                $id_evento
            ]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error al actualizar evento: ' . $e->getMessage());
            return false;
        } finally {
            $pdo  = null;
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
            $sqlCheck = "SELECT COUNT(*) FROM inscribe WHERE id_evento = ?";
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->execute([$id_evento]);
            $inscripciones = $stmtCheck->fetchColumn();

            if ($inscripciones > 0) {
                // Si hay inscripciones, cambiar estado a CANCELADO
                $sqlUpdate = "UPDATE eventos SET estado_evento = 'CANCELADO' WHERE id_evento = ? AND estado_evento = 'ACTIVO'";
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

    public static function obtenerEventosUsuario(int $id_usuario)
    {
        $pdo = conexionBD::get();
        $sql = "SELECT e.id_evento, e.titulo, e.descripcion, e.estado_evento, e.requisitos, e.lugar, e.precio, e.foto_evento, i.fecha_inscripcion 
            FROM eventos e 
            LEFT JOIN inscribe i ON i.id_evento = e.id_evento 
            WHERE i.id_usuario = ?";
        $resultados = [];

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener los eventos del usuario: " . $e->getMessage());
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

    public static function getInscritosEvento(int $id_evento, int $limite, int $offset, ?string $matricula = null): array
    {
        $pdo = conexionBD::get();
        $inscritos = [];
        $sql = "
        SELECT
            u.dni,
            u.nombre,
            v.marca,
            GROUP_CONCAT(DISTINCT v.matricula ORDER BY v.matricula SEPARATOR ', ') AS matriculas,
            GROUP_CONCAT(DISTINCT v.modelo    ORDER BY v.modelo    SEPARATOR ', ') AS modelos
        FROM inscribe  AS i
        JOIN usuarios  AS u ON u.id_usuario = i.id_usuario
        JOIN eventos   AS e ON e.id_evento  = i.id_evento
        JOIN vehiculos AS v ON v.id_usuario = i.id_usuario
        WHERE i.id_evento = ?
          AND e.requisitos = v.marca
    ";

        $parametros = [$id_evento];
        if ($matricula) {
            $sql .= " AND v.matricula LIKE ? ";
            $parametros[] = '%' . $matricula . '%';
        }

        $sql .= "
        GROUP BY u.id_usuario, u.dni, u.nombre, v.marca
        ORDER BY u.nombre, v.marca
        LIMIT ? OFFSET ?
    ";
        $parametros[] = $limite;
        $parametros[] = $offset;

        try {
            $stmt = $pdo->prepare($sql);

            $i = 1;
            foreach ($parametros as $param) {
                if ($i > count($parametros) - 2) {
                    $stmt->bindValue($i, $param, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($i, $param);
                }
                $i++;
            }

            $stmt->execute();
            $inscritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en getInscritosEvento: " . $e->getMessage());
        } finally {
            $pdo = null;
        }

        return $inscritos;
    }

    public static function contarInscritosEvento(int $id_evento): int
    {
        $pdo = conexionBD::get();

        $sql = "
        SELECT COUNT(DISTINCT u.id_usuario) AS total
        FROM inscribe  AS i
        JOIN usuarios  AS u ON u.id_usuario = i.id_usuario
        JOIN eventos   AS e ON e.id_evento  = i.id_evento
        JOIN vehiculos AS v ON v.id_usuario = i.id_usuario
        WHERE i.id_evento = :id_evento
        AND e.requisitos = v.marca
    ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_evento', $id_evento, PDO::PARAM_INT);
        $stmt->execute();
        $total = (int) $stmt->fetchColumn();

        $pdo = null;
        return $total;
    }
}
