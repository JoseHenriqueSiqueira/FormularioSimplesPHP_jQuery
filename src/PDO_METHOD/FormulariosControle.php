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
        foreach($dao->check_duplicate($usuario) as $duplicados)
        {
            if ($duplicados->total > 0)
            {
                echo("TELEFONE OU CPF JÁ CADASTRADO");
            }
            else
            {
                $dao->add($usuario);
            }
        }            
    }
    
    private function atualizar($nome, $idade, $telefone, $cpf, $senha) 
    {
        $dao = new UsuarioDAO();
        $usuario = new Usuario($nome, $idade, $telefone, $cpf, $senha);
        foreach($dao->check_duplicate($usuario) as $duplicados)
        {
            if ($duplicados->total > 0)
            {
                echo("TELEFONE JÁ CADASTRADO");
            }
            else
            {
                $dao->update($usuario);
            }
        }  
    }
    
    private function consultar($cpf, $senha) 
    {
        $dao = new UsuarioDAO();
        $usuario = new Usuario(null, null, null, $cpf, $senha);
        foreach($dao->get_user($usuario) as $user_data);
        {
            $user_data = get_object_vars($user_data);
        }
        echo json_encode($user_data);     
    }
}

?>