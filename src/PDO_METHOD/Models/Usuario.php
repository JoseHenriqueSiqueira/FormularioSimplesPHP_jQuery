<?php

class Usuario 
{
    private $nome;
    private $idade;
    private $telefone;
    private $cpf;
    private $senha;

    public function __construct($nome, $idade, $telefone, $cpf, $senha)
    {
        $this->nome = $nome;
        $this->idade = $idade;
        $this->telefone = $telefone;
        $this->cpf = $cpf;
        $this->senha = $senha;
    }

    // Getters
    public function getNome()
    {
        return $this->nome;
    }

    public function getIdade()
    {
        return $this->idade;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    // Setters
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setIdade($idade)
    {
        $this->idade = $idade;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

}


?>