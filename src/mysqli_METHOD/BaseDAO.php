<?php

require_once "Config.php";

class BaseDAO
{
    // Conexão com o banco de dados 
    private function connection()
    {
        try 
        {
            // Tenta criar uma conexão com o banco de dados
            $mysqli = new mysqli(HOST, USER, PASSWORD, DBNAME);
            // Verifica se houve erro na conexão
            if ($mysqli->connect_errno)
            {
                throw new Exception($mysqli->connect_error);
            }
            return $mysqli;    
        }
        catch (Exception $e) 
        {
            // Caso tenha ocorrido um erro, exibe a mensagem de erro e encerra a execução do script
            die($e->getMessage());
        }
    }

    // Tratamento dos parâmetros
    private function paramscheck($params, $paramstypes)
    {
        // Verifica se o tamanho do $paramtypes é igual a 1.
        if (strlen($paramstypes) === 1) 
        {
            // Caso maior, transforma em uma única array os parâmetros $paramtypes e $params.
            $allparams = array($paramstypes, $params);
        } 
        else 
        {
            // Caso maior, converte o parâmetro $paramtypes em uma ARRAY e funde com a ARRAY $params.
            $allparams = array_merge(array($paramstypes), $params);
        }
        return $allparams;
    }

    // Data Manipulation Language function
    protected function execDML($sql, $params, $paramstypes)
    {
        $mysqli = $this->connection();
        $allparams = $this->paramscheck($params, $paramstypes);
        try
        {
            // Prepara a query para execução
            $stmt = $mysqli->prepare($sql);
            // Associa os parâmetros à query
            $stmt->bind_param(...$allparams);
            // Executa a query
            $stmt->execute();
        }
        finally
        {
            // Fecha o statement e a conexão com o banco de dados
            $stmt->close();
            $mysqli->close();
        }
    }

    // SQL Query
    protected function execQUERY($sql, $params, $paramstypes)
    {
        $mysqli = $this->connection();
        $allparams = $this->paramscheck($params, $paramstypes);
        try
        {
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param(...$allparams);
            $stmt->execute();
        }
        catch(Exception $e)
        {
            $mysqli->close();
            $stmt->close();
        }
        finally
        {
            return ['mysqli' => $mysqli, 'stmt' => $stmt];
        }
    } 

}

?>