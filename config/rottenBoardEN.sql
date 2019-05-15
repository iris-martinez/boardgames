-- noinspection SqlDialectInspectionForFile

-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 22-04-2019 a las 11:19:00
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rottenBoardEN`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Category`
--

CREATE TABLE `Category` (
  `id_category` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Category`
--

INSERT INTO `Category` (`id_category`, `name`) VALUES
(4, 'Abstracto'),
(33, 'Dummy'),
(2, 'Eurogame'),
(5, 'Filler'),
(1, 'New Catego'),
(3, 'Temático'),
(6, 'Wargame');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Game`
--

CREATE TABLE `Game` (
  `id_game` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `author` varchar(40) NOT NULL,
  `number_players` enum('1','2','3','4','+5') NOT NULL,
  `description` text NOT NULL,
  `duration` varchar(10) DEFAULT NULL,
  `image` varchar(20) DEFAULT NULL,
  `punctuation` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Game`
--

INSERT INTO `Game` (`id_game`, `name`, `author`, `number_players`, `description`, `duration`, `image`, `punctuation`, `id_category`, `id_user`) VALUES
(2, 'test', 'test', '4', 'Game chiquito que viene en una caja de aproximadamente 10 x 12.5 cm que lo hace perfecto para transportar, de unas mecánicas muy sencillas, con una duración de partidas rápidas de aproximadamente 20 a 30 minutos, con toques de deducción.', '20min', NULL, 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Role`
--

CREATE TABLE `Role` (
  `id_role` int(11) NOT NULL,
  `role` enum('USUARIO','ADMIN') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Role`
--

INSERT INTO `Role` (`id_role`, `role`) VALUES
(1, 'ADMIN'),
(2, 'USUARIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `User`
--

CREATE TABLE `User` (
  `id_user` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `surname` varchar(60) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `birth_date` date NOT NULL,
  `register_date` date NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_user_level` int(11) NOT NULL,
  `counter_punctuation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `User`
--

INSERT INTO `User` (`id_user`, `name`, `surname`, `email`, `password`, `birth_date`, `register_date`, `id_role`, `id_user_level`, `counter_punctuation`) VALUES
(1, 'admin1', 'admin admin', 'admin1@rotten.board', 'admin1', '1990-04-16', '2018-04-03', 1, 2, 100),
(2, 'admin2', 'admin2 admin2', 'admin2@rotten.board', 'admin2', '2000-03-04', '2017-03-10', 1, 3, 200),
(3, 'user1', 'user1 user1', 'user1@rotten.board', 'user1', '2000-12-01', '2019-03-04', 2, 1, 0),
(4, 'user2', 'user2 user2', 'user2@rotten.board', 'user2', '1978-09-11', '2018-12-19', 2, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UserCommentGame`
--

CREATE TABLE `UserCommentGame` (
  `id_comment` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_game` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `create_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `UserCommentGame`
--

INSERT INTO `UserCommentGame` (`id_comment`, `id_user`, `id_game`, `comment`, `create_date`) VALUES
(1, 3, 1, 'Game muy difícl de aprender y largo', '2019-04-02'),
(2, 4, 2, '¡Con ganas de volver a jugar!', '2019-04-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UserPunctuateGame`
--

CREATE TABLE `UserPunctuateGame` (
  `id_punctuatecion` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_game` int(11) NOT NULL,
  `punctuation` int(11) NOT NULL,
  `create_date` date NOT NULL,
  `id_user_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `UserPunctuateGame`
--

INSERT INTO `UserPunctuateGame` (`id_punctuatecion`, `id_user`, `id_game`, `punctuation`, `create_date`, `id_user_level`) VALUES
(1, 1, 1, 3, '2019-04-03', 2),
(2, 1, 2, 5, '2019-04-03', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `User_level`
--

CREATE TABLE `User_level` (
  `id_user_level` int(11) NOT NULL,
  `user_level` enum('Novato','Intermedio','Experto') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `User_level`
--

INSERT INTO `User_level` (`id_user_level`, `user_level`) VALUES
(1, 'Novato'),
(2, 'Intermedio'),
(3, 'Experto');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id_category`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `Game`
--
ALTER TABLE `Game`
  ADD PRIMARY KEY (`id_game`),
  ADD KEY `fk_Game_1_idx` (`id_category`);

--
-- Indices de la tabla `Role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indices de la tabla `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_User_1_idx` (`id_role`),
  ADD KEY `fk_User_2_idx` (`id_user_level`);

ALTER TABLE `User` ADD UNIQUE( `email`);
-- Indices de la tabla `UserCommentGame`
--
ALTER TABLE `UserCommentGame`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `fk_Comment_1_idx` (`id_user`),
  ADD KEY `fk_Comment_2_idx` (`id_game`);

--
-- Indices de la tabla `UserPunctuateGame`
--
ALTER TABLE `UserPunctuateGame`
  ADD PRIMARY KEY (`id_punctuatecion`),
  ADD KEY `fk_Punctuatecion_1_idx` (`id_user`),
  ADD KEY `fk_Punctuatecion_2_idx` (`id_game`);

--
-- Indices de la tabla `User_level`
--
ALTER TABLE `User_level`
  ADD PRIMARY KEY (`id_user_level`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Category`
--
ALTER TABLE `Category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `Game`
--
ALTER TABLE `Game`
  MODIFY `id_game` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `Game` ADD UNIQUE( `name`);

--
-- AUTO_INCREMENT de la tabla `Role`
--
ALTER TABLE `Role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `User`
--
ALTER TABLE `User`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `User`
    ADD CONSTRAINT `User_ibfk_1` FOREIGN KEY (`id_user_level`) REFERENCES `User_level` (`id_user_level`),
    ADD CONSTRAINT `User_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `Role` (`id_role`);
COMMIT;

--
-- AUTO_INCREMENT de la tabla `UserCommentGame`
--
ALTER TABLE `UserCommentGame`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `UserPunctuateGame`
--
ALTER TABLE `UserPunctuateGame`
  MODIFY `id_punctuatecion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `User_level`
--
ALTER TABLE `User_level`
  MODIFY `id_user_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
