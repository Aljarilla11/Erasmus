<?php

// Obtener la lista de destinatarios
$repoDestinatarios = new RepositoryDestinatarios(null); // Puedes ajustar esto según tu lógica de construcción
$listaDestinatarios = $repoDestinatarios->obtenerDestinatarios();

class Register
{
    public static function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $dni = $_POST['dni'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $contrasena = $_POST['contrasena'];
            $fechaNacimiento = $_POST['fechaNacimiento'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $domicilio = $_POST['domicilio'];
            $tutor = $_POST['tutor'];

            // Llamada a la función register con la lista de destinatarios
            FuncionesLogin::register($dni, $nombre, $apellidos, $contrasena, $fechaNacimiento, $telefono, $correo, $domicilio, $tutor, $listaDestinatarios);
        }
    }
}

// Llamar al método para registrar usuarios
Register::registerUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Formulario de Registro</title>
    <link rel="stylesheet" href="../estilos/estiloRegistro.css">
    <script src="../js/ComprobarEdad.js"></script>
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form action="" method="POST">
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required><br><br>

        <label for="nombre">Nombre de Usuario:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required><br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br><br>

        <label for="fechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fechaNacimiento" name="fechaNacimiento" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required><br><br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required><br><br>

        <label for="domicilio">Domicilio:</label>
        <input type="text" id="domicilio" name="domicilio" required><br><br>

        <label for="curso">Curso:</label>
        <select id="curso" name="curso">
            <option value="">Seleccione un curso</option>
            <?php
            foreach ($listaDestinatarios as $destinatario) {
                $codGrupo = $destinatario['cod_grupo'];
                $nombreGrupo = $destinatario['nombre'];
                echo "<option value='{$codGrupo}'>{$codGrupo} - {$nombreGrupo}</option>";
            }
            ?>
        </select><br><br>

        <div id="seccionTutor" style="display:none;">
            <h2>Datos del Tutor</h2>
            <label for="tutorDni">DNI del Tutor:</label>
            <input type="text" id="tutorDni" name="tutorDni"><br><br>

            <label for="tutorNombre">Nombre del Tutor:</label>
            <input type="text" id="tutorNombre" name="tutorNombre"><br><br>

            <label for="tutorApellidos">Apellidos del Tutor:</label>
            <input type="text" id="tutorApellidos" name="tutorApellidos"><br><br>

            <label for="tutorTelefono">Teléfono del Tutor:</label>
            <input type="text" id="tutorTelefono" name="tutorTelefono"><br><br>

            <label for="tutorDomicilio">Domicilio del Tutor:</label>
            <input type="text" id="tutorDomicilio" name="tutorDomicilio"><br><br>
         </div>

        <input type="submit" name="enviar" value="Registrarse">
    </form>
</body>
</html>
