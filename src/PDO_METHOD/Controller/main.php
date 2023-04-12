<?php

require_once 'UsuarioController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $controller = new UsuarioController($_REQUEST);
}

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $controller = new UsuarioController($_REQUEST);
}

?>