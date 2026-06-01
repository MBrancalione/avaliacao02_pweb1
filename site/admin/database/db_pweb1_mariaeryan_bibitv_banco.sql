CREATE TABLE IF NOT EXISTS `catalogo` (
	`id_obra` int NOT NULL,
	`url` varchar(255),
	`titulo` varchar(255),
	`sinopse` text,
	`faixa_etaria` int,
	`ano_lançamento` int,
	`elenco` int,
	`genero` varchar(20) NOT NULL,
	PRIMARY KEY (`id_obra`)
);
CREATE TABLE IF NOT EXISTS `planos` (
	`id_plano` int NOT NULL,
	`nome_plano` varchar(255),
	`preco_mensal` int,
	`limite_telas` int,
	`resolucao_max` varchar(255),
	PRIMARY KEY (`id_plano`)
);
CREATE TABLE IF NOT EXISTS `atores` (
	`id_artista` int NOT NULL,
	`nome_artista` varchar(255) NOT NULL,
	`data_nascimento` date NOT NULL,
	`nacionalidade` int NOT NULL,
	PRIMARY KEY (`id_artista`)
);
CREATE TABLE IF NOT EXISTS `usuario` (
	`id_usuario` int AUTO_INCREMENT NOT NULL UNIQUE,
	`nome` varchar(120) NOT NULL,
	`telefone` int NOT NULL,
	`email` varchar(120) NOT NULL,
	`login` varchar(25) NOT NULL,
	`senha` varchar(12) NOT NULL,
	`tipo` int NOT NULL,
	PRIMARY KEY (`id_usuario`)
);
CREATE TABLE IF NOT EXISTS `lista_favoritos` (
	`id_favorito` int AUTO_INCREMENT NOT NULL UNIQUE,
	`id_usuario` int NOT NULL,
	`id_video` int NOT NULL,
	`status` varchar(20) NOT NULL DEFAULT 'Pendente',
	PRIMARY KEY (`id_favorito`)
);
CREATE TABLE IF NOT EXISTS `avaliacao` (
	`id_avaliacao` int AUTO_INCREMENT NOT NULL UNIQUE,
	`id_usuario` int NOT NULL,
	`id_obra` int NOT NULL,
	`nota` int NOT NULL,
	`comentario` text NOT NULL,
	`spoiler` boolean NOT NULL,
	PRIMARY KEY (`id_avaliacao`)
);
ALTER TABLE `catalogo` ADD CONSTRAINT `catalogo_fk6` FOREIGN KEY (`elenco`) REFERENCES `atores`(`id_artista`);
ALTER TABLE `lista_favoritos` ADD CONSTRAINT `lista_favoritos_fk1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`id_usuario`);
ALTER TABLE `lista_favoritos` ADD CONSTRAINT `lista_favoritos_fk2` FOREIGN KEY (`id_video`) REFERENCES `catalogo`(`id_obra`);
ALTER TABLE `avaliacao` ADD CONSTRAINT `avaliacao_fk1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`id_usuario`);
ALTER TABLE `avaliacao` ADD CONSTRAINT `avaliacao_fk2` FOREIGN KEY (`id_obra`) REFERENCES `catalogo`(`id_obra`);