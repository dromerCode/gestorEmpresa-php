<?php

require_once __DIR__ . '/../models/LineaPresupuesto.php';

class LineaPresupuestoRepository{
    private mysqli $db;

    public function __construct(mysqli $db){
        $this->db = $db;
    }

    public function findByPresupuesto($idPresupuesto){
        $stmt = $this->db->prepare("SELECT l.id_linea, l.id_presupuesto, l.id_producto, pr.nombre, l.cantidad, l.precio
            FROM linea_presupuesto l JOIN producto pr ON pr.id_producto = l.id_producto
            WHERE l.id_presupuesto = ?");
        $stmt->execute([$idPresupuesto]);
        $lineas = array();
        $resultado = $stmt->get_result();
        while ($fila = $resultado->fetch_assoc()) {
            $lineas[] = new LineaPresupuesto($fila['id_linea'], $fila['id_presupuesto'], $fila['id_producto'], $fila['nombre'], $fila['cantidad'], $fila['precio']);
        }
        return $lineas;
    }

    public function save(LineaPresupuesto $linea){
        $stmt = $this->db->prepare("INSERT INTO linea_presupuesto (id_presupuesto, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)");
        $stmt->execute([$linea->getIdPresupuesto(), $linea->getIdProducto(), $linea->getCantidad(), $linea->getPrecio()]);
    }

    public function delete($id, $idPresupuesto){
        $stmt = $this->db->prepare("DELETE FROM linea_presupuesto WHERE id_linea = ? AND id_presupuesto = ?");
        $stmt->execute([$id, $idPresupuesto]);
    }
}
