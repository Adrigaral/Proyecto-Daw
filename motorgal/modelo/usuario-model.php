<?php
include_once("conexionBD.php");
class Usuario
{
    private int $id_usuario;
    private string $dni;
    private string $nombre;
    private string $correo_electronico;
    private string $username;
    private string $contrasinal;
    private string $tipo_usuario;
    private string $estado_usuario;
    private string $foto_perfil;

    public function __construct(string $dni, string $nombre, string $correo_electronico, string $username, string $contrasinal, string $tipo_usuario, string $estado_usuario, string $foto_perfil, int $id = null)
    {
        if (isset($id)) {
            $this->id_usuario = $id;
        }
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->correo_electronico = $correo_electronico;
        $this->username = $username;
        $this->contrasinal = $contrasinal;
        $this->tipo_usuario = $tipo_usuario;
        $this->estado_usuario = $estado_usuario;
        $this->foto_perfil = $foto_perfil;
    }

    /**
     * Get the value of id_cliente
     */
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     * Set the value of id_cliente
     *
     * @return  self
     */
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }


    /**
     * Get the value of id_cliente
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set the value of id_cliente
     *
     * @return  self
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }


    /**
     * Get the value of correo_electronico
     */
    public function getCorreo_electronico()
    {
        return $this->correo_electronico;
    }

    /**
     * Set the value of correo_electronico
     *
     * @return  self
     */
    public function setCorreo_electronico($correo_electronico)
    {
        $this->correo_electronico = $correo_electronico;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of contrasinal
     */
    public function getContrasinal()
    {
        return $this->contrasinal;
    }

    /**
     * Set the value of contrasinal
     *
     * @return  self
     */
    public function setContrasinal($contrasinal)
    {
        $this->contrasinal = $contrasinal;

        return $this;
    }

    /**
     * Get the value of tipo_usuario
     */
    public function getTipo_usuario()
    {
        return $this->tipo_usuario;
    }

    /**
     * Set the value of tipo_usuario
     *
     * @return  self
     */
    public function setTipo_usuario($tipo_usuario)
    {
        $this->tipo_usuario = $tipo_usuario;

        return $this;
    }

    /**
     * Get the value of estado_usuario
     */
    public function getEstado_usuario()
    {
        return $this->estado_usuario;
    }

    /**
     * Set the value of estado_usuario
     *
     * @return  self
     */
    public function setEstado_usuario($estado_usuario)
    {
        $this->estado_usuario = $estado_usuario;

        return $this;
    }

    /**
     * Get the value of foto_perfil
     */
    public function getFoto_perfil()
    {
        return $this->foto_perfil;
    }

    /**
     * Set the value of foto_perfil
     *
     * @return  self
     */
    public function setFoto_perfil($foto_perfil)
    {
        $this->foto_perfil = $foto_perfil;

        return $this;
    }
}

class UsuarioModel
{

    public static function validarDNI($dni)
    {
        // Formato correcto: 8 números + 1 letra
        if (!preg_match('/^\d{8}[A-Za-z]$/', $dni)) {
            return false;
        }

        $numero = substr($dni, 0, 8);
        $letra = strtoupper(substr($dni, -1));

        $letras_validas = "TRWAGMYFPDXBNJZSQVHLCKE";
        $letra_correcta = $letras_validas[intval($numero) % 23];

        return $letra === $letra_correcta;
    }

