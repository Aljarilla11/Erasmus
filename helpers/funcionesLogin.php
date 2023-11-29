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

    public static function register($dni, $nombre, $apellidos, $contrasena, $fechaNacimiento, $telefono, $correo, $domicilio, $tutor, $listaDestinatarios)
    {
        // Sustituye 'tu_tabla_de_usuarios' con el nombre real de tu tabla de usuarios
        $rol = 'alumno';

        self::iniciarConexion();

        if (isset($_POST['enviar'])) 
        {
            // Comprobar si el DNI ya existe en la base de datos
            $queryVerificacion = "SELECT COUNT(*) as count FROM candidatos WHERE dni = :dni";
            $stmtVerificacion = self::$conexion->prepare($queryVerificacion);
            $stmtVerificacion->bindParam(':dni', $dni);
            $stmtVerificacion->execute();

            $row = $stmtVerificacion->fetch(PDO::FETCH_ASSOC);

            if ($row['count'] > 0) 
            {
                echo "DNI ya existente. Por favor, elige otro.";
            } else {
                // El DNI no existe, proceder con la inserción

                // Obtener el valor del curso seleccionado
                $curso = isset($_POST['curso']) ? $_POST['curso'] : null;

                
                if (empty($tutor)) {
                    $tutor = null;
                }
    

                // Insertar el registro en la tabla candidatos
                $query = "INSERT INTO candidatos (dni, nombre, apellidos, contrasena, fecha_nacimiento, telefono, correo, domicilio, curso, id_tutor, rol) 
                          VALUES (:dni, :nombre, :apellidos, :contrasena, :fechaNacimiento, :telefono, :correo, :domicilio, :curso, :tutor, :rol)";
                
                $stmt = self::$conexion->prepare($query);
                $stmt->bindParam(':dni', $dni);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':apellidos', $apellidos);
                $stmt->bindParam(':contrasena', $contrasena);
                $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
                $stmt->bindParam(':telefono', $telefono);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':domicilio', $domicilio);
                $stmt->bindParam(':curso', $curso);
                $stmt->bindParam(':tutor', $tutor);
                $stmt->bindParam(':rol', $rol);


                $stmt->execute();

                // Redirigir después de la inserción
                // header('Location: ?menu=login');
                // exit(); // Asegurarse de que el script se detenga después de redirigir
            }
        }
    }
}
?>
    

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
