<?php
class LineaPresupuesto{
    private $id;
    private $idPresupuesto;
    private $idProducto;
    private $nombreProducto;
    private $cantidad;
    private $precio;
    
    public function __construct($id, $idPresupuesto, $idProducto, $nombreProducto, $cantidad, $precio){
        $this->id = $id;
        $this->idPresupuesto = $idPresupuesto;
        $this->idProducto = $idProducto;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
        $this->nombreProducto = $nombreProducto;
    }
    
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getIdPresupuesto(){
        return $this->idPresupuesto;
    }
    public function setIdPresupuesto($idPresupuesto){
        $this->idPresupuesto = $idPresupuesto;
    }
    public function getIdProducto(){
        return $this->idProducto;
    }
    public function setIdProducto($idProducto){
        $this->idProducto = $idProducto;
    }
    public function getNombreProducto(){
        return $this->nombreProducto;
    }
    public function setNombreProducto($nombreProducto){
        $this->nombreProducto = $nombreProducto;
    }
    public function getCantidad(){
        return $this->cantidad;
    }
    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }
    public function getPrecio(){
        return $this->precio;
    }
    public function setPrecio($precio){
        $this->precio = $precio;
    }
    public function getSubtotal(){
        return $this->cantidad * $this->precio;
    }
    
}