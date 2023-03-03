<?php

require_once "Config.php";

class BaseDAO
{
    // Data Manipulation Language function
    protected function execDML($sql, $params, $paramstypes)
    {
        $mysqli = new mysqli(HOST, USER, PASSWORD, DBNAME);
        // Verifica se o tamanho do $paramtypes é igual a 1.
        if (strlen($paramstypes) === 1) 
        {
            // Caso maior, transforma em uma única array os parâmetros $paramtypes e $params.
            $allparams = array($paramstypes, $params);
        } 
        else 
        {
            // Caso maior, converte o parâmetro $paramtypes em uma ARRAY e fundi com a ARRAY $params.
            $allparams = array_merge(array($paramstypes), $params);
        }
        try
        {
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param(...$allparams);
            $stmt->execute();
        }
        finally
        {
            $stmt->close();
            $mysqli->close();
        }
    }

    // SQL Query
    protected function execQUERY($sql, $params, $paramstypes)
    {
        $mysqli = new mysqli(HOST, USER, PASSWORD, DBNAME);
        // Verifica se o tamanho do $paramtypes é igual a 1.
        if (strlen($paramstypes) === 1) 
        {
            // Caso maior, transforma em uma única array os parâmetros $paramtypes e $params.
            $allparams = array($paramstypes, $params);
        } 
        else 
        {
            // Caso maior, converte o parâmetro $paramtypes em uma ARRAY e fundi com a ARRAY $params.
            $allparams = array_merge(array($paramstypes), $params);
        }
        try
        {
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param(...$allparams);
            $stmt->execute();
        }
        catch(Exception $e)
        {
            $mysqli->close();
        }
        finally
        {
            return ['mysqli' => $mysqli, 'stmt' => $stmt];
        }
    } 
}

?>