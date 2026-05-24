<?php
class Cuentas{
    /** Atributos: son características propias del objeto **/
    public $id;

    public $usuario; 

    public $nombre; 
    public $tipo;
    public $saldo;

  
    

    function __construct($_id, $_usuario, $_nombre, $_tipo, $_saldo){
        $this->id = $_id;
        $this->usuario = $_usuario;
        $this->nombre = $_nombre;
        $this->tipo = $_tipo;
        $this->saldo = $_saldo;
        
    }    
}

?>