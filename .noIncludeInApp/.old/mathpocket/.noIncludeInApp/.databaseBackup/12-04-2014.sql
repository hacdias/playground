-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 12-Abr-2014 às 23:48
-- Versão do servidor: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mathpocket`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=92 ;

--
-- Extraindo dados da tabela `items`
--

INSERT INTO `items` (`id`, `title`, `description`, `category`) VALUES
(1, 'Amplitude', 'Consiste na diferença entre o maior e menor valores de um <a href="/?title=conjuntos_de_numeros">conjunto de números</a>.', 'Estatística'),
(2, 'Amplitude interquartil', '<p>A <strong>Amplitude interquartil</strong> &eacute; a diferen&ccedil;a entre o 3&ordm; e o 1&ordm; quartil de um conjunto de n&uacute;meros.</p>\r\n', 'Estatística'),
(3, 'Ângulos', '<p>&nbsp;</p>\r\n\r\n<p>Um <strong>&acirc;ngulo</strong> &eacute; a zona de um plano criada atrav&eacute;s da colis&atilde;o de duas <a href="/item/semirreta">semirretas</a> que possuem uma <a href="/item/origem">origem</a> em comum, denominada <a href="/item/vertice">v&eacute;rtice</a>. A abertura do &acirc;ngulo &eacute; medida em radianos ou graus. Este conceito &eacute; deveras importante, ocupando um grande lugar na Geometria euclideana.&nbsp;</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/angulo-agudo.png" style="height:91px; width:100px" />&nbsp;Na imagem &nbsp;ao lado, est&aacute; representado a amarelo um &acirc;ngulo.</p>\r\n', 'Geometria'),
(4, 'Ângulos Alternos Internos', '<p><strong>&Acirc;ngulos Alternos Internos</strong> s&atilde;o &acirc;ngulos congruentes que t&ecirc;m <strong>diferentes </strong>v&eacute;rtices e est&atilde;o em lados <strong>diferentes </strong>da reta que interseta duas outras retas <strong>paralelas</strong>. Os &acirc;ngulos assinalados a vermelho na imagem seguinte s&atilde;o deste tipo:</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/angulos-alternos-internos.png" style="height:166px; width:319px" /></p>\r\n', 'Geometria'),
(5, 'Ângulos Complementares', '<p><strong>&Acirc;ngulos Complementares</strong> s&atilde;o pares de &acirc;ngulos cuja soma das amplitudes de ambos &eacute; <strong>90&ordm;</strong>. Os &acirc;ngulos representados na seguinte imagem s&atilde;o complementares:</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/angulos-complementares.png" style="height:178px; width:232px" /></p>\r\n', 'Geometria'),
(6, 'Ângulos Externos de um triângulo', '<p>A soma dos <strong>&acirc;ngulos externos de um tri&acirc;ngulo</strong> &eacute; sempre de 360&ordm;. Estes s&atilde;o os &acirc;ngulos formados pelas semirretas iniciadas em cada v&eacute;rtice do tri&acirc;ngulo que passam pelo ponto seguinte no tri&acirc;ngulo. V&ecirc; o seguinte exemplo:</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/angulos-externos-triangulo.png" style="height:276px; width:526px" /></p>\r\n', 'Geometria'),
(7, 'Ângulos internos de um quadrilátero', '<p>Os <strong><a href="/item/angulos">&acirc;ngulos</a> internos de um quadril&aacute;tero</strong> s&atilde;o todos os &acirc;ngulos formados pelos lados do quadril&aacute;tero. A sua soma &eacute; sempre <strong>360&ordm;</strong>.</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/angulos-internos-quadrado.png" style="height:147px; width:146px" /></p>\r\n', 'Geometria'),
(8, 'Ângulos internos de um triângulo', '<p>Os<strong> &acirc;ngulos internos de um <a href="/item/triangulo">tri&acirc;ngulo</a></strong> s&atilde;o todos os &acirc;ngulos formados pelos lados do tri&acirc;ngulo dentro da &aacute;rea do mesmo. A sua soma &eacute; sempre <strong>180&ordm;</strong>.</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/angulos-internos-triangulo.png" style="height:133px; width:137px" /></p>\r\n', 'Geometria'),
(9, 'Ângulos Suplementares', '<p><strong>&Acirc;ngulos Suplementares</strong>&nbsp;s&atilde;o pares de &acirc;ngulos cuja soma das amplitudes de ambos &eacute; <strong>180&ordm;</strong>. Os &acirc;ngulos representados na seguinte imagem s&atilde;o suplementares:</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/angulos-suplementares.png" style="height:137px; width:295px" /></p>\r\n', 'Geometria'),
(10, 'Ângulos Verticalmente Opostos', '<p><strong>&Acirc;ngulos Verticalmente Opostos</strong> s&atilde;o &acirc;ngulos com o mesmo v&eacute;rtice e os lados de um prolongam-se nos lados do outro. Os &acirc;ngulos s&atilde;o congruentes.</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/angulos-vert-opostos.png" style="height:137px; width:274px" /></p>\r\n', 'Geometria'),
(11, 'Área de um círculo', '<p>A <strong>&aacute;rea de um c&iacute;rculo</strong> &eacute; dada pelo produto entre o raio ao quadrado e o <a href="/item/pi">Pi</a>.&nbsp;<img alt="" src="/imgs/geometria/formulas/area-circulo.png" style="height:18px; width:69px" /></p>\r\n\r\n<p><img alt="" src="/imgs/geometria/circulo.png" style="height:210px; width:210px" /></p>\r\n\r\n<p>&nbsp;</p>\r\n', 'Geometria'),
(12, 'Área de um quadrado', '<p>A <strong>&aacute;rea de um <a href="/item/quadrado">quadrado</a></strong> &eacute; dada pelo comprimento do lado ao quadrado.&nbsp;<img alt="" src="/imgs/geometria/formulas/area-quadrado.png" style="height:18px; width:54px" /></p>\r\n\r\n<p><img alt="" src="/imgs/geometria/quadrado-lado.png" style="height:215px; width:229px" /></p>\r\n', 'Geometria'),
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
(35, 'Gráfico de caule-e-folhas', '<p>Um gr&aacute;fico de <strong>caule-e-folhas</strong> (tamb&eacute;m &nbsp;conhecido por diagrama de caule-e-folhas) &eacute; um gr&aacute;fico que ajuda na representa&ccedil;&atilde;o gr&aacute;fica de n&uacute;meros. Considera o seguinte conjunto de n&uacute;meros e o seu respetivo diagrama de caule-e-folhas.</p>\r\n\r\n<p><strong>N&uacute;meros </strong>= {4, 15, 26, 28, 30, 56, 59, 100, 101}</p>\r\n\r\n<p><strong>Diagrama</strong></p>\r\n\r\n<table cellpadding="1" cellspacing="1" style="width:100px">\r\n	<tbody>\r\n		<tr>\r\n			<td style="text-align:right">0|</td>\r\n			<td>4</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="text-align:right">1|</td>\r\n			<td>5</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="text-align:right">2|</td>\r\n			<td>6 8</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="text-align:right">3|</td>\r\n			<td>0</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="text-align:right">5|</td>\r\n			<td>6 9</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="text-align:right">10|</td>\r\n			<td>0 1</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n', 'Estatística'),
(36, 'Histograma', NULL, 'Estatística'),
(37, 'Losango', '<p>O <strong>Losango </strong>&eacute; uma figura geom&eacute;trica com quatro lados (quadril&aacute;tero). Os seus 4 lados s&atilde;o <strong>congruentes</strong>.</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/losango.png" style="height:300px; width:200px" /></p>\r\n', 'Geometria'),
(38, 'Média', 'É um valor obtido somando todos os dados e dividindo o resultado pelo número de dados.', 'Estatística'),
(39, 'Mediana', NULL, 'Estatística'),
(40, 'Medidas de Dispersão', NULL, 'Estatística'),
(41, 'Medidas de Localização', NULL, 'Estatística'),
(42, 'Medidas de Localização Central', NULL, 'Estatística'),
(43, 'Moda', 'É o dado que surge com mais vezes.', 'Estatística'),
(44, 'Modelo de Pólya', '<p>O<strong> Modelo de P&oacute;lya</strong> foi criado por&nbsp;George P&oacute;lya, um professor de Matem&aacute;tica da Universidade de Stanford. Em 1945 G.P&oacute;lya publicou um livro chamado <em>Como resolver problemas</em>.</p>\r\n\r\n<p>Este livro fala de passos que devemos ter em conta quando estamos a resolver um problema. Na tabela seguinte podes observ&aacute;-los:</p>\r\n\r\n<table border="0" cellpadding="1" cellspacing="1" style="width:500px">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan="1" rowspan="5">\r\n			<p style="text-align:right"><strong>Compreens&atilde;o</strong></p>\r\n\r\n			<p style="text-align:right"><strong>do Problema</strong></p>\r\n			</td>\r\n			<td>No problema, o que &eacute; pedido?</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Que dados nos s&atilde;o fornecidos?</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Existem condi&ccedil;&otilde;es? Se sim, quais?</td>\r\n		</tr>\r\n		<tr>\r\n			<td>A informa&ccedil;&atilde;o fornecida &eacute; suficiente?</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Faz um desenho escolhendo uma nota&ccedil;&atilde;o adequada.</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan="1" rowspan="4">\r\n			<p style="text-align:right"><strong>Establecimento</strong></p>\r\n\r\n			<p style="text-align:right"><strong>de um plano</strong></p>\r\n			</td>\r\n			<td>Alguma vez viste este problema ou semelhante?</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Se sim, podes utilizar o mesmo m&eacute;todo de resolu&ccedil;&atilde;o?</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Fizeste utiliza&ccedil;&atilde;o de todos os dados?</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Que estrat&eacute;gias s&atilde;o poss&iacute;veis na resolu&ccedil;&atilde;o deste problema?</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p style="text-align:right"><strong>Execu&ccedil;&atilde;o do plano</strong></p>\r\n			</td>\r\n			<td>Coloca o teu plano em a&ccedil;&atilde;o, verificando sempre cada passo que d&aacute;s.</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan="1" rowspan="4">\r\n			<p style="text-align:right"><strong>Verifica&ccedil;&atilde;o</strong></p>\r\n			</td>\r\n			<td>&Eacute; poss&iacute;vel verificar o resultado obtido?</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Se sim, ele est&aacute; de acordo com os dados do problema?</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Poder-se-ia chegar ao resultado atrav&eacute;s de outro caminho?</td>\r\n		</tr>\r\n		<tr>\r\n			<td>O m&eacute;todo utilizado pode ser utilizado noutros problemas?</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n', 'Álgebra'),
(45, 'Módulo ou Valor Absoluto', '<p>Ou m&oacute;dulo ou valor absoluto &eacute; a dist&acirc;ncia do ponto que o representa &agrave; origem. Representa-se por |x| que quer dizer &quot;m&oacute;dulo de x&quot;.<br />\r\n<br />\r\n<img src="/imgs/numeros/moduloe.png" /></p>\r\n', 'Números'),
(46, 'Números Algébricos', '<img src="/imgs/numeros/a.png" class="left"> Todos os números que são solução de <a href="/?title=equacao_polinomial">equações polinomiais</a>. <br><br>Inclui todos os números racionais e alguns irracionais.', 'Números'),
(47, 'Números Complexos', '<img src="/imgs/numeros/c.png" class="left"> Os Números Complexos são todos os números reais e imaginários. <br><br> Podem ser fruto de operações entre reais e imaginários, por exemplo.', 'Números'),
(48, 'Números Imaginários', '<img src="/imgs/numeros/i.png" class="left"> Todos os números que ao quadrado resultam num número negativo. <br><br> Números imaginários são imaginados: se colocarmos na calculadora a raiz quadrada de -9 esta ir-nos-à apresentar um erro porém, podemos imaginar que o resultado seria -3.', 'Números'),
(49, 'Números Inteiros', 'Todos os números inteiros (não decimais) positivos, negativos e 0.<br><br>Conjunto = {...-3, -2, -1, 0, 1, 2, 3...}', 'Números'),
(50, 'Números Irracionais', 'Todos os números que não são racionais, como o <img src=`/imgs/numeros/pi.png` class=`small`>  , por exemplo.', 'Números'),
(51, 'Números Naturais', '<img src="/imgs/numeros/n.png" class="left">  Todos os números inteiros (não decimais) a partir de 1 (inclusive).<br><br>Conjunto = {1, 2, 3...}', 'Números'),
(52, 'Números Racionais', '<img src="/imgs/numeros/q.png" class="left"> Todos os números que podem ser criados através da divisão de dois números inteiros (excepto 0). São escritos sobre a forma de <a href="/?title=fracoes">frações</a>.<br><br> <strong>Q</strong> vem de "quociente".  Conjunto = {...3/2, 1/2...}', 'Números'),
(53, 'Números Reais', '<img src="/imgs/numeros/r.png" class="left"> Os Números Reais são todos os números racionais e irracionais podendo ser positivos, negativos ou zero. <br><br> Inclui todos os números algébricos e transcendentes.', 'Números'),
(54, 'Números Transcendentes', 'Todos os números que não são algébricos, como o <img src="/imgs/numeros/pi.png" class="small">  , por exemplo.', 'Números'),
(55, 'Papagaio', '<p>O <strong>papagaio </strong>&eacute; um quadril&aacute;tero com os dois pares de lados consecutivos congruentes.</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/papagaio.png" style="height:300px; width:200px" /></p>\r\n', 'Geometria'),
(56, 'Paralelogramo', '<p>Um <strong>paralelogramo </strong>&eacute; um quadril&aacute;tero cujos lados opostos s&atilde;o paralelos.</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/paralelogramo.png" style="height:300px; width:300px" /></p>\r\n', 'Geometria'),
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
(72, 'Propriedades da Multiplicação', '<p>A multiplica&ccedil;&atilde;o conta com diversas propriedades que auxiliam a multiplica&ccedil;&atilde;o.</p>\r\n\r\n<p><a href="/?title=propriedade-comutativa-da-multiplicacao">Propriedade comutativa</a></p>\r\n\r\n<p><img src="/imgs/numeros/propsmulti/propcomutativa.png" style="line-height:1.6" /></p>\r\n\r\n<p><a href="/?title=propriedade-associativa-da-multiplicacao">Propriedade associativa</a></p>\r\n\r\n<p><img src="/imgs/numeros/propsmulti/propassociativa.png" /></p>\r\n\r\n<p><a href="/?title=propriedade-do-elemento-neutro-da-multiplicacao">Propriedade do Elemento Neutro</a></p>\r\n\r\n<p><img src="/imgs/numeros/propsmulti/propelementoneu.png" /></p>\r\n\r\n<p><a href="/?title=propriedade-do-elemento-absorvente-da-multiplicacao">Propriedade do Elemento Absorvente</a></p>\r\n\r\n<p><img src="/imgs/numeros/propsmulti/propelementoabs.png" /></p>\r\n\r\n<p><a href="/?title=propriedade-distributiva-da-multiplicacao-em-relacao-a-adicao">Propriedade Distributiva da Multiplica&ccedil;&atilde;o em Rela&ccedil;&atilde;o &agrave; Adi&ccedil;&atilde;o</a></p>\r\n\r\n<p><img src="/imgs/numeros/propsmulti/propdistributivamultad.png" /></p>\r\n\r\n<p>Clica nos itens para saberes mais acerca de cada propriedade!</p>\r\n', 'Números'),
(73, 'Propriedades dos paralelogramos', NULL, 'Geometria'),
(74, 'Quadrado', '<p>Um <strong>quadrado </strong>&eacute; um <a href="/item/paralelogramo">paralelogramo</a> com os quatro &acirc;ngulos e quatro lados congruentes. Todos os seus &acirc;ngulos s&atilde;o retos.</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/quadrado.png" style="height:200px; width:200px" /></p>\r\n', 'Geometria'),
(75, 'Quadrados Perfeitos', 'Quadrados perfeitos são números cuja <a href="/?title=raiz_quadrada">raiz quadrada</a> é um número inteiro. Exemplo: <img src="/imgs/numeros/r25.png">', 'Números'),
(76, 'Quartis', NULL, 'Estatística'),
(77, 'Quociente de dois números com  o mesmo sinal', 'O <strong>quociente de dois números com  o mesmo sinal</strong> é um número positivo.', 'Números'),
(78, 'Quociente de dois números com sinais diferentes', 'O <strong>quociente de dois números com diferentes sinais</strong> é um número negativo.', 'Números'),
(79, 'Quociente de potências com a mesma base', 'Para efetuar a divisão de potências com a mesma base, subtraímos os expoentes, mantendo a base. Exemplo: <img src="/imgs/numeros/qdpcamb.png">', 'Números'),
(80, 'Quociente de potências com o mesmo expoente', 'Para efetuar a divisão de potências com o mesmo expoente, dividímos as bases, mantendo o expoente. Exemplo: <img src="/imgs/numeros/qdpcome.png">', 'Números'),
(81, 'Raiz Cúbica', 'A <strong>Raiz Cúbica</strong> do número <i>z</i> é o número positivo que, ao cubo (elevado a 3), resulta <i>z</i>. Exemplo: <img src="/imgs/numeros/3r125.png">', 'Números'),
(82, 'Raiz Quadrada', 'A <strong>Raiz Quadrada</strong> do número <i>z</i> é o número positivo que, ao quadrado (elevado a 2), resulta <i>z</i>. Exemplo: <img src="/imgs/numeros/r100.png">', 'Números'),
(83, 'Razão', 'As <strong>razões</strong> são representadas através de frações que permitem comparar dois números, denominados termos, calculando o quociente entre eles. Pode representar-se da seguinte forma, onde <i>a</i> e <i>b</i> são os valores:<br><br><img src="/imgs/algebra/razao.png">', 'Álgebra'),
(84, 'Rectângulo', '<p><strong>Rect&acirc;ngulos</strong> s&atilde;o <a href="/item/paralelogramo">paralelogramos</a> com &nbsp;os quatro &acirc;ngulos internos congruentes e rectos.</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/retangulo.png" style="height:300px; width:200px" /></p>\r\n', 'Geometria'),
(85, 'Reta Numérica', 'A representação dos números pode ser efetuada através de uma <strong>reta numérica</strong>, onde os números são apresentados num único ponto ou eixo. O ponto "0" chama-se <strong>origem</strong>.<br><br><img src="imgs/numeros/retanumerica.png">', 'Números'),
(86, 'Sequências de Números', 'Sequências numéricas são listas de números com um determinado padrão. A cada número pertencente à sequência chamamos <strong>termo da sequência</strong>.', 'Álgebra'),
(87, 'Termo Geral', 'O <strong>termo geral</strong> de uma <a href="/?title=sequencias_de_numeros">sequência de números</a> é a expressão algébrica que define a lei originadora dos números da sequência. Na sequência {3, 6, 9...}, o termo geral é <i>3n</i>, onde <i>n</i> é a posição em que se encontra o valor.', 'Álgebra'),
(88, 'Termos da Sequência', 'Os termos da sequência são todos os números pertencentes a uma <a href="/?title=sequencias_de_numeros">sequência numérica</a>.', 'Álgebra'),
(89, 'Trapézio', '<p>Um <strong>trap&eacute;zio </strong>&eacute; um quadril&aacute;tero que tem pelo menos um par de lados opostos paralelos.</p>\r\n\r\n<p><img alt="" src="/imgs/geometria/trapezio.png" style="height:200px; width:300px" /></p>\r\n', 'Geometria'),
(90, 'Triângulo', 'O <strong>Triângulo</strong> é uma figura geométrica com 3 lados. Exemplo: <br><img src="/imgs/geometria/triangulo.png"><br><br>Mais sobre triângulos:<br><br>\n- <a href="/?title=area-de-um-triangulo">Área de um triângulo</a><br>\n- <a href="/?title=classificacao-de-triangulos">Classificação de Triângulos</a><br>\n- <a href="/?title=angulos-internos-de-um-triangulo">Ângulos Internos</a><br>\n- <a href="/?title=angulos-externos-de-um-triangulo">Ângulos Externos</a><br>\n- <a href="/?title=criterios-de-congruencia-de-triangulos">Critérios de Congruência de Triângulos</a><br>', 'Geometria'),
(91, 'teste', '', '');

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
(1, 'Henrique Dias', 'teste', 'teste');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
