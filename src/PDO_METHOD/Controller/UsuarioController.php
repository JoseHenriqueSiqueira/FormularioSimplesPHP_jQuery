<?php

require_once '../Models/Usuario.php';
require_once '../DAO/UsuarioDAO.php';

class UsuarioController 
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
        $dao->insert($usuario); 
    }
    
    private function atualizar($nome, $idade, $telefone, $cpf, $senha) 
    {
        $dao = new UsuarioDAO();
        $usuario = new Usuario($nome, $idade, $telefone, $cpf, $senha);
        $dao->update($usuario);;
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