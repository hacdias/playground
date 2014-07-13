-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 21-Abr-2014 às 11:05
-- Versão do servidor: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `codepocket`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `quotes`
--

CREATE TABLE IF NOT EXISTS `quotes` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `quote` text NOT NULL,
  `author` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `quotes`
--

INSERT INTO `quotes` (`id`, `quote`, `author`) VALUES
(1, 'Medir o progresso da programação por linhas de código é como medir o progresso da construção de aeronaves em termos de peso.', 'Bill Gates'),
(2, 'Andar sobre as águas e fazer software a partir de uma especificação é simples se ambas estiverem congeladas.', 'Edward V Berard'),
(3, 'A complexidade de depurar é o dobro da de escrever o código. Portanto, se você escrever código os mais inteligente possível, por definição você não será esperto o suficiente para depurá-lo.', 'Brian W. Kernighan'),
(4, 'Existem duas maneiras de construir um projeto de software. Uma é fazê-lo tão simples que obviamente não há falhas. A outra é fazê-lo tão complicado que não existem falhas óbvias.', 'C.A.R. Hoare');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rail_css`
--

CREATE TABLE IF NOT EXISTS `rail_css` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `rail_css`
--

INSERT INTO `rail_css` (`id`, `title`, `content`) VALUES
(1, 'a', 'a'),
(2, 'Teste', '<p>ab</p>\r\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rail_html`
--

CREATE TABLE IF NOT EXISTS `rail_html` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `img` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `rail_html`
--

INSERT INTO `rail_html` (`id`, `title`, `content`, `img`) VALUES
(1, 'Olá HTML!', '<p>Ol&aacute; a todos!</p>\r\n\r\n<p>Iremos come&ccedil;ar por fazer uma introdu&ccedil;&atilde;o ao HTML apresentando-vos ao mesmo. &Eacute; hora de dizerem &quot;Ol&aacute; HTML!&quot;.&nbsp;</p>\r\n\r\n<p>Em 1990, Tim Berners-Lee criou uma linguagem de marca&ccedil;&atilde;o chamada HTML com o intuito de trocar informa&ccedil;&atilde;o e documentos de pesquisa com os seus colegas cientistas de outras universidades, tendo sido muito bem recebido.</p>\r\n\r\n<p>Quando abrimos uma p&aacute;gina&nbsp;web<em>,&nbsp;</em>como a que est&aacute;s a visualizar agora, vemos a interpreta&ccedil;&atilde;o do nosso navegadador ao HTML.&nbsp;Disto podemos concluir que HTML &eacute; a l&iacute;ngua &quot;m&atilde;e&quot; da web.&nbsp;</p>\r\n\r\n<p>Agora vamos interpretar a palavra &quot;HTML&quot;. HTML significa HyperText Mark-up Language ou seja, Linguagem de Marca&ccedil;&atilde;o de HiperTexto. Se estiveres pronto(a) para continuar, clica em seguinte!</p>\r\n', '1_1'),
(2, 'Tags e mais Tags!', 'Lorem ipsum d<br>olor sit amet, consectetur adipiscing elit. Nullam nulla orci, aliquet varius eros et, commodo ullamcorper tortor. Maecenas mattis pulvinar est, quis egestas neque ultrices et. Aenean tempus turpis id orci gravida sagittis. Nunc a porttitor dui. Morbi vestibulum vulputate ullamcorper. Pellentesque non suscipit ipsum, et congue mauris. Pellentesque ultricies ullamcorper ligula sed dictum.\n\nDonec pulvinar suscipit quam, quis eleifend purus molestie semper. Phasellus elementum pellentesque turpis eu mattis. Nunc iaculis, turpis non vestibulum mattis, diam orci euismod tellus, at tempus sem neque et libero. Sed mollis vel magna et faucibus. Suspendisse in hendrerit tortor, in malesuada tortor. Suspendisse molestie ultrices erat sed feugiat. Nullam felis nulla, tincidunt mollis interdum et, varius a tortor. Vivamus ac est rutrum, scelerisque lectus vel, eleifend lacus. Donec commodo volutpat nulla, in congue sapien aliquet hendrerit. Cras commodo consequat nibh vitae aliquam. Proin vestibulum a nibh vel mollis.', ''),
(3, 'a', 'a', ''),
(4, 'Teste', '<p>Este e um teste.</p>\r\n', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rail_list`
--

CREATE TABLE IF NOT EXISTS `rail_list` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `color` varchar(1000) NOT NULL,
  `what` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `rail_list`
--

INSERT INTO `rail_list` (`id`, `title`, `description`, `image`, `color`, `what`) VALUES
(1, 'HTML', '<p>Come&ccedil;a com HTML para aprenderes os princ&iacute;pios b&aacute;sicos da Web!</p>\r\n', 'html', 'orange', '<p>HTML &eacute; a linguagem de marca&ccedil;&atilde;o base da web e o seu acr&oacute;nimo significa&nbsp;<em>HyperText Markup Language&nbsp;</em>ou seja, Linguagem de Marca&ccedil;&atilde;o de Hipertexto e &eacute; utilizada para produzir p&aacute;ginas web.</p>\r\n'),
(2, 'CSS', '<p>Com HTML vem o CSS! D&aacute; um visual &agrave;s tuas p&aacute;ginas web com CSS!</p>\r\n', 'css', 'blue', '<p>O CSS &eacute; um suplemento ao HTML pois acompanha-o e que dizer Cascading Style Sheets e permite-nos desenvolver folhas de estilo que definem a apresenta&ccedil;&atilde;o dos documentos criados em linguagens de marca&ccedil;&atilde;o, como HTML por exemplo.</p>\r\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `userdata`
--

CREATE TABLE IF NOT EXISTS `userdata` (
  `user` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `userdata`
--

INSERT INTO `userdata` (`user`, `color`) VALUES
('admin', 'blue'),
('Teste', 'green'),
('User', 'orange');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `user` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `user`, `password`, `type`) VALUES
(5, 'Teste', 'teste', 'UG5tWDdsL0ZnSmoxMnRnQWQyREROZz09', 1),
(6, 'Administrador', 'admin', 'T2ZPTkdDR0hsOUFoZFZlWVVFY05Kdz09', 0),
(7, 'User', 'user', 'TnQxa2hwa3YxQ3pGZGpRMkp6NGc3Zz09', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
