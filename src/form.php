<?php

/**
 * Classe responsável pela conexão com o banco de dados, salvar dados, fazer consultas SQL e obter dados do banco SQL.
 */
class UserData
{
    private $conn;

    /**
     * Método construtor da classe, responsável por criar a conexão e passar como atributo para os demais métodos.
     */
    public function __construct(string $servername, string $username, string $password, string $dbname)
    {
        // Cria a conexão.
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica se houve erro na conexão.
        if ($this->conn->connect_error) 
        {
            die("CONEXÃO FALHOU: " . $this->conn->connect_error);
        }
    }

    /**
    * Método responsável por fazer as consultas SQL de forma segura.
    */
    private function execute_query(string $query, string|array $params, string $paramtypes): mysqli_stmt
    {
        // Verifica se o tamanho do $paramtypes é igual a 1.
        if (strlen($paramtypes) === 1) 
        {
            // Caso maior, transforma em uma única array os parâmetros $paramtypes e $params.
            $allparams = array($paramtypes, $params);
        } 
        else 
        {
            // Caso maior, converte o parâmetro $paramtypes em uma ARRAY e fundi com a ARRAY $params.
            $allparams = array_merge(array($paramtypes), $params);
        }
        $stmt = $this->conn->prepare($query); // Prepara a consulta SQL.
        $stmt->bind_param(...$allparams); // Liga os parâmetros a consulta SQL.
        $stmt->execute(); // Executa a consulta SQL.
        return $stmt; // Retorna um objeto mysqli_stmt.
    }

    /**
    * Método responsável por verificar valores duplicados para CPF e TELEFONE.
    */
    public function check_duplicate(string $cpf, string $phone): bool
    {
        $query = "SELECT COUNT(*) AS total FROM usuarios WHERE cpf = ? or telefone = ?"; // define a consulta sql como uma declaração preparada.
        $params = array($cpf, $phone); // Define os valores dos parâmetros da consulta.  
        $paramtypes = 'ss'; // Define os tipos de parâmetros da consulta (string, string). 
        $stmt = $this->execute_query($query, $params, $paramtypes); // Executa a consulta SQL.
        $stmt->bind_result($total); // Vincula a variável $total ao resultado da contagem de linhas retornado pela consulta SQL.
        $stmt->fetch(); // Obtém o valor da consulta.
        // Verifica se o resultado da consulta SQL armazenado na variavel $total é maior que 0.
        if ($total > 0)
        {
            // Caso for maior, significa que o TELEFONE ou CPF que o usuário tentou cadastrar já esta no banco de dados.
            $this->conn->close(); // Fecha a conexão.
            return TRUE; // Retorna TRUE.
        }
        else
        {
            // Caso não, o código continua.
            return FALSE; // Retorna TRUE.
        }
    }

    /**
    * Método responsável por inserir valores dos usuários no banco de dados.
    */
    public function save_data(string $nome, int $idade, string $phone, string $cpf, string $password): bool
    {
        $hash = password_hash($password, PASSWORD_BCRYPT); // Converte o password para hash.        
        $query = "INSERT INTO usuarios (nome, idade, telefone, cpf, senha) VALUES (?, ?, ?, ?, ?)"; // define a consulta sql como uma declaração preparada.
        $params = array($nome, $idade, $phone, $cpf, $hash); // Define os valores dos parâmetros da consulta.      
        $paramtypes = 'sisss'; // Define os tipos de parâmetros da consulta (string, int, string, string, string).    
        $stmt = $this->execute_query($query, $params, $paramtypes); // Executa a consulta SQL.        
        $result = $stmt->affected_rows; // Obtém o número de linhas afetadas.
        $stmt->close(); // Encerra a declaração preparada.
        $this->conn->close(); // Fecha a conexão com o banco de dados.
        // Verifica o número de linhas afetadas.
        if ($result > 0)
        {
            // Se o número de linhas afetadas for maior que 0, significa que os dados foram inseridos com sucesso.
            return TRUE; // Retorna TRUE.
        }
        else
        {
            // Caso contrário, ocorreu uma falha ao inserir os dados.
            return FALSE; // Retorna FALSE.
        }   

    }

    /**
    * Método responsável por obter valores do banco de dados.
    */
    public function get_data(string $cpf, string $password): bool|array
    {    
        $query =  "SELECT nome, idade, telefone, cpf, senha FROM usuarios WHERE cpf = ?"; // Define a consulta sql como uma declaração preparada.
        $params = $cpf; // Define o valore do parâmetro da consulta.
        $paramstypes = 's'; // Define o tipo de parâmetro da consulta (string).
        $stmt = $this->execute_query($query, $params, $paramstypes); // Executa a consulta SQL através do método private 'execute_query'.
        $result = $stmt->get_result(); // Obtém o resultado da consulta preparada e o armazena em um objeto 'mysqli_result'.
        $dados = $result->fetch_assoc(); // Trata os dados obtidos da consulta preparada e os armazena em um array associativo '$dados'.
        $stmt->close();  // Encerra a declaração preparada.
        $this->conn->close(); // Encerra a conexão.
        // Verifica se a variável '$dados' está vazia.
        if (empty($dados))
        {   
            // Se vazia, indica que não há usuários no banco de dados com o cpf informado.
            return FALSE;
        }
        else
        {
            // Se a variável não estiver vazia, verifica se a senha informada corresponde à senha armazenada no banco de dados.
            if (password_verify($password, $dados['senha'])) 
            {
                // Para o usuário encontrado retorna as informações requisitadas. 
                return $dados;
            }
            else 
            {
                // Caso contrário, retorna TRUE.
                return TRUE;
            }
        }
    }

