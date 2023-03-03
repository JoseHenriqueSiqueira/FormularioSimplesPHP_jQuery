<?php

require_once "Config.php";

class BaseDAO
{
    // Data Manipulation Language function
    protected function execDML($sql, ...$params)
    {
        global $dsn;
        $pdo = new PDO($dsn, USER, PASSWORD,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        try
        {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
        }
        finally
        {
            $pdo = null;
        }
    }

    // SQL Query
    protected function execQUERY($sql, ...$params)
    {
        global $dsn;
        $objetos = [];
        $pdo = new PDO($dsn, USER, PASSWORD,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        try
        {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $objetos = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $objetos;
        }
        catch(PDOException $e)
        {
            $objetos = [];
        }
        finally
        {
            $pdo = null;
            return $objetos;
        }
    } 
}

?>