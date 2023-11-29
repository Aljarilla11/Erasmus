<?php
class Cargador
{
    public static function autocargar()
    {
        spl_autoload_register('autocarga');
    }
   
}

function autocarga($clase)
{
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/helpers" . "/" .$clase .".php"))
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."/helpers" . "/" . $clase .".php";
    }
    else if(file_exists($_SERVER["DOCUMENT_ROOT"]."/forms" . "/" .$clase .".php"))
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."/forms" . "/" . $clase .".php";
    }
    else if(file_exists($_SERVER["DOCUMENT_ROOT"]."/api" . "/" .$clase .".php"))
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."/api" . "/" . $clase .".php";
    }
    else if(file_exists($_SERVER["DOCUMENT_ROOT"]."/repository" . "/" .$clase .".php"))
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."/repository" . "/" . $clase .".php";
    } 
    else if(file_exists($_SERVER["DOCUMENT_ROOT"]."/vistas" . "/" .$clase .".php"))
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."/vistas" . "/" . $clase .".php";
    }

}

Cargador::autocargar();

?>