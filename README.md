# FormulariosPHP_MySQL_JavaScript
 Criando formulários com PHP / JavaScript que armazena dados, faz consultas e atualiza informações em um Banco de Dados MySQL.

# Imagens
<p float="left">
<p> FORMULÁRIOS </p>
<img src="/images/formularios.png?raw=true">
<p> SCRIPT SQL </p>
<img src="/images/sql.png?raw=true">
</p>

## Usando a classe PDO

A classe PDO é uma interface do PHP para interagir com bancos de dados relacionais, oferecendo suporte a vários tipos de bancos de dados, como MySQL, PostgreSQL e Oracle, entre outros. Precisa alterar apenas a string de conexão '[$dsn](/src/PDO_METHOD/Config.php)' para seu banco de dados. No entanto, como a classe PDO é projetada para ser genérica e trabalhar com vários bancos de dados diferentes, pode haver uma pequena perda de desempenho.

[PDO_METHOD](/src/PDO_METHOD/)

## Usando a classe mysqli

A classe mysqli é uma interface do PHP para interagir com o MySQL. Ela é específica para o MySQL e não suporta outros bancos de dados. É mais eficiente do que a classe PDO quando se trata de interagir com o MySQL, pois é desenvolvida especificamente para esse banco de dados.

[mysqli_METHOD](/src/mysqli_METHOD/)