<?php
if (isset($_GET['menu'])) 
{
    if ($_GET['menu'] == "inicio") 
    {
        require_once 'index.php';
    }

    if ($_GET['menu'] == "login") 
    {
        require_once './forms/Login.php';
    }

    if ($_GET['menu'] == "registro") 
    {
        require_once './forms/Register.php';
    }

    if ($_GET['menu'] == "cerrarsesion") 
    {
        require_once './Vistas/Login.php';
     
    }

    if ($_GET['menu'] == "admin") 
    {
        require_once './forms/Admin.php';
    }

    if ($_GET['menu'] == "alumno") 
    {
        require_once './forms/Alumno.php';
    }
    if ($_GET['menu'] == "crearconvocatoria") 
    {
        require_once './forms/CrearConvocatoria.php';
    }
    if ($_GET['menu'] == "listarconvocatorias") 
    {
        require_once './forms/ListarConvocatorias.php';
    }
    if ($_GET['menu'] == "solicitarconvocatoria") 
    {
        require_once './forms/Solicitud.php';
    }
    if ($_GET['menu'] == "contacto") 
    {
        require_once './forms/Contacto.php';
    }
    if ($_GET['menu'] == "modificarconvocatoria") 
    {
        require_once './forms/ModificarConvocatoria.php';
    }
    if ($_GET['menu'] == "editarconvocatoria") 
    {
        require_once './forms/EditarConvocatoria.php';
    }
    if ($_GET['menu'] == "versolicitud") 
    {
        require_once './forms/VerSolicitudes.php';
    }


}
