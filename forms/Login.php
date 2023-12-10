<?php

class Login
{
    public static function loginUser()
    {
        //Sesion::iniciaSesion();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $dni = $_POST['dni'];
            $password = $_POST['password'];
            FuncionesLogin::login($dni, $password);  
        }
    }
}

// Manejar el inicio de sesión
Login::loginUser();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Formulario de Inicio de Sesión</title>
    <link rel="stylesheet" href="../estilos/estiloLogin.css">
</head>
<body id="bodyLogin">
    <h1>Iniciar Sesión</h1>
    <form action="" method="POST">
        <label for="dni_usuario">DNI del Usuario:</label>
        <input type="text" id="dni" name="dni" required><br><br>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" id="btnIniciarSesion" name="enviar" value="Iniciar Sesión">
    </form>
</body>
</html>
