<?php

// conexion a la bd
require_once __DIR__ . '/../db.php';

// mensaje de error o de ok
$mensaje = "";

// grupo A: login, registro y productos
require __DIR__ . '/userController.php';
require __DIR__ . '/productoController.php';

// grupo B: presupuestos
require __DIR__ . '/presupuestoController.php';

// grupo C: facturas
require __DIR__ . '/facturaController.php';

// grupo D: proyectos
require __DIR__ . '/proyectoController.php';

// si ningun controller ha cargado una vista, la de inicio
require __DIR__ . '/../views/mainView.phtml';
