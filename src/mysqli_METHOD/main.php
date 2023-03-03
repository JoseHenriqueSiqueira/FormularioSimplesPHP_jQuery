<?php

require_once 'FormulariosControle.php';

// Verifica o tipo de requisição feita pelo o usuário
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $controller = new Formularios($_REQUEST);   
}

if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
    $controller = new Formularios($_REQUEST);
}

?>