    /**
    * Método responsável por validar CPF e SENHA.
    */
    public function check_valid_values(string $cpf, string $password): void
    {
        // Verifica o tamanho do CPF.
        if (strlen($cpf) < 14)
        {
            // Caso menor, fecha a conexão e encerra o script.
            $this->conn->close();
            die("CPF INVÁLIDO");
        }
        // Verifica se a senha é menor que 8 dígitos.
        else if(strlen($password) < 8)
        {
            // Caso menor, fecha a conexão e encerra o script.
            $this->conn->close();
            die("A SENHA DEVE SER NO MINÍMO 8 DÍGITOS");
        }
    }
}


/**
 * Classe responsável por verificar as requisições dos formulários na aplicação WEB (SITE).
 */
class RequestsType
{

    private $userclass;

    /**
     * Método construtor da classe, responsável por passar como atributo a classe "UserData" para os demais métodos.
     */
    public function __construct(UserData $user)
    {
        $this->userclass = $user; // Atribuindo o objeto da classe UserData passado como parâmetro para o atributo $userclass.
    }

    /**
     * Método responsável por verificar qual formulário fez uma requisição
     */
    public function request_method(array $request_data): void
    {
        $method = $request_data['form']; // Obtém o nome do formulário que fez a requisição.
        // Verifica qual o nome do formulário que fez a requisição.
        if ($method == 'postform')
        {
            $this->post_form($request_data); // Chamando o método post_form e passando como parâmetro a array $request_data.
        }
        else if ($method == 'updateform')
        {
            $this->update_form($request_data); // Chamando o método update_form e passando como parâmetro a array $request_data.
        }
        else if ($method == 'getform')
        {
            $this->get_form($request_data); // Chamando o método get_form e passando como parâmetro a array $request_data.
        }
    }

    /**
     * Método responsável por tratar os valores do formulário 'post_form'.
     */
    private function post_form(array $request_data): void
    {
        // Verifica se não há nenhum valor vazio no array.
        if (!in_array("",$request_data)) 
        {
            // Obtendo os valores preenchidos no formulário.
            $cpf = $request_data["cpf"];
            $password = $request_data['password'];
            $nome = $request_data["name"];
            $idade = $request_data["age"];
            $phone = $request_data["phone"];

            $this->userclass->check_valid_values($cpf, $password); // Verifica se a senha e o CPF sao válidos.
            $duplicate = $this->userclass->check_duplicate($cpf, $phone); // Chama o método responsável por verificar se os valores ja estão no banco de dados.
            // Verifica a resposta do método 'check_duplicate'.
            if ($duplicate == TRUE)
            {
                // Se duplicados, exibe uma mensagem ao usuário.
                echo "CPF OU TELEFONE JÁ CADASTRADOS";
            }
            else
            {
                // Se não, continua o script.
                $resposta = $this->userclass->save_data($nome, $idade, $phone, $cpf, $password); // Chamando o método responsavel por inserir os valores no banco de dados.
                // Verifica se os dados foram salvos.
                if ($resposta)
                {
                    // Se sim, exibe ao usuário uma mensagem de sucesso.
                    echo "DADOS SALVOS COM SUCESSO!";
                }
                else
                {
                    // Se não, exibe ao usuário uma mensagem de falha.
                    echo "FALHA AO SALVAR DADOS";
                }
            }

        }
        else 
        {
            // Se existir valores vazios na array $request_data, exibe uma mensagem ao usuário.
            echo "POR FAVOR, PREENCHA TODOS OS CAMPOS.";
        }
    }

    /**
     * Método responsavel por tratar os valores do formulário 'update_form'.
     */
    private function update_form(array $request_data): void
    {
        
    }

    /**
    * Método responsável por tratar os valores do formulário 'get_form'.
    */
    private function get_form(array $request_data): void
    {
        // Obtendo os dados do array $request_data (Não é necessário a validação de todos os dados como feito no método "post_form", pois os dois campos ja serão tratados no método "check_valid_values").
        $cpf = $request_data["cpf"];
        $password = $request_data["password"];

        $this->userclass->check_valid_values($cpf, $password); // Verifica se a senha e o CPF sao válidos.
        $resposta = $this->userclass->get_data($cpf, $password); // Chama o método para uma consulta no banco de dados.
        // Verifica a resposta da requisição feita no banco de dados através do método 'get_data'.
        if ($resposta === FALSE)
        {
            // Caso FALSE, nenhum usuário com o CPF informado no banco de dados.
            echo "NENHUM USUÁRIO ENCONTRADO COM O CPF INFORMADO.";
        }
        else if ($resposta === TRUE)
        {
            // Caso TRUE, foi encontrado um usuário com o CPF informado, porém a senha esta incorreta.
            echo "SENHA INCORRETA.";
        }
        else
        {
            // Caso uma resposta válida, exibe os dados para o usuário.
            echo "Nome: " . $resposta["nome"] . "<br>";
            echo "Idade: " . $resposta["idade"] . "<br>";
            echo "CPF: " . $resposta["cpf"] . "<br>";
            echo "Telefone: " . $resposta["telefone"] . "<br>";
        }
    }
}

// Criando a conexão.
$servername = ""; // Declare seu servername.
$username = ""; // Declare o nome de usuario do seu servidor.
$password = ""; // Insira a senha do servidor.
$dbname = ""; // Insira o nome do banco de dados criado. Por padrão esta 'phpbase', pois foi o nome que deixei no script 'database.sql'.
$user = new UserData($servername, $username, $password, $dbname); // Instanciando a classe UserData e criando a conexão.
$request = new RequestsType($user);


// Verifica o tipo de requisição feita pelo o usuário
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Chama o método 'request_method' para verificar qual formulário fez a requisição POST
    $request->request_method($_POST);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
    //Chama o método 'request_method' para verificar qual formulário fez a requisição GET
    $request->request_method($_GET);
}

?>