<?php

/**
 * @author		Miguel Angel Macias Burgos
 * @company 	WBT
 * @copyright 	2026
 * @version     1.0
 */

function CreateCbo($_lista, $_nameCtl, $_colValue, $_colText){
    $opciones = "";
    foreach($_lista as $ele){ //agarra un elemento de la lista q le damos
        if ( is_array($ele) ){
            $opciones .= "<option value='". $ele[$_colValue] ."'>". $ele[$_colText] ."</option>";
            //selecciona ya sea el nombre o id del elemento
        }else if ( is_object($ele) ){
            $opciones .= "<option value='". $ele->$_colValue ."'>". $ele->$_colText ."</option>";
            //lo mismo pero usando poo
        }        
    }

    $control = "<select name='". $_nameCtl ."'>
        ". $opciones ."
    </select>";

    return $control;
}

function Filtrar($_lista, $_colName, $_colValue){
    $newList = array();

    foreach($_lista as $ele){
        if ( is_array($ele) ){
            if ( $ele[$_colName] == $_colValue ){ // se compara el colname con el colvalue
                $newList[] = $ele;
            }
        }else if ( is_object($ele)){
            if ( $ele->$_colName == $_colValue ){
                $newList[] = $ele;
            }
        }
        
    }

    return $newList; //retorna una lista
}

function Buscar($_lista, $_colName, $_colValue){
    $data = null;
    foreach($_lista as $ele){
        if ( is_array($ele) ){
            if ( $ele[$_colName] == $_colValue ){
                // encontrado
                $data = $ele;
                break;
            }
        }else if ( is_object($ele)){
            if ( $ele->$_colName == $_colValue ){
                // encontrado
                $data = $ele;
                break;
            }
        }
        
    }

    return $data; //retorna solo un dato
}




function ActualizarSaldo($_userId, $_nuevoSaldo) {
    $lineas = array();
    $file = fopen("data/user.txt", "r");
    while (!feof($file)) {
        $fila = fgets($file);
        if (trim($fila) == "") continue;//trim salta lineas vacias
        $userArray = explode("|", trim($fila));
        if ($userArray[0] == $_userId) {
            $userArray[5] = $_nuevoSaldo; // actualizar saldo
        }
        $lineas[] = implode("|", $userArray); // volver a unir con | con explode
    }
    fclose($file);

    // reescribir el archivo completo
    $file = fopen("data/user.txt", "w");
    foreach ($lineas as $linea) {
        fwrite($file, $linea . "\n");
    }
    fclose($file);
}

function GuardarTransaccion($_userId, $_tipo, $_monto) {
    $fecha = date("d/m/Y H:i:s");
    $linea = $_userId . "|" . $_tipo . "|" . $_monto . "|" . $fecha;
    $file = fopen("data/transacciones.txt", "a"); // "a" agrega al final sin borrar
    fwrite($file, $linea . "\n");
    fclose($file);
}

?>