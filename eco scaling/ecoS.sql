-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS ecos DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ecos;

-- Criar tabela 'aluno'
CREATE TABLE `aluno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `escola_id` int(11) NOT NULL,
  `comprou_jogos` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Criar tabela 'escola'
CREATE TABLE `escola` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_escola` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserir dados em 'escola'
INSERT INTO `escola` (`id`, `nome`, `email`, `id_escola`) VALUES
(1, 'Escola Walter Ramos de Araújo', 'WalterRamosgmail.com', 1),
(2, 'Escola Adelino Cunha Alcântara', 'AdelinoAlcantara.com', 2),
(3, 'Escola Waldemar Alcântara', 'WalderAlcantara@gmail.com', 3);

-- Criar tabela 'pagamento'
CREATE TABLE `pagamento` (
  `cnpj` int(50) NOT NULL AUTO_INCREMENT,
  `nomeinst` varchar(100) NOT NULL,
  `endereço` varchar(50) NOT NULL,
  `nomeresp` varchar(50) NOT NULL,
  `formpag` varchar(50) NOT NULL,
  PRIMARY KEY (`cnpj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Ajustar o AUTO_INCREMENT
ALTER TABLE `aluno` AUTO_INCREMENT = 4;
ALTER TABLE `pagamento` AUTO_INCREMENT = 624;
