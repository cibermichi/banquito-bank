<?php

/**
 * @author		Miguel Angel Macias Burgos
 * @company 	WBT
 * @copyright 	2026
 * @version     1.0
 */

class Transaccion{
    /** Atributos: son características propias del objeto **/
    public $usuario;
    public $tipo;
    public $monto;

    public $fecha;
    

    function __construct($_usuario, $_tipo, $_monto, $_fecha){
        $this->usuario = $_usuario;
        $this->tipo = $_tipo;
        $this->monto = $_monto;
        $this->fecha = $_fecha;
    }    
}

?>