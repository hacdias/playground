-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 12-Maio-2014 às 23:00
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
-- Estrutura da tabela `rail_css`
--

CREATE TABLE IF NOT EXISTS `rail_css` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(55) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `rail_css`
--

INSERT INTO `rail_css` (`id`, `title`, `content`, `img`) VALUES
(1, 'a', 'b', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rail_html`
--

CREATE TABLE IF NOT EXISTS `rail_html` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(55) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `rail_html`
--

INSERT INTO `rail_html` (`id`, `title`, `content`, `img`) VALUES
(1, 'Olá HTML!', '<p>Olá a todos!</p>\r\n\r\n<p>Iremos começar por fazer uma introdução ao HTML apresentando-vos ao mesmo. É hora de dizerem "Olá HTML!".&nbsp;</p>\r\n\r\n<p>Em 1990, Tim Berners-Lee criou uma linguagem de marcação chamada HTML com o intuito de trocar informação e documentos de pesquisa com os seus colegas cientistas de outras universidades, tendo sido muito bem recebido.</p>\r\n\r\n<p>Quando abrimos uma página&nbsp;web,&nbsp;como a que estás a visualizar agora, vemos a interpretação do nosso navegadador ao HTML.&nbsp;Disto podemos concluir que HTML é a língua "mãe" da web.&nbsp;</p>\r\n\r\n<p>Agora vamos interpretar a palavra "HTML". HTML significa HyperText Mark-up Language ou seja, Linguagem de Marcação de HiperTexto. Se estiveres pronto(a) para continuar, clica em seguinte! (A seguir já te vamos falar acerca das caixas de texto que aparecem abaixo.)</p>', 'banner'),
(2, 'Tags, tags e mais tags!', '<p>O HTML é fundamental no mundo do desenvolvimento web logo, iremos começar com este. Depois de uma breve introdução ao HTML, vamos falar sobre <i>tags&nbsp;</i>e o que estas&nbsp;<i></i><i></i>são.</p><p><b>Tags&nbsp;</b>são <span class="wysiwyg-color-red">as estruturas</span><span class="wysiwyg-color-blue">&nbsp;do</span><span> código HTML que contêm as instruções que informam o browser da forma como o site deve ser apresentado. Em HTML, as tags começam sempre com o sinal menor "&lt;" e te</span><span class="wysiwyg-color-blue">rm</span>inam com o sinal maior "&gt;". Existem dois tipos de tags: as tags de&nbsp;<b>abertura&nbsp;</b>e as tags de&nbsp;<b>fechamento</b>. "" e "", respetivamente.&nbsp;A<span class="wysiwyg-color-blue">s diferenças entre ambas é que a de fechamento contém uma barra a seguir ao sinal menor.&nbsp;</span></p><p><span class="wysiwyg-color-blue">Em HTML existem inúmeras&nbsp;</span><i><span class="wysiwyg-color-blue">tags&nbsp;</span></i><span class="wysiwyg-color-blue">que nos permitem transformar a nossa página web. Vamos começar a falar das tags mais básicas e ao longo do tempo iremos falar de outras.</span></p><p><span class="wysiwyg-color-blue"></span><br></p>', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `rail_list`
--

INSERT INTO `rail_list` (`id`, `title`, `description`, `image`, `color`, `what`) VALUES
(3, 'HTML', '<p>HTML &eacute; a porta de entrada no desenvolvimento web! Se n&atilde;o tens conhecimentos de HTML, come&ccedil;a por aqui.</p>\r\n', 'html', 'orange', '<p>HTML &eacute; a linguagem de marca&ccedil;&atilde;o base da web e o seu acr&oacute;nimo significa HyperText Markup Language ou seja, Linguagem de Marca&ccedil;&atilde;o de Hipertexto e &eacute; utilizada para produzir p&aacute;ginas web.</p>\r\n'),
(4, 'CSS', '<p>Depois de aprenderes HTML, o seu auxiliar de estilo, CSS tem que ser aprendido!</p>\r\n', 'css', 'blue', '<p>Com HTML vem CSS. CSS &eacute; um sistema de estilos que nos permite personalizar as p&aacute;ginas web de forma pr&aacute;tica. N&atilde;o &eacute; uma linguagem, nem de programa&ccedil;&atilde;o, nem marca&ccedil;&atilde;o, mas sim um complemento ao HTML. &Eacute; fundamental na web.</p>\r\n'),
(6, 'teste', '', '', 'asa', 'aaa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rail_teste`
--

CREATE TABLE IF NOT EXISTS `rail_teste` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(55) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` varchar(500) NOT NULL,
  `color` varchar(100) NOT NULL DEFAULT 'blue',
  `bio` varchar(1500) NOT NULL,
  `type` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `user`, `password`, `color`, `bio`, `type`) VALUES
(1, 'Henrique Dias', 'admin', 'ak00US9FRjFONXJHNi92c2pORUhvdz09', 'orange', '', 0),
(2, 'Henrique Dias', 'hacdias', 'ak00US9FRjFONXJHNi92c2pORUhvdz09', 'blue', '', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
