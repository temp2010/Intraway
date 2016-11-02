SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Base de datos: status

CREATE DATABASE status;
USE status;

-- Estructura de tabla para la tabla status
CREATE TABLE status (
  id int(11) NOT NULL,
  email varchar(128) DEFAULT NULL,
  create_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  status varchar(120) NOT NULL
) ENGINE=InnoDB;

-- Indices de la tabla status
ALTER TABLE status
  ADD PRIMARY KEY (id);

-- AUTO_INCREMENT de la tabla status
ALTER TABLE status
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;