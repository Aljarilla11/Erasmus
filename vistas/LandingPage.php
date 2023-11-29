<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AUTOESCUELA ILITURGI</title>
</head>

<body>
    <?php
        require_once './vistas/Header.php';
    ?>
    <section>
        <div id="cuerpo">
        <?php
           require_once './vistas/Enruta.php';
        ?>
        </div>
    </section>

    <?php 
        require_once './vistas/Footer.php';
    ?>

</body>

</html>