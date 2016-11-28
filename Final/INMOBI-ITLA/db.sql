CREATE DATABASE `final_web`;
USE `final_web`;

CREATE TABLE `usuario`(
`id_usuario` INT AUTO_INCREMENT NOT NULL,
`cedula` VARCHAR(13) NOT NULL UNIQUE,
`tipo` INT(1) NOT NULL, /* 1 normal 2 admin*/
`clave` VARCHAR(50) NOT NULL,
`correo` VARCHAR(30) NOT NULL UNIQUE,
`nombre` VARCHAR(30) NOT NULL,
`apellido` VARCHAR(30) NOT NULL,
`telefono` VARCHAR(15),
`celular` VARCHAR(15),
`fax` VARCHAR(30),
`mas_info` VARCHAR(250),
PRIMARY KEY(`id_usuario`)
);

CREATE TABLE `accion_dato`(
`id_accion` INT AUTO_INCREMENT NOT NULL,
`nombre_accion` VARCHAR(25) NOT NULL,
PRIMARY KEY(`id_accion`)
);

CREATE TABLE `tipo_inmueble`(
`id_tipo` INT AUTO_INCREMENT NOT NULL,
`nombre` VARCHAR(25) NOT NULL,
PRIMARY KEY(`id_tipo`)
);

CREATE TABLE `anuncio`(
`id_anuncio` INT AUTO_INCREMENT NOT NULL,
`titulo` VARCHAR(25) NOT NULL,
`direccion` VARCHAR(150) NOT NULL,
`fk_tipo` INT NOT NULL,
`precio` DECIMAL(13,2) NOT NULL,
`fk_accion` INT NOT NULL,
`descripcion` VARCHAR(250),
`latitud` VARCHAR(150) NOT NULL,
`longitud` VARCHAR(150) NOT NULL,
`estado` INT(1) NOT NULL, /* 1 activo, 2 desactivo */
`fecha` DATETIME NOT NULL,
`fk_creador` INT NOT NULL,
	PRIMARY KEY(`id_anuncio`),
	CONSTRAINT `publicaciones_user_tipo_accion` FOREIGN KEY(`fk_creador`)
	REFERENCES `usuario`(`id_usuario`),
	FOREIGN KEY(`fk_tipo`)
	REFERENCES `tipo_inmueble`(`id_tipo`),
	FOREIGN KEY(`fk_accion`)
	REFERENCES `accion_dato`(`id_accion`)
	ON DELETE CASCADE
);

INSERT INTO `usuario` (`id_usuario`, `cedula`, `tipo`, `clave`, `correo`, `nombre`, `apellido`, `telefono`, `celular`, `fax`, `mas_info`) VALUES (NULL, '111-1111111-1', '2', '123', 'admin', 'Admin', 'admin', NULL, NULL, NULL, NULL);