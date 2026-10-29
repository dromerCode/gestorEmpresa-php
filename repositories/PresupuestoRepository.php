<?php

require_once __DIR__ . '/../models/Presupuesto.php';

// Repositorio de presupuestos
class PresupuestoRepository{
    private mysqli $db;

    public function __construct(mysqli $db){
        $this->db = $db;
    }

    // todos los presupuestos con el nombre del cliente (empleado)
    public function findAll(){
        $resultado = $this->db->query("SELECT p.id_presupuesto, p.id_usuario, u.nombre, p.id_proyecto, p.fecha, p.estado, p.total
            FROM presupuesto p JOIN usuario u ON u.id_usuario = p.id_usuario
            ORDER BY p.fecha DESC");
        $presupuestos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $presupuestos[] = new Presupuesto($fila['id_presupuesto'], $fila['id_usuario'], $fila['nombre'], $fila['id_proyecto'], $fila['fecha'], $fila['estado'], $fila['total']);
        }
        return $presupuestos;
    }

    // los presupuestos de un cliente
    public function findByUsuario($idUsuario){
        $stmt = $this->db->prepare("SELECT p.id_presupuesto, p.id_usuario, u.nombre, p.id_proyecto, p.fecha, p.estado, p.total FROM presupuesto p JOIN usuario u ON u.id_usuario = p.id_usuario WHERE p.id_usuario = ? ORDER BY p.fecha DESC");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $presupuestos = array();
        $resultado = $stmt->get_result();
        while ($fila = $resultado->fetch_assoc()) {
            $presupuestos[] = new Presupuesto($fila['id_presupuesto'], $fila['id_usuario'], $fila['nombre'], $fila['id_proyecto'], $fila['fecha'], $fila['estado'], $fila['total']);
        }
        return $presupuestos;
    }

    // un presupuesto por su id (o null)
    public function findById($id){
        $stmt = $this->db->prepare("SELECT p.id_presupuesto, p.id_usuario, u.nombre, p.id_proyecto, p.fecha, p.estado, p.total FROM presupuesto p JOIN usuario u ON u.id_usuario = p.id_usuario WHERE p.id_presupuesto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $presupuesto = $resultado->fetch_assoc();
        if (!$presupuesto) {
            return null;
        }
        return new Presupuesto($presupuesto['id_presupuesto'], $presupuesto['id_usuario'], $presupuesto['nombre'], $presupuesto['id_proyecto'], $presupuesto['fecha'], $presupuesto['estado'], $presupuesto['total']);
    }

    public function save(Presupuesto $presupuesto){
        $stmt = $this->db->prepare("INSERT INTO presupuesto (id_usuario, id_proyecto, fecha) VALUES (?, ?, ?)");
        $idUsuario = $presupuesto->getIdUsuario();
        $idProyecto = $presupuesto->getIdProyecto();
        $fecha = $presupuesto->getFecha();
        $stmt->bind_param("iis", $idUsuario, $idProyecto, $fecha);
        $stmt->execute();
    }

    public function update(Presupuesto $presupuesto){
        $stmt = $this->db->prepare("UPDATE presupuesto SET id_usuario = ?, id_proyecto = ?, fecha = ? WHERE id_presupuesto = ?");
        $idUsuario = $presupuesto->getIdUsuario();
        $idProyecto = $presupuesto->getIdProyecto();
        $fecha = $presupuesto->getFecha();
        $id = $presupuesto->getId();
        $stmt->bind_param("iisi", $idUsuario, $idProyecto, $fecha, $id);
        $stmt->execute();
    }

    public function delete($id){
        $stmt = $this->db->prepare("DELETE FROM presupuesto WHERE id_presupuesto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function cambiarEstado($id, $estado){
        $stmt = $this->db->prepare("UPDATE presupuesto SET estado = ? WHERE id_presupuesto = ?");
        $stmt->bind_param("si", $estado, $id);
        $stmt->execute();
    }
    public function actualizarTotal($id){
        $stmt = $this->db->prepare("UPDATE presupuesto SET total = (SELECT COALESCE(SUM(cantidad * precio), 0) FROM linea_presupuesto WHERE id_presupuesto = ?) WHERE id_presupuesto = ?");
        $stmt->bind_param("ii", $id, $id);
        $stmt->execute();
    }
}