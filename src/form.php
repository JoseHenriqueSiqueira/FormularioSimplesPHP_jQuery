<?php

class Person 
{
    private $nome;
    private $idade;

    public function __construct($nome, $idade)
    {
        $this->nome = $nome;
        $this->idade = $idade;
    }

    public function apresentar() {
        echo "<p> Olá <b>{$this->nome}</b>!
        <p> Você têm <b>{$this->idade}</b> anos.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (!empty($_POST["name"]) && !empty($_POST["age"])) 
    {
        $nome = $_POST["name"];
        $idade = $_POST["age"];
        $person = new Person($nome, $idade);
        echo $person->apresentar();
    } 
    else 
    {
        echo "<p> Por favor, preencha todos os campos.";
    }
}

?>