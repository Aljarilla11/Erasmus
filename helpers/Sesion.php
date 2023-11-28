<?php

class Sesion
{
    public static function iniciaSesion()
    {
        session_start();
    } 

    public static function cerrarSesion()
    {
        session_destroy();
    }

    public static function guardarSesion($clave, $valor)
    {
        $_SESSION[$clave] = $valor;
    }
}

?>
