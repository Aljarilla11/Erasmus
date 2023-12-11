<?php
class ImprimirMenus
{
    public static function imprimirMenuAdmin()
    {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Menu</title>
            <link rel="stylesheet" href="../estilos/estiloMenuAdmin.css">
        </head>
        <body>

        <ul class="menu">
            <li class="submenu">
                <a href="?menu=crearconvocatoria">Crear Convocatoria</a>
            </li>
            <li class="submenu">
                <a href="?menu=adminuser">Modificar Convocatoria</a>
            </li>
            <li class="submenu">
                <a href="?menu=adminuser">Administrar Solicitudes</a>
            </li>
        </ul>
        </body>
        </html>
        <?php
    }

    public static function imprimirMenuAlumno()
    {
        ?>
            <!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" href="../estilos/estiloMenuAlumno.css">
</head>
<body>

<ul class="menu">
    <li class="submenu">
        <a href="?menu=listarconvocatorias">Ver Convocatorias</a>
    </li>
    <li class="submenu">
        <a href="?menu=crearPregunta">Ver Solicitudes Echadas</a>
    </li>
</ul>

</body>
</html>


        <?php
    }
}
?>
