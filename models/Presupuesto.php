<?php

// Clase Presupuesto
class Presupuesto{
    private $id;
    // cliente del presupuesto
    private $idUsuario;
    private $nombreUsuario;
    private $idProyecto;
    private $fecha;
    // pendiente, aceptado o rechazado
    private $estado;
    private $total;

    public function __construct($id, $idUsuario, $nombreUsuario, $idProyecto, $fecha, $estado, $total){
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->nombreUsuario = $nombreUsuario;
        $this->idProyecto = $idProyecto;
        $this->fecha = $fecha;
        $this->estado = $estado;
        $this->total = $total;
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getIdUsuario(){
        return $this->idUsuario;
    }
    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }
    public function getNombreUsuario(){
        return $this->nombreUsuario;
    }
    public function setNombreUsuario($nombreUsuario){
        $this->nombreUsuario = $nombreUsuario;
    }
    public function getIdProyecto(){
        return $this->idProyecto;
    }
    public function setIdProyecto($idProyecto){
        $this->idProyecto = $idProyecto;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function setFecha($fecha){
        $this->fecha = $fecha;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function setEstado($estado){
        $this->estado = $estado;
    }
    public function getTotal(){
        return $this->total;
    }
    public function setTotal($total){
        $this->total = $total;
    }
}