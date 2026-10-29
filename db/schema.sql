-- Base de datos del gestor de empresa

CREATE DATABASE IF NOT EXISTS gestor_empresa
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE gestor_empresa;

-- Usuarios (clientes y empleados)
CREATE TABLE usuario (
  id_usuario  INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre      VARCHAR(80)  NOT NULL,
  email       VARCHAR(120) NOT NULL UNIQUE,
  -- Hash de password_hash(), nunca la contraseña en texto plano
  contrasena  VARCHAR(255) NOT NULL,
  rol         ENUM('cliente', 'empleado') NOT NULL DEFAULT 'cliente',
  PRIMARY KEY (id_usuario)
);

-- Productos
CREATE TABLE producto (
  id_producto  INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre       VARCHAR(150) NOT NULL,
  descripcion  TEXT,
  precio       DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id_producto)
);

-- Proyectos de un cliente
CREATE TABLE proyecto (
  id_proyecto   INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario    INT UNSIGNED NOT NULL,
  nombre        VARCHAR(150) NOT NULL,
  descripcion   TEXT,
  fecha_inicio  DATE NOT NULL,
  estado        ENUM('pendiente', 'en curso', 'terminado') NOT NULL DEFAULT 'pendiente',
  PRIMARY KEY (id_proyecto),
  FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);

-- Presupuestos
CREATE TABLE presupuesto (
  id_presupuesto  INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario      INT UNSIGNED NOT NULL,
  -- UNIQUE: un proyecto solo puede tener un presupuesto
  id_proyecto     INT UNSIGNED UNIQUE,
  fecha           DATE NOT NULL,
  estado          ENUM('pendiente', 'aceptado', 'rechazado') NOT NULL DEFAULT 'pendiente',
  total           DECIMAL(10,2) NOT NULL DEFAULT 0,
  PRIMARY KEY (id_presupuesto),
  FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
  FOREIGN KEY (id_proyecto) REFERENCES proyecto(id_proyecto) ON DELETE SET NULL
);

-- Lineas de presupuesto
CREATE TABLE linea_presupuesto (
  id_linea        INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_presupuesto  INT UNSIGNED NOT NULL,
  id_producto     INT UNSIGNED NOT NULL,
  cantidad        INT UNSIGNED NOT NULL DEFAULT 1,
  -- precio del producto cuando se hizo la linea
  precio          DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id_linea),
  FOREIGN KEY (id_presupuesto) REFERENCES presupuesto(id_presupuesto) ON DELETE CASCADE,
  FOREIGN KEY (id_producto) REFERENCES producto(id_producto)
);

-- Facturas (pueden venir de un presupuesto o no)
CREATE TABLE factura (
  id_factura      INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario      INT UNSIGNED NOT NULL,
  -- UNIQUE: un presupuesto solo puede tener una factura
  id_presupuesto  INT UNSIGNED UNIQUE,
  fecha           DATE NOT NULL,
  estado          ENUM('pendiente', 'pagada') NOT NULL DEFAULT 'pendiente',
  total           DECIMAL(10,2) NOT NULL DEFAULT 0,
  PRIMARY KEY (id_factura),
  FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
  FOREIGN KEY (id_presupuesto) REFERENCES presupuesto(id_presupuesto) ON DELETE SET NULL
);

-- Lineas de factura
CREATE TABLE linea_factura (
  id_linea     INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_factura   INT UNSIGNED NOT NULL,
  id_producto  INT UNSIGNED NOT NULL,
  cantidad     INT UNSIGNED NOT NULL DEFAULT 1,
  precio       DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id_linea),
  FOREIGN KEY (id_factura) REFERENCES factura(id_factura) ON DELETE CASCADE,
  FOREIGN KEY (id_producto) REFERENCES producto(id_producto)
);
