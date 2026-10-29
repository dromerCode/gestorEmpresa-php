-- Datos de prueba (contraseña de todos: 1234)

USE gestor_empresa;

INSERT INTO usuario (nombre, email, contrasena, rol) VALUES
  ('Empleado', 'empleado@empresa.test', '$2y$10$MhtVi.Vp98ciJFEtq3pOx.cWRgDedDh5nTI9qgLYR0.MPQgnyiLAm', 'empleado'),
  ('María García', 'maria@empresa.test', '$2y$10$MhtVi.Vp98ciJFEtq3pOx.cWRgDedDh5nTI9qgLYR0.MPQgnyiLAm', 'cliente'),
  ('Talleres López', 'lopez@empresa.test', '$2y$10$MhtVi.Vp98ciJFEtq3pOx.cWRgDedDh5nTI9qgLYR0.MPQgnyiLAm', 'cliente');

INSERT INTO producto (nombre, descripcion, precio) VALUES
  ('Diseño web', 'Diseño de una web corporativa', 600.00),
  ('Hosting anual', 'Alojamiento web durante un año', 80.00),
  ('Mantenimiento mensual', 'Actualizaciones y copias de seguridad', 40.00),
  ('Hora de consultoría', 'Hora de asesoramiento técnico', 35.00);

INSERT INTO proyecto (id_usuario, nombre, descripcion, fecha_inicio, estado) VALUES
  (3, 'Web de Talleres López', 'Web nueva con hosting', '2026-10-01', 'en curso'),
  (2, 'Consultoría María', 'Asesoramiento para su tienda online', '2026-10-15', 'pendiente');

INSERT INTO presupuesto (id_usuario, id_proyecto, fecha, estado, total) VALUES
  (3, 1, '2026-10-01', 'aceptado', 680.00),
  (2, 2, '2026-10-15', 'pendiente', 70.00);

INSERT INTO linea_presupuesto (id_presupuesto, id_producto, cantidad, precio) VALUES
  (1, 1, 1, 600.00),
  (1, 2, 1, 80.00),
  (2, 4, 2, 35.00);

INSERT INTO factura (id_usuario, id_presupuesto, fecha, estado, total) VALUES
  (3, 1, '2026-10-05', 'pagada', 680.00);

INSERT INTO linea_factura (id_factura, id_producto, cantidad, precio) VALUES
  (1, 1, 1, 600.00),
  (1, 2, 1, 80.00);
