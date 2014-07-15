-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2014 at 01:10 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cdcol`
--

-- --------------------------------------------------------

--
-- Table structure for table `cds`
--

CREATE TABLE IF NOT EXISTS `cds` (
  `titel` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `interpret` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `jahr` int(11) DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cds`
--

INSERT INTO `cds` (`titel`, `interpret`, `jahr`, `id`) VALUES
('Beauty', 'Ryuichi Sakamoto', 1990, 1),
('Goodbye Country (Hello Nightclub)', 'Groove Armada', 2001, 4),
('Glee', 'Bran Van 3000', 1997, 5);
--
-- Database: `mathpocket`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(3, 'Álgebra'),
(4, 'Estatística'),
(2, 'Geometria'),
(1, 'Números');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `category` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `title`, `description`, `category`) VALUES
(1, 'Amplitude', 'Consiste na diferença entre o maior e menor valores de um <a href="/?title=conjuntos_de_numeros">conjunto de números</a>.', 'Estatística'),
(2, 'Amplitude interquartil', 'A Amplitude interquartil é a diferença entre o 3º e o 1º quartil de um conjunto de números.', 'Estatística'),
(3, 'Ângulos', NULL, 'Geometria'),
(4, 'Ângulos Alternos Internos', NULL, 'Geometria'),
(5, 'Ângulos Complementares', NULL, 'Geometria'),
(6, 'Ângulos Externos de um triângulo', NULL, 'Geometria'),
(7, 'Ângulos internos de um quadrilátero', NULL, 'Geometria'),
(8, 'Ângulos internos de um triângulo', NULL, 'Geometria'),
(9, 'Ângulos Suplementares', NULL, 'Geometria'),
(10, 'Ângulos Verticalmente Opostos', NULL, 'Geometria'),
(11, 'Área de um círculo', NULL, 'Geometria'),
(12, 'Área de um quadrado', NULL, 'Geometria'),
(13, 'Área de um retângulo', NULL, 'Geometria'),
(14, 'Área de um triângulo', NULL, 'Geometria'),
(15, 'Área do paralelogramo', NULL, 'Geometria'),
(16, 'Áreas', NULL, 'Geometria'),
(17, 'Classificação de Ângulos', NULL, 'Geometria'),
(18, 'Classificação de equações', NULL, 'Álgebra'),
(19, 'Classificação de quadriláteros', NULL, 'Geometria'),
(20, 'Classificação de Triângulos', NULL, 'Geometria'),
(21, 'Conjuntos de Números', '<p><img id="numbers_conj" src="/imgs/numeros/conjunto_numeros.png" /> Os n&uacute;meros est&atilde;o divididos em v&aacute;rios conjuntos. Estes s&atilde;o:<br />\r\n<br />\r\n<img class="small" src="/imgs/numeros/n.png" /> - <a href="/?title=numeros_naturais">N&uacute;meros Naturais</a><br />\r\n<img class="small" src="/imgs/numeros/z.png" /> - <a href="/?title=numeros_inteiros">N&uacute;meros Inteiros</a><br />\r\n<img class="small" src="/imgs/numeros/q.png" /> - <a href="/?title=numeros_racionais">N&uacute;meros Racionais</a><br />\r\n<a href="/?title=numeros_irracionais">N&uacute;meros Irracionais</a><br />\r\n<img class="small" src="/imgs/numeros/a.png" /> - <a href="/?title=numeros_algebricos">N&uacute;meros Alg&eacute;bricos</a><br />\r\n<a href="/?title=numeros_transcendentes">N&uacute;meros Transcendentes</a><br />\r\n<img class="small" src="/imgs/numeros/r.png" /> - <a href="/?title=numeros_reais">N&uacute;meros Reais</a><br />\r\n<img class="small" src="/imgs/numeros/i.png" /> - <a href="/?title=numeros_imaginarios">N&uacute;meros Imagin&aacute;rios</a><br />\r\n<img class="small" src="/imgs/numeros/c.png" /> - <a href="/?title=numeros_complexos">N&uacute;meros Complexos</a><br />\r\n<br />\r\nA representa&ccedil;&atilde;o destes conjuntos pode ser personalizada. Ao escrevermos <img class="small" src="/imgs/numeros/z+.png" />, estou-me a referir a todos os n&uacute;meros inteiros positivos. Quando escrevemos <img class="small" src="/imgs/numeros/n0.png" /> referimo-nos aos n&uacute;meros naturais incluindo o 0.<br />\r\n<br />\r\n<strong>Clica nos itens para saberes mais!</strong></p>\r\n', 'Números'),
(22, 'Contradomínio', 'O contradomínio de uma <a href="/?title=funcoes">função</a> são todos os elementos pertencentes ao conjunto de chegada, ou seja, às <strong>imagens</strong>, representados por <img src="/imgs/y.png">.', 'Álgebra'),
(23, 'Critérios de congruência de triângulos', NULL, 'Geometria'),
(24, 'Cubos Perfeitos', 'Cubos perfeitos são números cuja <a href="/?title=raiz_cubica">raiz cúbica</a> é um número inteiro. Exemplo: <img src="/imgs/numeros/3r9.png">', 'Números'),
(25, 'Domínio', 'O domínio de uma <a href="/?title=funcoes">função</a> são todos os elementos pertencentes ao conjunto de partida,  ou seja, os <strong>objetos</strong>, representados por <img src="/imgs/x.png">.', 'Álgebra'),
(26, 'Equação', '', 'Álgebra'),
(27, 'Equações equivalentes', NULL, 'Álgebra'),
(28, 'Escalas', 'As <strong>escalas</strong> traduzem a <a href="/?title=razao">razão</a> entre o tamanho real de uma figura e o tamanho em que esta está representada. ', 'Álgebra'),
(29, 'Expressão Algébrica', 'As <strong>expressões algébricas</strong> são expressões que relacionam objetos e imagens com  variáveis. São comummente utilizadas em sequências.', 'Álgebra'),
(30, 'Extremos', 'Consiste no maior e menor valor de um conjunto de números.', 'Estatística'),
(31, 'Frequência Absoluta', 'Consiste no número de vezes que um determinado dado é repetido', 'Estatística'),
(32, 'Frequência Relativa', 'É a percentagem do número de vezes que um determinado dado é repetido. É dado pelo quociente entre a <a  href=`/?title=frequencia_absoluta`>frequência absoluta</a> e o total de dados.', 'Estatística'),
(33, 'Função Linear', NULL, 'Álgebra'),
(34, 'Funções', 'Funções são correspondências entre dois conjuntos, X e Z, em que cada elemento de cada conjunto está associado a <strong>um</strong> elemento do outro conjunto. A função f dos conjuntos X e Z representa-se da seguinte forma: <br><br><img src="/imgs/algebra/fab.png">', 'Álgebra'),
(35, 'Gráfico de caule-e-folhas', '', 'Estatística'),
(36, 'Histograma', NULL, 'Estatística'),
(37, 'Losango', NULL, 'Geometria'),
(38, 'Média', 'É um valor obtido somando todos os dados e dividindo o resultado pelo número de dados.', 'Estatística'),
(39, 'Mediana', NULL, 'Estatística'),
(40, 'Medidas de Dispersão', NULL, 'Estatística'),
(41, 'Medidas de Localização', NULL, 'Estatística'),
(42, 'Medidas de Localização Central', NULL, 'Estatística'),
(43, 'Moda', 'É o dado que surge com mais vezes.', 'Estatística'),
(44, 'Modelo de Pólya', NULL, 'Álgebra'),
(45, 'Módulo ou Valor Absoluto', 'Ou módulo ou valor absoluto é a distância do ponto que o representa à origem. Representa-se por |x| que quer dizer "módulo de x".<br><br><img src="imgs/numeros/moduloe.png">', 'Números'),
(46, 'Números Algébricos', '<img src="/imgs/numeros/a.png" class="left"> Todos os números que são solução de <a href="/?title=equacao_polinomial">equações polinomiais</a>. <br><br>Inclui todos os números racionais e alguns irracionais.', 'Números'),
(47, 'Números Complexos', '<img src="/imgs/numeros/c.png" class="left"> Os Números Complexos são todos os números reais e imaginários. <br><br> Podem ser fruto de operações entre reais e imaginários, por exemplo.', 'Números'),
(48, 'Números Imaginários', '<img src="/imgs/numeros/i.png" class="left"> Todos os números que ao quadrado resultam num número negativo. <br><br> Números imaginários são imaginados: se colocarmos na calculadora a raiz quadrada de -9 esta ir-nos-à apresentar um erro porém, podemos imaginar que o resultado seria -3.', 'Números'),
(49, 'Números Inteiros', 'Todos os números inteiros (não decimais) positivos, negativos e 0.<br><br>Conjunto = {...-3, -2, -1, 0, 1, 2, 3...}', 'Números'),
(50, 'Números Irracionais', 'Todos os números que não são racionais, como o <img src=`/imgs/numeros/pi.png` class=`small`>  , por exemplo.', 'Números'),
(51, 'Números Naturais', '<img src="/imgs/numeros/n.png" class="left">  Todos os números inteiros (não decimais) a partir de 1 (inclusive).<br><br>Conjunto = {1, 2, 3...}', 'Números'),
(52, 'Números Racionais', '<img src="/imgs/numeros/q.png" class="left"> Todos os números que podem ser criados através da divisão de dois números inteiros (excepto 0). São escritos sobre a forma de <a href="/?title=fracoes">frações</a>.<br><br> <strong>Q</strong> vem de "quociente".  Conjunto = {...3/2, 1/2...}', 'Números'),
(53, 'Números Reais', '<img src="/imgs/numeros/r.png" class="left"> Os Números Reais são todos os números racionais e irracionais podendo ser positivos, negativos ou zero. <br><br> Inclui todos os números algébricos e transcendentes.', 'Números'),
(54, 'Números Transcendentes', 'Todos os números que não são algébricos, como o <img src="/imgs/numeros/pi.png" class="small">  , por exemplo.', 'Números'),
(55, 'Papagaio', NULL, 'Geometria'),
(56, 'Paralelogramo', NULL, 'Geometria'),
(57, 'Percentagem', 'A comparação entre um número e 100 chama-se <strong>percentagem</strong>. Dizendo que 95% do pão é massa, estou referindo que em cada 100g de pão existe 95g de massa, por exemplo.', 'Álgebra'),
(58, 'Potências', 'Uma <strong>potência</strong> é constituída por em expoente e uma base. <img src="/imgs/numeros/5^3.png"> tem como base 5 e expoente 3. Essa potência significa <i> 5 x 5 x 5</i> logo é igual a 15. Sempre que a base for positiva, o resultado será sempre positivo.', 'Números'),
(59, 'Potências com Expoente Ímpar e Base Negativa', 'Todas as potências com <strong>expoente ímpar e base negativa</strong> têm resultado negativo.', 'Números'),
(60, 'Potências com Expoente Par e Base Negativa', 'Todas as potências com <strong>expoente par e base negativa</strong> têm resultado positivo.', 'Números'),
(61, 'Potências de potência', 'Uma potência de potência é quando temos uma potência elevada a um número. Para a resolvermos multiplicamos os expoentes. Exemplo: <img src="/imgs/numeros/potdepot.png">', 'Números'),
(62, 'Produto de dois números com o mesmo sinal', 'O <strong>produto de dois números com o mesmo sinal</strong> é um número positivo igual ao produto dos <a href=`/?title=modulo-ou-valor-absoluto`>módulos</a> dos fatores.', 'Números'),
(63, 'Produto de dois números de sinais contrários', 'O <strong>produto de dois números com sinais contrários</strong> é um número negativo igual ao produto dos <a href="/?title=modulo-ou-valor-absoluto">módulos</a> dos fatores.', 'Números'),
(64, 'Produto de potências com a mesma base', 'Para efetuar o produto de potências com a mesma base, adicionamos os expoentes, mantendo a base. Exemplo: <img src="/imgs/numeros/pdpcamb.png">', 'Números'),
(65, 'Produto de potências com o mesmo expoente', 'Para efetuar o produto de potências com o mesmo expoente, multiplicamos as bases, mantendo o expoente. Exemplo: <img src="/imgs/numeros/pdpcome.png">', 'Números'),
(66, 'Proporcionalidade Direta', 'Se a <a href="/?title=razao">razão</a> entre duas grandezas for sempre constante, pode-se dizer que as grandezas são <strong>diretamente proporcionais</strong>. A essa constante chama-se <strong>constante de proporcionalidade direta</strong>.', 'Álgebra'),
(67, 'Propriedade Associativa (da Multiplicação)', '<img src="/imgs/numeros/propsmulti/propassociativa.png"><br><br>A <strong>Propriedade associativa da multiplicação</strong> consiste na associação de elementos. <br>Exemplo: <i>3 x (4 x 5) = (3 x 4) x 5</i>\n', 'Números'),
(68, 'Propriedade Comutativa (da Multiplicação)', '<img src="/imgs/numeros/propsmulti/propcomutativa.png"><br><br>A <strong>Propriedade comutativa da multiplicação</strong> consiste na comutação de elementos. <br>Exemplo: <i>3 x 4 = 4 x 3</i>\n', 'Números'),
(69, 'Propriedade Distributiva da Multiplicação em Relação à Adição', '<img src="/imgs/numeros/propsmulti/propdistributivamultad.png"><br><br>Exemplo: <i>4 x (5 + 3) = 4 x 5 + 4 x 3</i>\n', 'Números'),
(70, 'Propriedade do Elemento Absorvente (da Multiplicação)', '<img src="/imgs/numeros/propsmulti/propelementoabs.png"><br><br>A <strong>Propriedade do elemento absorvente da multiplicação</strong> diz que o 0 é o elemento absorvente da mesma ou seja, tudo o que é multiplicado por este vai resultar 0. <br>Exemplo: <i>4 x 0 = 0</i>\n', 'Números'),
(71, 'Propriedade do Elemento Neutro (da Multiplicação)', '<img src="/imgs/numeros/propsmulti/propelementoneu.png"><br><br>A <strong>Propriedade do elemento neutro da multiplicação</strong> diz que o 1 é o elemento neutro da mesma ou seja, tudo o que é multiplicado por este vai dar o valor original. <br>Exemplo: <i>4 x 1 = 4</i>\n', 'Números'),
(72, 'Propriedades da Multiplicação', 'A multiplicação conta com diversas propriedades que auxiliam a multiplicação.<br>\n<table>\n<tr>\n<td><strong>Nome</strong></td>\n<td><strong>Linguagem Matemática</strong></td>\n</tr>\n<tr>\n<td><a href="/?title=propriedade-comutativa-da-multiplicacao">Propriedade comutativa</a></td>\n<td><img src="/imgs/numeros/propsmulti/propcomutativa.png"></td>\n</tr>\n<tr>\n<td><a href="/?title=propriedade-associativa-da-multiplicacao">Propriedade associativa</a></td>\n<td><img src="/imgs/numeros/propsmulti/propassociativa.png"></td>\n</tr>\n<tr>\n<td><a href="/?title=propriedade-do-elemento-neutro-da-multiplicacao">Propriedade do Elemento Neutro</a></td>\n<td><img src="/imgs/numeros/propsmulti/propelementoneu.png"></td>\n</tr>\n<tr>\n<td><a href="/?title=propriedade-do-elemento-absorvente-da-multiplicacao">Propriedade do Elemento Absorvente</a></td>\n<td><img src="/imgs/numeros/propsmulti/propelementoabs.png"></td>\n</tr>\n<tr>\n<td><a href="/?title=propriedade-distributiva-da-multiplicacao-em-relacao-a-adicao">Propriedade Distributiva da Multiplicação em Relação à Adição</a></td>\n<td><img src="/imgs/numeros/propsmulti/propdistributivamultad.png"></td>\n</tr>\n</table><br>\nClica nos itens para saberes mais acerca de cada propriedade!', 'Números'),
(73, 'Propriedades dos paralelogramos', NULL, 'Geometria'),
(74, 'Quadrado', NULL, 'Geometria'),
(75, 'Quadrados Perfeitos', 'Quadrados perfeitos são números cuja <a href="/?title=raiz_quadrada">raiz quadrada</a> é um número inteiro. Exemplo: <img src="/imgs/numeros/r25.png">', 'Números'),
(76, 'Quartis', NULL, 'Estatística'),
(77, 'Quociente de dois números com  o mesmo sinal', 'O <strong>quociente de dois números com  o mesmo sinal</strong> é um número positivo.', 'Números'),
(78, 'Quociente de dois números com sinais diferentes', 'O <strong>quociente de dois números com diferentes sinais</strong> é um número negativo.', 'Números'),
(79, 'Quociente de potências com a mesma base', 'Para efetuar a divisão de potências com a mesma base, subtraímos os expoentes, mantendo a base. Exemplo: <img src="/imgs/numeros/qdpcamb.png">', 'Números'),
(80, 'Quociente de potências com o mesmo expoente', 'Para efetuar a divisão de potências com o mesmo expoente, dividímos as bases, mantendo o expoente. Exemplo: <img src="/imgs/numeros/qdpcome.png">', 'Números'),
(81, 'Raiz Cúbica', 'A <strong>Raiz Cúbica</strong> do número <i>z</i> é o número positivo que, ao cubo (elevado a 3), resulta <i>z</i>. Exemplo: <img src="/imgs/numeros/3r125.png">', 'Números'),
(82, 'Raiz Quadrada', 'A <strong>Raiz Quadrada</strong> do número <i>z</i> é o número positivo que, ao quadrado (elevado a 2), resulta <i>z</i>. Exemplo: <img src="/imgs/numeros/r100.png">', 'Números'),
(83, 'Razão', 'As <strong>razões</strong> são representadas através de frações que permitem comparar dois números, denominados termos, calculando o quociente entre eles. Pode representar-se da seguinte forma, onde <i>a</i> e <i>b</i> são os valores:<br><br><img src="/imgs/algebra/razao.png">', 'Álgebra'),
(84, 'Rectângulo', NULL, 'Geometria'),
(85, 'Reta Numérica', 'A representação dos números pode ser efetuada através de uma <strong>reta numérica</strong>, onde os números são apresentados num único ponto ou eixo. O ponto "0" chama-se <strong>origem</strong>.<br><br><img src="imgs/numeros/retanumerica.png">', 'Números'),
(86, 'Sequências de Números', 'Sequências numéricas são listas de números com um determinado padrão. A cada número pertencente à sequência chamamos <strong>termo da sequência</strong>.', 'Álgebra'),
(87, 'Termo Geral', 'O <strong>termo geral</strong> de uma <a href="/?title=sequencias_de_numeros">sequência de números</a> é a expressão algébrica que define a lei originadora dos números da sequência. Na sequência {3, 6, 9...}, o termo geral é <i>3n</i>, onde <i>n</i> é a posição em que se encontra o valor.', 'Álgebra'),
(88, 'Termos da Sequência', 'Os termos da sequência são todos os números pertencentes a uma <a href="/?title=sequencias_de_numeros">sequência numérica</a>.', 'Álgebra'),
(89, 'Trapézio', NULL, 'Geometria'),
(90, 'Triângulo', 'O <strong>Triângulo</strong> é uma figura geométrica com 3 lados. Exemplo: <br><img src="/imgs/geometria/triangulo.png"><br><br>Mais sobre triângulos:<br><br>\n- <a href="/?title=area-de-um-triangulo">Área de um triângulo</a><br>\n- <a href="/?title=classificacao-de-triangulos">Classificação de Triângulos</a><br>\n- <a href="/?title=angulos-internos-de-um-triangulo">Ângulos Internos</a><br>\n- <a href="/?title=angulos-externos-de-um-triangulo">Ângulos Externos</a><br>\n- <a href="/?title=criterios-de-congruencia-de-triangulos">Critérios de Congruência de Triângulos</a><br>', 'Geometria');