    public static function existe_dni(string $dni): bool
    {
        $toret = false;
        $pdo = conexionBD::get();
        $sql = "SELECT 1 FROM usuarios WHERE dni = ? LIMIT 1";

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $dni, PDO::PARAM_STR);
            $statement->execute();
            $toret = $statement->fetchColumn() !== false;
        } catch (PDOException $e) {
            error_log("Error comprobando DNI: " . $e->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }

        return $toret;
    }

    public static function existe_username(string $username): bool
    {
        $toret = false;
        $pdo = conexionBD::get();
        $sql = "SELECT 1 FROM usuarios WHERE username = ? LIMIT 1";
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $username, PDO::PARAM_STR);
            $statement->execute();
            $toret = $statement->fetchColumn() !== false;
        } catch (PDOException $e) {
            error_log("Error comprobando username: " . $e->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }
        return $toret;
    }

    public static function get_usuario($id_usuario): ?Usuario
    {
        $usuario = [];
        $pdo = conexionBD::get();
        $sql = "SELECT id_usuario, dni, nombre, correo_electronico, username, contrasinal, tipo_usuario, estado_usuario, foto_perfil 
            FROM usuarios 
            WHERE id_usuario = ?";

        try {
            $statement = $pdo->prepare($sql);
            $statement->execute([$id_usuario]);
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $usuario = new Usuario(
                    $row['dni'],
                    $row['nombre'],
                    $row['correo_electronico'],
                    $row['username'],
                    $row['contrasinal'],
                    $row['tipo_usuario'],
                    $row['estado_usuario'],
                    $row['foto_perfil'],
                    $row['id_usuario']
                );
            }
        } catch (PDOException $th) {
            error_log("Error obteniendo usuario: " . $th->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }

        return $usuario;
    }

    public static function get_usuarios(): array
    {
        $usuarios = [];
        $pdo = conexionBD::get();
        $sql = "SELECT id_usuario, dni, nombre, correo_electronico, username, tipo_usuario, estado_usuario, foto_perfil FROM usuarios";

        try {
            $statement = $pdo->query($sql);
            foreach ($statement as $row) {
                $usuario = new Usuario(
                    $row['id_usuario'],
                    $row['dni'],
                    $row['nombre'],
                    $row['correo_electronico'],
                    $row['username'],
                    $row['tipo_usuario'],
                    $row['estado_usuario'],
                    $row['foto_perfil']
                );
                $usuarios[] = $usuario;
            }
        } catch (PDOException $th) {
            error_log("Error obteniendo usuarios de la BD. " . $th->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }
        return $usuarios;
    }

    public static function get_id_usuario($username)
    {
        $id_usuario = null;
        $pdo = conexionBD::get();
        $sql = "SELECT id_usuario FROM usuarios WHERE username = ?";

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $username, PDO::PARAM_STR);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $id_usuario = $row['id_usuario'];
            }
        } catch (PDOException $th) {
            error_log("Error obteniendo el id_usuario de la BD. " . $th->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }

        return $id_usuario;
    }



    public static function comprobar_usuario(string $username, string $contrasinal)
    {
        $pdo = conexionBD::get();
        $sql = "SELECT tipo_usuario FROM usuarios WHERE username = ? AND contrasinal = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $username, PDO::PARAM_STR);
        $query->bindValue(2, sha1($contrasinal), PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $query = null;
        $pdo = null;

        return $result['tipo_usuario'] ?? false; // 'PREMIUM', 'NORMAL', o false si no existe
    }

    public static function insertar_usuario(Usuario $u)
    {
        $toret = false;
        $pdo = conexionBD::get();
        $sql = "INSERT INTO usuarios(dni, nombre, correo_electronico, username, contrasinal, tipo_usuario, estado_usuario, foto_perfil) VALUES (?,?,?,?,?,?,?,?)";

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $u->getDni(), PDO::PARAM_STR);
            $statement->bindValue(2, $u->getNombre(), PDO::PARAM_STR);
            $statement->bindValue(3, $u->getCorreo_electronico(), PDO::PARAM_STR);
            $statement->bindValue(4, $u->getUsername(), PDO::PARAM_STR);
            $statement->bindValue(5, sha1($u->getContrasinal()), PDO::PARAM_STR);
            $statement->bindValue(6, $u->getTipo_usuario(), PDO::PARAM_STR);
            $statement->bindValue(7, $u->getEstado_usuario(), PDO::PARAM_STR);
            $statement->bindValue(8, $u->getFoto_perfil(), PDO::PARAM_STR);
            // $statement->debugDumpParams();
            $toret = $statement->execute();
        } catch (PDOException $th) {
            error_log("Error obteniendo usuarios de la BD. " . $th->getMessage());
            $toret = false;
        } finally {
            $pdo = null;
            $statement = null;
        }
        return $toret;
    }

    public static function actualizar_campo(int $id_usuario, string $campo, $valor): bool
    {
        $permitidos = ['correo_electronico', 'contrasinal', 'foto_perfil', 'estado_usuario'];
        if (!in_array($campo, $permitidos)) {
            error_log("Intento de actualizar campo no permitido: $campo");
            return false;
        }

        $pdo = conexionBD::get();
        $sql = "UPDATE usuarios SET $campo = ? WHERE id_usuario = ?";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $valor);
            $stmt->bindValue(2, $id_usuario, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error actualizando $campo: " . $e->getMessage());
            return false;
        } finally {
            $pdo = null;
            $stmt = null;
        }
    }
}
