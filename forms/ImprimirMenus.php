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
                <a href="?menu=modificarconvocatoria">Modificar Convocatoria</a>
            </li>
            <li class="submenu">
                <a href="?menu=administrarsolicitud">Administrar Solicitudes</a>
            </li>
        </ul>
        <?php
        if (isset($_GET['menu']) && $_GET['menu'] === 'admin') {
            echo '<img class="imagen" src="./imagenes/becas.jpg" alt="">';
        }
        ?>
        </body>
        </html>
        <?php
    }

    public static function imprimirMenuAlumno()
    {
        $conexion = Db::conectar();
        $dni = Sesion::leerSesion('usuario');

        $sql = "SELECT id FROM candidatos WHERE dni = :dni";
        $statement = $conexion->prepare($sql);
        $statement->bindParam(':dni', $dni, PDO::PARAM_STR);
        $statement->execute();

        $resultado = $statement->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $idCandidato = $resultado['id'];
            //var_dump($idCandidato);
        }
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
    <a href="?menu=versolicitud&idCandidato=<?= $idCandidato ?>">Ver Solicitudes Echadas</a>
    </li>
</ul>

<?php
if (isset($_GET['menu']) && $_GET['menu'] === 'alumno') {
    echo '<img class="imagen" src="./imagenes/infobeca.png" alt="">';
}
?>

</body>
</html>


        <?php
    }
}
?>
