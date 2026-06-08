CREATE TABLE IF NOT EXISTS `catalogo` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`url` varchar(255),
	`titulo` varchar(255),
	`sinopse` text,
	`faixa_etaria` int,
	`ano_lançamento` int,
	`elenco` int,
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
CREATE TABLE IF NOT EXISTS `atores` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`nome_artista` varchar(255) NOT NULL,
	`data_nascimento` date NOT NULL,
	`nacionalidade` varchar(100) NOT NULL,
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `usuario` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`nome` varchar(120) NOT NULL,
	`telefone` int NOT NULL,
	`email` varchar(120) NOT NULL,
	`login` varchar(25) NOT NULL,
	`senha` text NOT NULL,
	`tipo` int NOT NULL,
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `lista_favoritos` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`id_usuario` int NOT NULL,
	`id_obra` int NOT NULL,
	`status` varchar(20) NOT NULL DEFAULT 'Pendente',
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `avaliacao` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`id_usuario` int NOT NULL,
	`id_obra` int NOT NULL,
	`nota` int NOT NULL,
	`comentario` text NOT NULL,
	`spoiler` boolean NOT NULL,
	PRIMARY KEY (`id`)
);
ALTER TABLE `catalogo` ADD CONSTRAINT `catalogo_fk6` FOREIGN KEY (`elenco`) REFERENCES `atores`(`id`);
ALTER TABLE `lista_favoritos` ADD CONSTRAINT `lista_favoritos_fk1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`id`);
ALTER TABLE `lista_favoritos` ADD CONSTRAINT `lista_favoritos_fk2` FOREIGN KEY (`id_obra`) REFERENCES `catalogo`(`id`);
ALTER TABLE `avaliacao` ADD CONSTRAINT `avaliacao_fk1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`id`);
ALTER TABLE `avaliacao` ADD CONSTRAINT `avaliacao_fk2` FOREIGN KEY (`id_obra`) REFERENCES `catalogo`(`id`);