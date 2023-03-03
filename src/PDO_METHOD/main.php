<?php

require_once 'FormulariosControle.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $controller = new Formularios($_REQUEST);
}

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $controller = new Formularios($_REQUEST);
}

?>