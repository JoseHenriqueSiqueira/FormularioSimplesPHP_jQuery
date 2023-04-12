<?php

require_once '../DAO/BaseDAO.php';
require_once '../Models/Usuario.php';

class UsuarioDAO extends BaseDAO
{

    /*
    Método em Construção
    function check_duplicate(Usuario $usuario)
    {
        return parent::execQUERY("SELECT COUNT(*) AS total FROM usuarios WHERE telefone = ? or cpf = ?",
        $usuario->getTelefone(), $usuario->getCpf());
    }
    */

    function get_User(Usuario $usuario)
    {
        return parent::execQUERY("SELECT * FROM usuarios WHERE cpf = ? AND senha = ?",
        $usuario->getCpf(), $usuario->getSenha());
    }

    function insert(Usuario $usuario)
    {
        parent::execDML("INSERT INTO usuarios (nome, idade, telefone, cpf, senha) VALUES (?, ?, ?, ?, ?)", 
        $usuario->getNome(), $usuario->getIdade(), $usuario->getTelefone(), $usuario->getCpf(), $usuario->getSenha());
    }

    function update(Usuario $usuario)
    {
        parent::execDML("UPDATE usuarios SET nome = ?, idade = ?, telefone = ?, senha = ? WHERE cpf = ?", 
        $usuario->getNome(), $usuario->getIdade(), $usuario->getTelefone(), $usuario->getSenha(), $usuario->getCpf());
    }

    function delete(Usuario $usuario)
    {
        parent::execDML("DELETE FROM usuarios WHERE cpf = ?",
        $usuario->getCpf());
    }
}

?>