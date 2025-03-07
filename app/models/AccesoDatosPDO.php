<?php

/*
 * Acceso a datos con BD Usuarios : 
 * Usando la librería PDO *******************
 * Uso el Patrón Singleton :Un único objeto para la clase
 * Constructor privado, y métodos estáticos 
 */
class AccesoDatos
{

    private static $modelo = null;
    private $dbh = null;

    public static function getModelo()
    {
        if (self::$modelo == null) {
            self::$modelo = new AccesoDatos();
        }
        return self::$modelo;
    }



    // Constructor privado  Patron singleton

    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DATABASE . ";charset=utf8";
            $this->dbh = new PDO($dsn, DB_USER, DB_PASSWD);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión " . $e->getMessage();
            exit();
        }
    }

    // Cierro la conexión anulando todos los objectos relacioanado con la conexión PDO (stmt)
    public static function closeModelo()
    {
        if (self::$modelo != null) {
            $obj = self::$modelo;
            // Cierro la base de datos
            $obj->dbh = null;
            self::$modelo = null; // Borro el objeto.
        }
    }

    // Mejora 4
    // Obtener el último ID insertado
    public function getLastInsertId()
    {
        return $this->dbh->lastInsertId();
    }


    // Devuelvo cuantos filas tiene la tabla

    public function numClientes(): int
    {
        $result = $this->dbh->query("SELECT id FROM Clientes");
        $num = $result->rowCount();
        return $num;
    }


    // SELECT Devuelvo la lista de Usuarios
    public function getClientes($primero, $cuantos, $orderBy = 'id'): array
    {
        $tuser = [];

        // Mejora 6 $orderBy
        $allowedOrders = ['id', 'first_name', 'last_name', 'email', 'gender', 'ip_address'];
        if (!in_array($orderBy, $allowedOrders)) {
            $orderBy = 'id';
        }
        // Crea la sentencia preparada
        // echo "<h1> $primero : $cuantos  </h1>";
        $stmt_usuarios  = $this->dbh->prepare("SELECT * FROM Clientes ORDER BY $orderBy LIMIT $primero,$cuantos");
        // Si falla termina el programa
        $stmt_usuarios->setFetchMode(PDO::FETCH_CLASS, 'Cliente');

        if ($stmt_usuarios->execute()) {
            while ($user = $stmt_usuarios->fetch()) {
                $tuser[] = $user;
            }
        }
        // Devuelvo el array de objetos
        return $tuser;
    }


    public function getCliente(int $id)
    {
        $cli = false;
        $stmt_cli = $this->dbh->prepare("
        SELECT 
            c.*,
            (SELECT MAX(id) FROM Clientes WHERE id < :id) as idAnterior,
            (SELECT MIN(id) FROM Clientes WHERE id > :id) as idSiguiente
        FROM Clientes c
        WHERE c.id = :id
    ");
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $stmt_cli->bindParam(':id', $id);

        if ($stmt_cli->execute()) {
            if ($obj = $stmt_cli->fetch()) {
                $cli = $obj;
            }
        }
        return $cli;
    }

    public function getClienteByEmail(string $email)
    {
        $cli = false;
        $stmt_cli = $this->dbh->prepare("SELECT * FROM Clientes WHERE email = :email");
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $stmt_cli->bindParam(':email', $email);

        if ($stmt_cli->execute()) {
            if ($obj = $stmt_cli->fetch()) {
                $cli = $obj;
            }
        }
        return $cli;
    }


    // UPDATE TODO
    public function modCliente($cli): bool
    {

        $stmt_moduser   = $this->dbh->prepare("update Clientes set first_name=:first_name,last_name=:last_name" .
            ",email=:email,gender=:gender, ip_address=:ip_address,telefono=:telefono WHERE id=:id");
        $stmt_moduser->bindValue(':first_name', $cli->first_name);
        $stmt_moduser->bindValue(':last_name', $cli->last_name);
        $stmt_moduser->bindValue(':email', $cli->email);
        $stmt_moduser->bindValue(':gender', $cli->gender);
        $stmt_moduser->bindValue(':ip_address', $cli->ip_address);
        $stmt_moduser->bindValue(':telefono', $cli->telefono);
        $stmt_moduser->bindValue(':id', $cli->id);

        $stmt_moduser->execute();
        $resu = ($stmt_moduser->rowCount() == 1);
        return $resu;
    }


    //INSERT 
    public function addCliente($cli): bool
    {

        // El id se define automáticamente por autoincremento.
        $stmt_crearcli  = $this->dbh->prepare(
            "INSERT INTO `Clientes`( `first_name`, `last_name`, `email`, `gender`, `ip_address`, `telefono`)" .
                "Values(?,?,?,?,?,?)"
        );
        $stmt_crearcli->bindValue(1, $cli->first_name);
        $stmt_crearcli->bindValue(2, $cli->last_name);
        $stmt_crearcli->bindValue(3, $cli->email);
        $stmt_crearcli->bindValue(4, $cli->gender);
        $stmt_crearcli->bindValue(5, $cli->ip_address);
        $stmt_crearcli->bindValue(6, $cli->telefono);
        $stmt_crearcli->execute();
        $resu = ($stmt_crearcli->rowCount() == 1);
        return $resu;
    }


    //DELETE 
    public function borrarCliente(int $id): bool
    {


        $stmt_boruser   = $this->dbh->prepare("delete from Clientes where id =:id");

        $stmt_boruser->bindValue(':id', $id);
        $stmt_boruser->execute();
        $resu = ($stmt_boruser->rowCount() == 1);
        return $resu;
    }


    // Evito que se pueda clonar el objeto. (SINGLETON)
    public function __clone()
    {
        trigger_error('La clonación no permitida', E_USER_ERROR);
    }

    // Mejora 8 - Función para verificar credenciales
    public function verificarUsuario(string $login, string $password): ?array
    {
        try {
            // Preparar consulta
            $stmt = $this->dbh->prepare("SELECT * FROM Usuarios WHERE login = :login");
            $stmt->bindParam(':login', $login);
            $stmt->execute();

            // Obtener usuario
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar usuario
            if (!$usuario) {
                error_log("Usuario no encontrado: $login");
                return null;
            }

            // Verificar contraseña
            if (!password_verify($password, $usuario['password'])) {
                error_log("Contraseña incorrecta para: $login");
                return null;
            }

            // Eliminar contraseña antes de devolver
            unset($usuario['password']);
            return $usuario;
        } catch (Exception $e) {
            error_log("Error en verificarUsuario: " . $e->getMessage());
            return null;
        }
    }

    // Extra Mejora 8 - Método para registrar un nuevo usuario
    public function registrarUsuario(string $login, string $password, int $rol): bool
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->dbh->prepare("INSERT INTO Usuarios (login, password, rol) VALUES (:login, :password, :rol)");
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $hash);
        $stmt->bindParam(':rol', $rol);
        return $stmt->execute();
    }
}
