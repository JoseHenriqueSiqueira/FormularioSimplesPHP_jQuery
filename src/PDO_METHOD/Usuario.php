<?php

require_once 'BaseDAO.php';

class UsuarioDAO extends BaseDAO
{
    function get_all()
    {
        return parent::execQUERY("SELECT * FROM usuarios");
    }

    function get_user(Usuario $usuario)
    {
        return parent::execQUERY("SELECT * FROM usuarios WHERE cpf = ? AND senha = ?",
        $usuario->cpf, $usuario->senha);
    }

    function check_duplicate(Usuario $usuario)
    {
        return parent::execQUERY("SELECT COUNT(*) AS total FROM usuarios WHERE telefone = ? or cpf = ?",
        $usuario->telefone, $usuario->cpf);
    }

    function add(Usuario $usuario)
    {
        parent::execDML("INSERT INTO usuarios (nome, idade, telefone, cpf, senha) VALUES (?, ?, ?, ?, ?)", 
        $usuario->nome, $usuario->idade, $usuario->telefone, $usuario->cpf, $usuario->senha);
    }

    function update(Usuario $usuario)
    {
        parent::execDML("UPDATE usuarios SET nome = ?, idade = ?, telefone = ?, senha = ? WHERE cpf = ?", 
        $usuario->nome, $usuario->idade, $usuario->telefone, $usuario->senha, $usuario->cpf);
    }

    function del(Usuario $usuario)
    {
        parent::execDML("DELETE FROM usuarios WHERE cpf = ?",
        $usuario->cpf);
    }
}

class Usuario 
{
    public $nome;
    public $idade;
    public $telefone;
    public $cpf;
    public $senha;

    public function __construct($nome, $idade, $telefone, $cpf, $senha)
    {
        $this->nome = $nome;
        $this->idade = $idade;
        $this->telefone = $telefone;
        $this->cpf = $cpf;
        $this->senha = $senha;
    }
}

?>