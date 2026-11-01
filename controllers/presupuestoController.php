<?php
// grupo B: presupuestos y sus lineas
require_once __DIR__ . '/../repositories/PresupuestoRepository.php';
require_once __DIR__ . '/../repositories/LineaPresupuestoRepository.php';

$presupuestoRepository = new PresupuestoRepository($db);
$lineaPresupuestoRepository = new LineaPresupuestoRepository($db);

// $_SESSION['usuario'] lo guarda el login (grupo A)
$usuario = null;
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}

// ---------- listado, ver, estado y borrar (issue #7) ----------

// crear presupuesto (solo empleado)
if ($usuario && $usuario->esEmpleado() && isset($_POST['crear_presupuesto'])) {
    $presupuesto = new Presupuesto(null, $_POST['id_usuario'], null, null, $_POST['fecha'], null, 0);
    $id = $presupuestoRepository->save($presupuesto);
    header("Location: index.php?page=presupuesto&id=" . $id);
    exit;
}

// añadir linea (solo empleado)
if ($usuario && $usuario->esEmpleado() && isset($_POST['anadir_linea'])) {
    $idPresupuesto = $_GET['id'];
    $idProducto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    $stmt = $db->prepare("SELECT nombre, precio FROM producto WHERE id_producto = ?");
    $stmt->execute([$idProducto]);
    $producto = $stmt->get_result()->fetch_assoc();

    if ($producto) {
        $lineaPresupuestoRepository->save(new LineaPresupuesto(null, $idPresupuesto, $idProducto, $producto['nombre'], $cantidad, $producto['precio']));
        $presupuestoRepository->actualizarTotal($idPresupuesto);
    }

    header("Location: index.php?page=presupuesto&id=" . $idPresupuesto);
    exit;
}

// quitar linea (solo empleado)
if ($usuario && $usuario->esEmpleado() && isset($_POST['quitar_linea'])) {
    $idPresupuesto = $_GET['id'];
    $lineaPresupuestoRepository->delete((int) $_POST['id_linea'], $idPresupuesto);
    $presupuestoRepository->actualizarTotal($idPresupuesto);
    header("Location: index.php?page=presupuesto&id=" . $idPresupuesto);
    exit;
}

// cambiar estado (solo empleado)
if ($usuario && $usuario->esEmpleado() && isset($_POST['estado_presupuesto'])) {
    $id = (int) $_POST['estado_presupuesto'];
    $estado = $_POST['estado'];
    if (in_array($estado, array('pendiente', 'aceptado', 'rechazado'))) {
        $presupuestoRepository->cambiarEstado($id, $estado);
    }
    header("Location: index.php?page=presupuesto&id=" . $id);
    exit;
}

// borrar (solo empleado), las lineas se borran solas (ON DELETE CASCADE)
if ($usuario && $usuario->esEmpleado() && isset($_POST['borrar_presupuesto'])) {
    $presupuestoRepository->delete((int) $_POST['borrar_presupuesto']);
    header("Location: index.php?page=presupuestos");
    exit;
}

// vistas
// sin sesion no se ven presupuestos
if (!$usuario && isset($_GET['page']) && ($_GET['page'] == 'presupuestos' || $_GET['page'] == 'presupuesto')) {
    header("Location: index.php");
    exit;
}

// ?page=presupuesto&id= ver un presupuesto con sus lineas
if (isset($_GET['page']) && $_GET['page'] == 'presupuesto' && isset($_GET['id'])) {
    $presupuesto = $presupuestoRepository->findById((int) $_GET['id']);
    // el cliente solo puede ver los suyos
    if ($presupuesto && ($usuario->esEmpleado() || $presupuesto->getIdUsuario() == $usuario->getId())) {
        $lineas = $lineaPresupuestoRepository->findByPresupuesto($presupuesto->getId());
        if ($usuario->esEmpleado()) {
            $productos = $db->query("SELECT id_producto, nombre FROM producto")->fetch_all(MYSQLI_ASSOC);
        }
        require __DIR__ . '/../views/presupuestoView.phtml';
        exit;
    }
    header("Location: index.php?page=presupuestos");
    exit;
}

// ?page=presupuestos el empleado ve todos, el cliente solo los suyos
if (isset($_GET['page']) && $_GET['page'] == 'presupuestos') {
    if ($usuario->esEmpleado()) {
        $presupuestos = $presupuestoRepository->findAll();
        $clientes = $db->query("SELECT id_usuario, nombre FROM usuario WHERE rol = 'cliente'")->fetch_all(MYSQLI_ASSOC);
    } else {
        $presupuestos = $presupuestoRepository->findByUsuario($usuario->getId());
    }
    require __DIR__ . '/../views/presupuestosView.phtml';
    exit;
}
