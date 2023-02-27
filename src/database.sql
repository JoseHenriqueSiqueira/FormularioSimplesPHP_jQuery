/* Criando o banco de dados*/
CREATE DATABASE phpbase;

/* Usando o banco de dados criado.*/
USE phpbase;

/* Criando a tabela 'usuarios'.*/
CREATE TABLE usuarios (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(50) NOT NULL,
  idade INT(2) NOT NULL,
  telefone VARCHAR(20) NOT NULL,
  cpf VARCHAR(14) NOT NULL
);

/* Consulta os dados da tabela 'usuarios'.*/
SELECT * FROM usuarios;

/* Deleta a tabela 'usuarios'.*/
DROP TABLE usuarios;