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
            die("Conexão falhou: " . $this->conn->connect_error);
        }
    }

    // Método responsavel por verificar o cpf e o número de telefone na tabela.
    public function check_data($cpf, $phone)
    {

        $sqlCPF = "SELECT COUNT(*) AS total FROM usuarios where cpf = '{$cpf}'";
        $sqlTELEFONE = "SELECT COUNT(*) AS total FROM usuarios where telefone = '{$phone}'";
        
        foreach($this->conn->query($sqlCPF) as $row) 
        {
            $cpf = $row['total'];
        } 
        foreach($this->conn->query($sqlTELEFONE) as $row) 
        {
            $numero = $row['total'];
        }  

        // Verifica se o campo CPF já esta cadastrado
        if ($cpf > 0)
        {
            $this->conn->close();
            die("CPF já cadastrado");
        }

        // Verifica se o campo numero já esta cadastrado
        if ($numero > 0)
        {
            $this->conn->close();
            die("Telefone já cadastrado");
        }
    }

    // Método responsavel por salvar os dados do usuário no banco de dados.
    public function save_data($nome, $idade, $phone, $cpf) 
    {

        // Insere os dados na tabela
        $sql = "INSERT INTO usuarios (nome, idade, telefone, cpf) VALUES ('{$nome}', '{$idade}', '{$phone}', '{$cpf}')";

        // Verifica se a inserção foi feita.
        if ($this->conn->query($sql) === TRUE) 
        {
            echo "Dados Salvos com Sucesso!";
        }
        else 
        {
            echo "Erro: " . $sql . "<br>" . $this->conn->error;
        }

        // Fecha a conexão
        $this->conn->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (!empty($_POST["name"]) && !empty($_POST["age"]) && !empty($_POST["phone"]) && !empty($_POST["cpf"])) 
    {
        $servername = ""; // Declare seu servername
        $username = ""; // Declare o nome de usuario do seu servidor
        $password = ""; // Insira a senha do servidor
        $dbname = "phpbase"; // Insira o nome do banco de dados criado. Por padrão esta 'phpbase', pois foi o nome que deixei no script 'database.sql'.
        $nome = $_POST["name"];
        $idade = $_POST["age"];
        $phone = $_POST["phone"];
        $cpf = $_POST["cpf"];
        $user = new UserData($servername, $username, $password, $dbname); // Instanciando a classe UserData.
        $user->check_data($cpf, $phone); // Verifica se o cpf e o número de telefone já estão cadastrado no banco de dados.
        $user->save_data($nome, $idade, $phone, $cpf); // Método para salvar os dados.
    } 
    else 
    {
        echo "<p> Por favor, preencha todos os campos.";
    }
}

?>