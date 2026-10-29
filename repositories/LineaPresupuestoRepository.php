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
        $stmt->bind_param("i", $idPresupuesto);
        $stmt->execute();
        $lineas = array();
        $resultado = $stmt->get_result();
        while ($fila = $resultado->fetch_assoc()) {
            $lineas[] = new LineaPresupuesto($fila['id_linea'], $fila['id_presupuesto'], $fila['id_producto'], $fila['nombre'], $fila['cantidad'], $fila['precio']);
        }
        return $lineas;
    }

    public function save(LineaPresupuesto $linea){
        $stmt = $this->db->prepare("INSERT INTO linea_presupuesto (id_presupuesto, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)");
        $idPresupuesto = $linea->getIdPresupuesto();
        $idProducto = $linea->getIdProducto();
        $cantidad = $linea->getCantidad();
        $precio = $linea->getPrecio();
        $stmt->bind_param("iiid", $idPresupuesto, $idProducto, $cantidad, $precio);
        $stmt->execute();
    }

    public function delete($id){
        $stmt = $this->db->prepare("DELETE FROM linea_presupuesto WHERE id_linea = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

