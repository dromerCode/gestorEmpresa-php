# Gestor de empresa

Gestor de empresa en PHP + MariaDB: usuarios (clientes y empleados), productos, proyectos, presupuestos y facturas.

## Arrancar

1. Copia `.env.example` a `.env` y pon tus contraseñas.
2. `docker compose up -d` (crea la BD con `db/schema.sql` y `db/datos.sql`).
3. `php -S localhost:8000` y abre http://localhost:8000

Usuarios de prueba (contraseña `1234`): `empleado@empresa.test` (empleado), `maria@empresa.test` y `lopez@empresa.test` (clientes).

Si cambias el SQL, recrea la BD con `docker compose down -v` y `docker compose up -d`.

## Estructura

```
index.php                  entrada, llama a mainController
db.php                     conexion mysqli ($db)
controllers/               mainController + uno por grupo
models/                    clases (Usuario, Producto...)
repositories/              consultas a la BD (mysqli + prepare)
views/                     vistas .phtml
css/estilos.css
db/schema.sql, datos.sql
```

## Base de datos

```
usuario 1 ── N presupuesto 1 ── N linea_presupuesto N ── 1 producto
usuario 1 ── N factura     1 ── N linea_factura     N ── 1 producto
presupuesto 0..1 ── 1 factura
usuario 1 ── N proyecto 1 ── 0..1 presupuesto
```

Cada proyecto tiene como mucho un presupuesto, y su factura es la de ese presupuesto.

## Reparto

| Grupo | Parte | Controller |
|-------|-------|------------|
| A | Login, registro, roles y productos | `userController.php`, `productoController.php` |
| B | Presupuestos | `presupuestoController.php` |
| C | Facturas | `facturaController.php` |
| D | Proyectos | `proyectoController.php` |

Cada grupo hace su controller y sus modelos, repositorios y vistas. Los ficheros comunes (`index.php`, `db.php`, `mainController.php`, `header.phtml`, `db/`) no se cambian sin avisar.
