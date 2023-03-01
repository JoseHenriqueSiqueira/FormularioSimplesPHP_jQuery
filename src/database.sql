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
  cpf VARCHAR(14) NOT NULL,
  senha VARCHAR(60) NOT NULL
);

/* Consulta todos dados da tabela 'usuarios'.*/
SELECT * FROM usuarios;

/* Limpa os dados da tabela 'usuarios'.*/
SET SQL_SAFE_UPDATES=0;
DELETE FROM usuarios;
SET SQL_SAFE_UPDATES=1;

/* Deleta a tabela 'usuarios'.*/
DROP TABLE usuarios;