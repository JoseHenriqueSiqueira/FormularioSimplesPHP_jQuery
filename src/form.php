<?php

class UserData
{
    private $conn;

    public function __construct($servername, $username, $password, $dbname)
    {
        // Cria a conexão
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica se houve erro na conexão
        if ($this->conn->connect_error) 
        {
            die("CONEXÃO FALHOU: " . $this->conn->connect_error);
        }
    }

    // Método responsavel por verificar o cpf e o número de telefone na tabela.
    public function check_data($cpf, $phone)
    {

        $sqlCPF = "SELECT COUNT(*) AS total FROM usuarios where cpf = '{$cpf}'";
        $sqlTELEFONE = "SELECT COUNT(*) AS total FROM usuarios where telefone = '{$phone}'";

        $cpfResult = $this->conn->query($sqlCPF)->fetch_assoc(); 
        $cpfCount = $cpfResult['total'];
    
        $phoneResult = $this->conn->query($sqlTELEFONE)->fetch_assoc(); 
        $phoneCount = $phoneResult['total'];
        
        // Verifica se o campo CPF já esta cadastrado
        if ($cpfCount > 0)
        {
            $this->conn->close();
            die("CPF JÁ CADASTRADO");
        }

        // Verifica se o campo numero já esta cadastrado
        if ($phoneCount > 0)
        {
            $this->conn->close();
            die("TELEFONE JÁ CADASTRADO");
        }
    }

    // Método responsavel por salvar os dados do usuário no banco de dados.
    public function save_data($nome, $idade, $phone, $cpf, $password) 
    {
        // Convertendo para hash
        $hash = password_hash($password, PASSWORD_BCRYPT);

        // Insere os dados na tabela
        $sql = "INSERT INTO usuarios (nome, idade, telefone, cpf, senha) VALUES ('{$nome}', '{$idade}', '{$phone}', '{$cpf}', '{$hash}')";

        // Verifica se a inserção foi feita.
        if ($this->conn->query($sql) === TRUE) 
        {
            echo "DADOS SALVOS COM SUCESSO!";
        }
        else 
        {
            echo "Erro: " . $sql . "<br>" . $this->conn->error;
        }

        // Fecha a conexão
        $this->conn->close();
    }

    public function get_data($cpf, $password) 
    {

        // Insere os dados na tabela
        $sql = "SELECT nome, idade, telefone, cpf, senha FROM usuarios WHERE cpf = '{$cpf}'";
        // Obtendo os dados através da consulta SQL
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) 
        {
            // Exibe os dados do usuário
            while ($row = $result->fetch_assoc()) 
            {
                // Verifica se a senha fornecida pelo usuário corresponde à senha armazenada no banco de dados
                if (password_verify($password, $row['senha'])) {
                    echo "Nome: " . $row["nome"] . "<br>";
                    echo "Idade: " . $row["idade"] . "<br>";
                    echo "CPF: " . $row["cpf"] . "<br>";
                    echo "Telefone: " . $row["telefone"] . "<br>";
                } else {
                    echo "Senha incorreta.";
                }
            }
        } 
        else 
        {
            echo "NENHUM USUÁRIO ENCONTRADO COM O CPF INFORMADO.";
        }
        // Fecha a conexão
        $this->conn->close();
    }

    public function check_values($cpf, $password)
    {
        if (strlen($cpf) < 14)
        {
            $this->conn->close();
            die("CPF INVÁLIDO");
        }
        else if(strlen($password) < 8)
        {
            $this->conn->close();
            die("A SENHA DEVE SER NO MINÍMO 8 DÍGITOS");
        }
    }
}


// Criando a conexão
$servername = ""; // Declare seu servername
$username = ""; // Declare o nome de usuario do seu servidor
$password = ""; // Insira a senha do servidor
$dbname = "phpbase"; // Insira o nome do banco de dados criado. Por padrão esta 'phpbase', pois foi o nome que deixei no script 'database.sql'.
$user = new UserData($servername, $username, $password, $dbname); // Instanciando a classe UserData e criando a conexão.



if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (!empty($_POST["name"]) && !empty($_POST["age"]) && !empty($_POST["phone"]) && !empty($_POST["cpf"])) 
    {
        $cpf = $_POST["cpf"];
        $password = $_POST['password'];
        $nome = $_POST["name"];
        $idade = $_POST["age"];
        $phone = $_POST["phone"];
        $user->check_values($cpf, $password); // Verifica se a senha e o CPF sao válidos
        $user->check_data($cpf, $phone); // Verifica se o cpf e o número de telefone já estão cadastrado no banco de dados.
        $user->save_data($nome, $idade, $phone, $cpf, $password); // Método para salvar os dados.
    } 
    else 
    {
        echo "POR FAVOR, PREENCHA TODOS OS CAMPOS.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
    $cpf = $_GET["cpf"];
    $password = $_GET["password"];
    $user->check_values($cpf, $password); // Verifica se a senha e o CPF sao válidos
    $user->get_data($cpf, $password); // Método para consultar dados
}

?>