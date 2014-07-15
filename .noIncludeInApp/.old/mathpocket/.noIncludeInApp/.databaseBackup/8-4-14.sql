-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 08-Abr-2014 às 21:15
-- Versão do servidor: 5.6.12-log
-- versão do PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `mathpocket`
--
CREATE DATABASE IF NOT EXISTS `mathpocket` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mathpocket`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(3, 'Álgebra'),
(4, 'Estatística'),
(2, 'Geometria'),
(1, 'Números');

-- --------------------------------------------------------

--
-- Estrutura da tabela `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `category` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=91 ;

--
-- Extraindo dados da tabela `items`
--

INSERT INTO `items` (`id`, `title`, `description`, `category`) VALUES
(1, 'Amplitude', 'Consiste na diferença entre o maior e menor valores de um <a href="/?title=conjuntos_de_numeros">conjunto de números</a>.', 'Estatística'),
(2, 'Amplitude interquartil', 'Amplitude interquartil', 'Estatística'),
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
(21, 'Conjuntos de Números', '<img src="/imgs/numeros/conjunto_numeros.png" id="numbers_conj"> Os números estão divididos em vários conjuntos. Estes são: <br> <br> <img src="/imgs/numeros/n.png"class="small"> - <a href="/?title=numeros_naturais">Números Naturais</a><br> <img src="/imgs/numeros/z.png"class="small"> - <a href="/?title=numeros_inteiros">Números Inteiros</a><br> <img src="/imgs/numeros/q.png"class="small"> - <a href="/?title=numeros_racionais">Números Racionais</a><br> <a href="/?title=numeros_irracionais">Números Irracionais</a><br> <img src="/imgs/numeros/a.png"class="small"> - <a href="/?title=numeros_algebricos">Números Algébricos</a><br> <a href="/?title=numeros_transcendentes">Números Transcendentes</a><br> <img src="/imgs/numeros/r.png"class="small"> - <a href="/?title=numeros_reais">Números Reais</a><br> <img src="/imgs/numeros/i.png"class="small"> - <a href="/?title=numeros_imaginarios">Números Imaginários</a><br> <img src="/imgs/numeros/c.png"class="small"> - <a href="/?title=numeros_complexos">Números Complexos</a><br><br> A representação destes conjuntos pode ser personalizada. Ao escrevermos <img src="/imgs/symbols/z+.png" class="small">, estou-me a referir a todos os números inteiros positivos. Quando escrevemos <img class="small"src="/imgs/symbols/n0.png"> referimo-nos aos números naturais incluindo o 0.<br><br><strong>Clica nos itens para saberes mais!</strong>', 'Números'),
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
(35, 'Gráfico de caule-e-folhas', NULL, 'Estatística'),
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
-- Estrutura da tabela `zusersx`
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
-- Extraindo dados da tabela `zusersx`
--

INSERT INTO `zusersx` (`id`, `name`, `user`, `pass`) VALUES
(1, 'Henrique Dias', 'hacdias', '123');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
