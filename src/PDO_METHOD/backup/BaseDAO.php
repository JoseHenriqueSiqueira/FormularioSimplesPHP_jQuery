<?php

require_once 'Config.php';

class BaseDAO
{

    /**
     * Método privado que realiza a conexão com o banco de dados através do PDO.
     * @throws Exception se houver erro na conexão.
     * @return PDO a conexão estabelecida
     */
    private function connection()
    {
        global $dsn; // Utiliza a variável global $dsn, definida no arquivo 'Config.php'

        try 
        {
            $conn = new PDO($dsn, USER, PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Instancia um objeto PDO com as informações de conexão e com o modo de erro configurado para lançar exceções.
        } 
        catch (PDOException $e) 
        {
            throw new Exception($e->getMessage()); // Se ocorrer um erro ao tentar se conectar ao banco de dados, lança uma exceção com a mensagem de erro.
        } 

        return $conn; // Retorna a conexão estabelecida com o banco de dados.
        
    }

    /**
     * Executa uma Query SQL (Consulta).
     * @param string $sql Declaração SQL a ser executada.
     * @param mixed ...$params Parâmetros da declaração SQL
     * @throws Exception Se ocorrer uma exceção durante a Query.
     * @return array $objects Objetos da consulta SQL.
     */
    protected function execQUERY(string $sql, ...$params)
    {
        // Inicia uma conexão através do método privado connection().
        $conn = $this->connection();

        try
        {
            $stmt = $conn->prepare($sql); // Prepara a declaração SQL.
            $stmt->execute($params); // Executa a declaração com os parâmetros.
            $data = $stmt->fetch(PDO::FETCH_ASSOC); // Obtém a primeira linha do resultado como um array associativo
        }
        catch (PDOException $e) 
        {
            throw new Exception($e->getMessage()); // Lança a exceção para que possa ser tratada posteriormente.
        }
        finally
        {
            $conn = null; // Fecha a conexão.
            return $data; // Retorna os objetos
        }

    }

    /**
     * Executa uma declaração DML (Data Manipulation Language).
     * @param string $sql Declaração SQL a ser executada.
     * @param mixed ...$params Parâmetros da declaração SQL
     * @throws Exception Se ocorrer uma exceção durante a transação.
     * @return void
     */
    protected function execDML(string $sql, ...$params)
    {
        // Inicia uma conexão através do método privado connection().
        $conn = $this->connection();

        try
        {
            error_log('Starting Transaction'); // Adiciona um log para o início da transação.
            $conn->beginTransaction(); // Inicia a transação.        
            $stmt = $conn->prepare($sql); // Prepara a declaração SQL.          
            $stmt->execute($params); // Executa a declaração com os parâmetros.           
            $conn->commit(); // Faz commit na transação.
            error_log('Transaction committed'); // Adiciona um log informando que a transação foi feita com sucesso.
        }
        catch (PDOException $e) 
        {
            $conn->rollBack(); // Caso ocorra uma exceção durante a transação, faz rollback.
            error_log('Transaction rolled back: ' . $e->getMessage()); // Adiciona um log informando que a transação foi revertida e exibe a mensagem de erro.
            throw new Exception($e->getMessage()); // Lança a exceção para que possa ser tratada posteriormente.
        }
        finally
        {
            $conn = null; // Fecha a conexão.
            error_log('Connection closed'); // Adiciona um log informando que a conexão foi fechada.
        }
    }

}

?>