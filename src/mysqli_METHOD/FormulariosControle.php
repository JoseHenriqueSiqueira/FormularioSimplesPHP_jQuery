<?php

require_once 'Usuario.php';

class Formularios 
{
    public function __construct($request)
    {
        switch ($request['formulario']) 
        {
            case 'cadastro':
                $this->cadastrar($request['nome'], $request['idade'], $request['telefone'], $request['cpf'], $request['senha']);
                break;
            case 'atualizar':
                $this->atualizar($request['nome'], $request['idade'], $request['telefone'], $request['cpf'], $request['senha']);
                break;
            case 'consulta':
                $this->consultar($_REQUEST['cpf'], $_REQUEST['senha']);
                break;
        }
    }
    
    private function cadastrar($nome, $idade, $telefone, $cpf, $senha) 
    {
        $dao = new UsuarioDAO();
        $usuario = new Usuario($nome, $idade, $telefone, $cpf, $senha);
        $duplicados = $dao->check_duplicate($usuario);
        if ($duplicados > 0)
        {
            echo("TELEFONE OU CPF JÁ CADASTRADO");
        }
        else
        {
            $dao->add($usuario);
        }
    }            
    
    private function atualizar($nome, $idade, $telefone, $cpf, $senha) 
    {
        $dao = new UsuarioDAO();
        $usuario = new Usuario($nome, $idade, $telefone, $cpf, $senha);
        $duplicados = $dao->check_duplicate($usuario);
        if ($duplicados > 1)
        {
            echo("TELEFONE JÁ CADASTRADO");
        }
        else
        {
            $dao->update($usuario);
        } 
    }
    
    private function consultar($cpf, $senha) 
    {
        $dao = new UsuarioDAO();
        $usuario = new Usuario(null, null, null, $cpf, $senha);
        $user_data = $dao->get_user($usuario);
        echo json_encode($user_data);     
    }
}

?>