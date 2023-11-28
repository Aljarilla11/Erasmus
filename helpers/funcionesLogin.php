<?php

//require_once "../helpers/Sesion.php";
//require_once "../repository/Db.php";

class FuncionesLogin
{
    private static $conexion;

    public static function iniciarConexion()
    {
        self::$conexion = Db::conectar();
    }

    public static function login($nombre, $password)
    {
        //Sesion::iniciaSesion();

        if (isset($_POST['enviar'])) 
        {
                      
            if(self::existeUsuario($nombre, $password)) 
            {
                $role = self::obtenerRoleUsuario($nombre, $password);

                if ($role === 'admin') 
                {
                    Sesion::guardarSesion('usuario', $_SESSION['usuario'] = $nombre);
                    header('Location: ?menu=admin');
                    exit;
                } 
                elseif ($role === 'alumno') 
                {
                    Sesion::guardarSesion('usuario', $_SESSION['usuario'] = $nombre);
                    header('Location: ?menu=alumno');
                    exit;
                } 
                elseif ($role === 'profesor') 
                {
                    Sesion::guardarSesion('usuario', $_SESSION['usuario'] = $nombre);
                    header('Location: ?menu=profesor');
                    exit;
                } 
                else 
                {
                    echo "No tienes un rol para esta aplicacion";
                }
            }
        } 
        else 
        {
            echo "No se encuentra registrado";
        }   
    }

    public static function existeUsuario($nombre, $password)
    {
        //Sesion::iniciaSesion();
        self::iniciarConexion();

        // Utilizar sentencias preparadas para prevenir ataques de inyección de SQL
        $sql = "SELECT * FROM usuario WHERE nombre = :nombre AND password = :password AND role <> ''";
        $stmt = self::$conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }

    public static function obtenerRoleUsuario($nombre, $password)
    {
        //Sesion::iniciaSesion();
        self::iniciarConexion();

        $sql = "SELECT role FROM usuario WHERE nombre = :nombre AND password = :password";
        $stmt = self::$conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) 
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['role'];
        } 
        else 
        {
            return null;
        }
    }

    public static function estaLogeado()
    {
        if (isset($_SESSION['usuario'])) 
        {
            return true; // El usuario está autenticado
        } 
        else 
        {
            return false; // El usuario no está autenticado
        }
    }

    public static function logout()
    {
         Sesion::cerrarSesion();
         header('Location: ?menu=inicio');
         exit;
    }

    public static function register($nombre, $password)
    {
        // Sesion::iniciaSesion();
        self::iniciarConexion();

        if (isset($_POST['enviar'])) 
        {
            // Comprobar si el nombre de usuario ya existe en la base de datos
            $queryVerificacion = "SELECT COUNT(*) as count FROM usuario WHERE nombre = '$nombre'";
            $result = self::$conexion->query($queryVerificacion);
            $row = $result->fetch(PDO::FETCH_ASSOC);

            if ($row['count'] > 0) 
            {
                echo "Nombre de usuario ya existente. Por favor, elige otro.";
            } else {
                // El nombre de usuario no existe, proceder con la inserción
                $query = "INSERT INTO usuario (nombre, password) VALUES ('$nombre', '$password')";
                self::$conexion->exec($query);
                header('Location: ?menu=login');
            }
        }
    }

    public function obtenerRolPorNombre($nombreUsuario)
    {
        try {
            // Consulta preparada para obtener el rol del usuario por su nombre
            $conexion = Db::conectar();
            $query = "SELECT role FROM usuario WHERE nombre = :nombreUsuario";
            $statement = $conexion->prepare($query);
        
            $statement->bindParam(':nombreUsuario', $_SESSION['usuario'], PDO::PARAM_STR);
            $statement->execute();
        
            // Obtener el resultado de la consulta
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        
            if ($resultado) {
                $rolUsuario = $resultado['role'];
            } else {
                $rolUsuario = 'sinRol'; // Establece un valor predeterminado si el usuario no tiene un rol
            }
        } catch (PDOException $e) {
            // Manejar errores de conexión o consultas
            $rolUsuario = 'sinRol';
        }
     }
}

?>
