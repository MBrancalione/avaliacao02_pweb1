CREATE TABLE IF NOT EXISTS `catalogo` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`url_poster` varchar(300),
	`url_video` varchar(300),
	`titulo` varchar(255),
	`sinopse` text,
	`faixa_etaria` int,
	`ano_lançamento` int,
	`elenco` varchar(100),
	`genero` varchar(20) NOT NULL,
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `planos` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`nome_plano` varchar(255),
	`preco_mensal` int,
	`limite_telas` int,
	`resolucao_max` varchar(255),
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `usuario` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`nome` varchar(120) NOT NULL,
	`telefone` varchar(20) NOT NULL,
	`email` varchar(120) NOT NULL,
	`login` varchar(25) NOT NULL,
	`senha` text NOT NULL,
	`tipo` int NOT NULL,
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `avaliacao` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`id_usuario` int NOT NULL,
	`id_catalogo` int NOT NULL,
	`nota` text NOT NULL,
	`comentario` text NOT NULL,
	`spoiler` boolean NOT NULL,
	PRIMARY KEY (`id`)
);
ALTER TABLE `avaliacao` ADD CONSTRAINT `avaliacao_fk1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`id`);
ALTER TABLE `avaliacao` ADD CONSTRAINT `avaliacao_fk2` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo`(`id`);

INSERT INTO usuario (nome, telefone, email, login, senha, tipo) 
VALUES (
    'Administrador', 
    '49999999999', 
    'admin@bibitv.com', 
    'admin', 
    -- senha '123456'
    '$2y$10$8KzVv1p4Rby6N6zEGE3vAegG098rO0T4P.UeOQx7gE2kDeC1Vlyre', 
    2
);