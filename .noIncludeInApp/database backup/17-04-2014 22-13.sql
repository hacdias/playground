-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 17-Abr-2014 às 23:12
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
-- Estrutura da tabela `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `admins`
--

INSERT INTO `admins` (`id`, `name`, `user`, `pass`) VALUES
(1, 'Henrique Dias', 'teste', 'teste');

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
-- Estrutura da tabela `rail_html`
--

CREATE TABLE IF NOT EXISTS `rail_html` (
  `id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `rail_html`
--

INSERT INTO `rail_html` (`id`, `title`, `content`) VALUES
(1, 'O que é HTML?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas eget ultrices enim, id interdum ligula. Praesent fringilla bibendum iaculis. Cras turpis mauris, placerat vel lacus eget, malesuada congue odio. Donec eu enim varius, imperdiet est at, cursus lectus. Duis volutpat tincidunt tempor. Cras non nisl iaculis, convallis felis ut, aliquam nisi. Aliquam at auctor mauris. Donec faucibus adipiscing lacus, quis congue mauris vulputate in. Morbi vulputate lorem gravida sapien pharetra malesuada. Morbi lectus ipsum, auctor consectetur fermentum eu, pulvinar sed nulla.'),
(2, 'oi', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nulla orci, aliquet varius eros et, commodo ullamcorper tortor. Maecenas mattis pulvinar est, quis egestas neque ultrices et. Aenean tempus turpis id orci gravida sagittis. Nunc a porttitor dui. Morbi vestibulum vulputate ullamcorper. Pellentesque non suscipit ipsum, et congue mauris. Pellentesque ultricies ullamcorper ligula sed dictum.\r\n\r\nDonec pulvinar suscipit quam, quis eleifend purus molestie semper. Phasellus elementum pellentesque turpis eu mattis. Nunc iaculis, turpis non vestibulum mattis, diam orci euismod tellus, at tempus sem neque et libero. Sed mollis vel magna et faucibus. Suspendisse in hendrerit tortor, in malesuada tortor. Suspendisse molestie ultrices erat sed feugiat. Nullam felis nulla, tincidunt mollis interdum et, varius a tortor. Vivamus ac est rutrum, scelerisque lectus vel, eleifend lacus. Donec commodo volutpat nulla, in congue sapien aliquet hendrerit. Cras commodo consequat nibh vitae aliquam. Proin vestibulum a nibh vel mollis.');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `rail_list`
--

INSERT INTO `rail_list` (`id`, `title`, `description`, `image`, `color`) VALUES
(1, 'HTML', 'Começa com HTML para aprenderes os princípios básicos da Web!', 'html', 'orange'),
(2, 'CSS', 'Com HTML vem o CSS! Dá um visual às tuas páginas web com CSS!', 'css', 'green');

-- --------------------------------------------------------

--
-- Estrutura da tabela `userdata`
--

CREATE TABLE IF NOT EXISTS `userdata` (
  `user` varchar(100) NOT NULL,
  `favorites` text NOT NULL,
  `read_later` text NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `userdata`
--

INSERT INTO `userdata` (`user`, `favorites`, `read_later`) VALUES
('admin', '', ''),
('Teste', '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `user`, `password`, `type`) VALUES
(5, 'Teste', 'teste', '2e6f9b0d5885b6010f9167787445617f553a735f', 1),
(6, 'admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
