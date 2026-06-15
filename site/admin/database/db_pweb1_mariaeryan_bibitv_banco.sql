CREATE TABLE IF NOT EXISTS `catalogo` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`url_poster` varchar(300),
	`url_video` varchar(300),
	`url_imagem_horizontal` varchar(300),
	`titulo` varchar(255),
	`sinopse` text,
	`faixa_etaria` varchar(10),
	`ano_lançamento` int,
	`genero` varchar(20) NOT NULL,
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `planos` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`nome_plano` varchar(255),
	`preco_mensal` float,
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
	`senha` varchar(255) NOT NULL,
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

INSERT INTO `catalogo` (`id`, `url_poster`, `url_video`, `url_imagem_horizontal`, `titulo`, `sinopse`, `faixa_etaria`, `ano_lançamento`, `genero`) VALUES (1, 'https://br.web.img2.acsta.net/medias/nmedia/18/87/35/24/19874611.jpg', 'https://youtu.be/svf3k6QFuvQ?si=N6bT03Ui60zEEIbm', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSfZFFNKTVo-iy33PQ1uawn5QERjXRiRGZw2IguGD8DN5p1Z7mlgVrP-6Xr6l0HQjMdEpwr86Bzb3nP8TH_B54I2AK0Bzhe5hLf2fkz-hs&s=10', 'Sobrenatural', 'Josh e Renai se mudam com a família para uma casa maior. Lá, o filho Dalton sofre um estranho acidente e entra em coma. Enquanto eles tentam salvar o menino, entidades malignas atormentam a família.', '14', 2010, 'Terror');
INSERT INTO `catalogo` (`id`, `url_poster`, `url_video`, `url_imagem_horizontal`, `titulo`, `sinopse`, `faixa_etaria`, `ano_lançamento`, `genero`) VALUES (2, 'https://m.media-amazon.com/images/M/MV5BZWM5ZjNkOWItNmU0Zi00YzdiLTg0MTAtMzkxMTZmZGI4NmQ2XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', 'https://youtu.be/AvQsJHa761g?si=mUjxXDTZf1YdXqI5', 'https://br.web.img3.acsta.net/r_654_368/newsv7/15/04/07/17/19/147445.jpg', 'Teletubbies', 'Quatro amigos, Tinky-Winky, Dipsy, Laa Laa e Po, embarcam em diversas aventuras e jogos na Teletubbilândia.', '12', 1997, 'Dança');
INSERT INTO `catalogo` (`id`, `url_poster`, `url_video`, `url_imagem_horizontal`, `titulo`, `sinopse`, `faixa_etaria`, `ano_lançamento`, `genero`) VALUES (3, 'https://m.media-amazon.com/images/I/71a2rFjeEmL._AC_UF894,1000_QL80_.jpg', 'https://youtu.be/FjDCzYrPTi0?si=FXfUFM8jLABdpSpA', 'https://f.i.uol.com.br/fotografia/2018/01/12/15157804265a58f94a203fa_1515780426_3x2_rt.jpg', 'The End Of The F***ing World', 'Um adolescente psicopata e uma rebelde louca por aventuras caem na estrada em uma viagem complicada.', '16', 2016, 'Drama');
INSERT INTO `catalogo` (`id`, `url_poster`, `url_video`, `url_imagem_horizontal`, `titulo`, `sinopse`, `faixa_etaria`, `ano_lançamento`, `genero`) VALUES (4, 'https://ingresso-a.akamaihd.net/prd/img/movie/maldicao-da-mumia/c4442b6a-12d5-45ba-9ed8-419db45634d8.webp', 'https://youtu.be/fUANevKVe78?si=zxxei2gzDff2O19Y', 'https://atlantidasc.com.br/wp-content/uploads/2026/02/A-MALDICAO-DA-MUMIA.jpg', 'Maldição da Múmia', 'A filha de um jornalista desaparece sem deixar rastros no deserto. Oito anos depois, a família fica em choque quando a filha é devolvida. Mas o que deveria ser um reencontro alegre se transforma em um verdadeiro pesadelo.', '18', 2018, 'Terror');
INSERT INTO `catalogo` (`id`, `url_poster`, `url_video`, `url_imagem_horizontal`, `titulo`, `sinopse`, `faixa_etaria`, `ano_lançamento`, `genero`) VALUES (5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTAcNuqhQHD-LYzXcRJdBbyn6159LGGbqBSAQ&s', 'https://youtu.be/Re5JWFTw9Xk?si=wsubdUwz1rkrUokp', 'https://recreio.com.br/wp-content/uploads/2026/05/como-magica.jpg', 'Como Mágica', 'Uma pequena criatura da floresta e um pássaro majestoso trocam de corpo e precisam se unir para sobreviver à aventura mais incrível de suas vidas.', 'L', 2026, 'Dança');
INSERT INTO `catalogo` (`id`, `url_poster`, `url_video`, `url_imagem_horizontal`, `titulo`, `sinopse`, `faixa_etaria`, `ano_lançamento`, `genero`) VALUES (6, 'https://upload.wikimedia.org/wikipedia/pt/b/bb/El_Chavo_Roberto_Bola%C3%B1os.png', 'https://youtu.be/T1hTiY0FWVc?si=VfmfyjEjKphVHZkx', 'https://imagenes.elpais.com/resizer/v2/WZF3MMB4ONHUTB5KBSMFZ7L2OI.JPG?auth=f7528b0d674a73328421e444a643e8f7a15b5329e4cfc3d364313fefbee3e08c&width=414', 'Chaves', 'O dia a dia de Chaves, um menino pobre que passa sua infância em uma pequena vila ao lado de seus amigos, Chiquinha e Quico. Ele cria complicações para os adultos Seu Madruga, Seu Barriga, Professor Girafales, Dona Florinda e a Dona Clotilde.\r\nPrimeiro', 'L', 2000, 'Comédia');
INSERT INTO `catalogo` (`id`, `url_poster`, `url_video`, `url_imagem_horizontal`, `titulo`, `sinopse`, `faixa_etaria`, `ano_lançamento`, `genero`) VALUES (7, 'https://static.wikia.nocookie.net/creepypastabrasil/images/6/6d/Mr-Bear-1999.jpg/revision/latest?cb=20230209034748&path-prefix=pt-br', 'https://youtu.be/v7ObP98knzY?si=QpbX1wTc5-cYf91n', 'https://curtatituloscdn-fhdpeyg2gjc2d5c6.z03.azurefd.net/imagens/fotos/filme/1000344-E.jpg', 'O Canal do Sr. Urso', 'Abra e veja...', 'L', 1990, 'Fantasia');
INSERT INTO `catalogo` (`id`, `url_poster`, `url_video`, `url_imagem_horizontal`, `titulo`, `sinopse`, `faixa_etaria`, `ano_lançamento`, `genero`) VALUES (8, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSX5p0B25eKQcpWWt3UaxsFXpFkPfHGR9_SNzqmdkkYjqgQDGWKheweFOLNFwtSSuJQZOtYZjd65M8_2SeF6dZsMlsyu0XXtBJ6I6jrIw&s=10', 'https://youtu.be/fyoQMDgVvZM?si=OYsiH965KaCe0589', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQwPkU_90N4un-gESC9i-heJnIMFkXCLWWhTA&s', 'O Segredo de Brokeback Mountain', 'Jack e Ennis se conheceram em Wyoming, no verão de 1963, quando foram trabalhar para um rancheiro que criava ovelhas. Naquele ambiente solitário nas montanhas, eles acabam tendo um rápido contato sexual. Quando o trabalho no rancho acaba, cada um segue seu caminho. Ambos casaram e vivem com suas respectivas esposas. Por muitos anos, não se veem até que um dia, eles começam a marcar encontros esporádicos e mantêm um caso amoroso durante uns vinte anos.', '18', 2005, 'Faroeste');
INSERT INTO `catalogo` (`id`, `url_poster`, `url_video`, `url_imagem_horizontal`, `titulo`, `sinopse`, `faixa_etaria`, `ano_lançamento`, `genero`) VALUES (9, 'https://upload.wikimedia.org/wikipedia/pt/f/f4/Menino_Maluquinho_-_O_Filme.jpg', 'https://youtu.be/uxn34-IbVtM?si=pVim1UnEuxthVJhe', 'https://m.media-amazon.com/images/M/MV5BMDg3OGZjOGUtMGM1Yy00Zjg5LTg3MDItZjFiMmVmODFkYjlkXkEyXkFqcGc@._V1_.jpg', 'Menino Maluquinho - O Filme', 'No final dos anos 1960, o Menino Maluquinho é um garoto normal, feliz e bem cuidado por sua família que, enquanto aproveita a infância brincando na rua com a turma, observa o mundo que o cerca e aprende a lidar com a vida.', 'L', 1995, 'Comédia');
INSERT INTO `catalogo` (`id`, `url_poster`, `url_video`, `url_imagem_horizontal`, `titulo`, `sinopse`, `faixa_etaria`, `ano_lançamento`, `genero`) VALUES (10, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRhscLYLel8MrWgwww78GVX50fGGFQqyCXImg&s', 'https://youtu.be/4SyXl2KFSDI?si=phtciEfIbVFsJEsF', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRv5ml60Pd18GKODkYurJ46ZK7NWeJQ2KiT3g&s', 'Copan', 'O edifício Copan, localizado na cidade de São Paulo, é um microcosmo do Brasil. Cinco mil moradores e mais de cem funcionários representam uma diversidade de personagens e pontos de vista que revelam contrastes e desigualdades estruturais do país.', '12', 2026, 'Documentário');
INSERT INTO `catalogo` (`id`, `url_poster`, `url_video`, `url_imagem_horizontal`, `titulo`, `sinopse`, `faixa_etaria`, `ano_lançamento`, `genero`) VALUES (11, 'https://m.media-amazon.com/images/I/61lC70mmjnL._AC_UF894,1000_QL80_.jpg', 'https://youtu.be/NAKlDJmwq-g?si=5aR6Jaj9I9jIfM0j', 'https://tm.ibxk.com.br/2024/09/18/18113313913110.jpg?ims=1600x900/filters:format(jpg)', 'Túmulo dos Vagalumes', 'Os irmãos Setsuko e Seita vivem no Japão em meio à Segunda Guerra Mundial. Após a morte da mãe em um bombardeio e a convocação do pai para a Guerra, eles vão morar com alguns parentes. Insatisfeitos, saem da cidade e acabam em um abrigo na floresta.', '14', 1988, 'Drama');
INSERT INTO `catalogo` (`id`, `url_poster`, `url_video`, `url_imagem_horizontal`, `titulo`, `sinopse`, `faixa_etaria`, `ano_lançamento`, `genero`) VALUES (12, 'https://static.wikia.nocookie.net/dublagempedia/images/1/1d/Scoobydoo-omistc3a9riocomec3a7a.jpg/revision/latest?cb=20180214172617&path-prefix=pt-br', 'https://youtu.be/mKkXpY-qyBo?si=j8GNIbrssZx5lDxE', 'https://m.media-amazon.com/images/S/pv-target-images/796ad32a860b32262da329b547a68e1035effb5d3cf9cf193fe897b63e3105d3.jpg', 'Scooby-Doo! O Mistério Começa', 'O jovem Salsicha e seu novo cão adotado, Scooby-Doo, juntam forças com Fred, Daphne e Velma para investigar assombrações em uma escola.', 'L', 2009, 'Mistério');
