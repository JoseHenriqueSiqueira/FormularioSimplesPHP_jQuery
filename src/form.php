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
        echo "Olá {$this->nome}!<br> Você têm {$this->idade} anos.";
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