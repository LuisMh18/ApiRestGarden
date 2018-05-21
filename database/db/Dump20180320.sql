-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-03-2018 a las 19:37:28
-- Versión del servidor: 10.1.29-MariaDB
-- Versión de PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dallas_rewards`
--

CREATE DATABASE IF NOT EXISTS dallas_rewards;

USE dallas_rewards;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'luis_mh@outlook.es', '$2y$10$GXTteAORwo/6rLOGoMY1p.89ZJXw80zu2nUXJHXvA4dLQBu4/oaOa'),
(2, 'angel@live.com', '$2y$10$hHPbqhL6OsbNMAPPpGQNx.m.2MhIQ4ytCwJQ0ON.NbouJZ3iLgqBS'),
(3, 'roberto@gmail.com', '$2y$10$EbKZ.qSTmHmEXAW3MnP8cOTjZMz5Jvs0oG3FQYrOCkQTWsiWIzYpm');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;


CREATE TABLE reservations(
	`id` 	int(255) auto_increment not null,
	`user_id`	int(255) not null,
	`status`	tinyint(1),
	`msg` varchar(100),
	`cf`	varchar(100),
	`iata`  varchar(100),
	`cod_ciudad`	varchar(100),
	`hotel` varchar(100),
	`pasajero` varchar(100),
	`status_reservacion` varchar(100),
	`fecha_inicio`	varchar,
	`fecha_fin` varchar,
	`monto_reservacion` varchar(100),
	CONSTRAINT pk_tasks PRIMARY KEY(id),
	CONSTRAINT fk_reservations_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