-- --------------------------------------------------------

--
-- Table structure for table `zusersx`
--

CREATE TABLE IF NOT EXISTS `zusersx` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `zusersx`
--

INSERT INTO `zusersx` (`id`, `name`, `user`, `pass`) VALUES
(1, 'Henrique Dias', 'hacdias', '123');
--
-- Database: `phpmyadmin`
--

-- --------------------------------------------------------

--
-- Table structure for table `pma_bookmark`
--

CREATE TABLE IF NOT EXISTS `pma_bookmark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pma_column_info`
--

CREATE TABLE IF NOT EXISTS `pma_column_info` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pma_designer_coords`
--

CREATE TABLE IF NOT EXISTS `pma_designer_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `x` int(11) DEFAULT NULL,
  `y` int(11) DEFAULT NULL,
  `v` tinyint(4) DEFAULT NULL,
  `h` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`db_name`,`table_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma_history`
--

CREATE TABLE IF NOT EXISTS `pma_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sqlquery` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`,`db`,`table`,`timevalue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pma_pdf_pages`
--

CREATE TABLE IF NOT EXISTS `pma_pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`page_nr`),
  KEY `db_name` (`db_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pma_recent`
--

CREATE TABLE IF NOT EXISTS `pma_recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma_recent`
--

INSERT INTO `pma_recent` (`username`, `tables`) VALUES
('root', '[{"db":"mathpocket","table":"items"},{"db":"phpmyadmin","table":"pma_column_info"},{"db":"phpmyadmin","table":"pma_designer_coords"},{"db":"phpmyadmin","table":"pma_history"},{"db":"phpmyadmin","table":"pma_pdf_pages"},{"db":"phpmyadmin","table":"pma_recent"},{"db":"phpmyadmin","table":"pma_relation"},{"db":"cdcol","table":"cds"},{"db":"mysql","table":"user"},{"db":"mysql","table":"help_relation"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma_relation`
--

CREATE TABLE IF NOT EXISTS `pma_relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  KEY `foreign_field` (`foreign_db`,`foreign_table`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma_table_coords`
--

CREATE TABLE IF NOT EXISTS `pma_table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT '0',
  `x` float unsigned NOT NULL DEFAULT '0',
  `y` float unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma_table_info`
--

CREATE TABLE IF NOT EXISTS `pma_table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`db_name`,`table_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma_table_uiprefs`
--

CREATE TABLE IF NOT EXISTS `pma_table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`username`,`db_name`,`table_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Dumping data for table `pma_table_uiprefs`
--

INSERT INTO `pma_table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'mathpocket', 'items', '{"sorted_col":"`id` ASC"}', '2014-04-10 08:17:07');

-- --------------------------------------------------------

--
-- Table structure for table `pma_tracking`
--

CREATE TABLE IF NOT EXISTS `pma_tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin,
  `data_sql` longtext COLLATE utf8_bin,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`db_name`,`table_name`,`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma_userconfig`
--

CREATE TABLE IF NOT EXISTS `pma_userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `config_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma_userconfig`
--

INSERT INTO `pma_userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2014-04-09 10:00:01', '{"collation_connection":"utf8mb4_general_ci"}');
--
-- Database: `test`
--
--
-- Database: `webauth`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_pwd`
--

CREATE TABLE IF NOT EXISTS `user_pwd` (
  `name` char(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pass` char(32) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `user_pwd`
--

INSERT INTO `user_pwd` (`name`, `pass`) VALUES
('xampp', 'wampp');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
