<?php

session_start();
if (!isset($_SESSION["Auth"])) {
    header("location: index.php");
    exit;
}
if (!isset($_POST["monto"]) || !isset($_POST["userId"])) {
    header("location: manager.php");
    exit;
}

require_once "config.php";
require_once "model/class_transaccion.php";
require_once "util.php";

$userId = $_POST["userId"];
$monto = floatval($_POST["monto"]);
$limite = intval(100000);

if ($monto <= 0 || $monto > $limite) {
    $_SESSION["error"] = "El monto debe ser mayor a 0 y no exceder de 100000 Bs.";
    header("location: deposito-new.php");
    exit;
}

$saldo = 0;
$file = fopen("data/user.txt", "r");
while( !feof($file)){
    $fila = fgets($file);
    $userArray = explode("|", trim($fila));
    if (isset($userArray[0]) && $userArray[0] == $userId){
        $saldo = isset($userArray[5]) ? floatval($userArray[5]) : 0;
        break;
    }
}
fclose($file);

$nuevoSaldo = $saldo + $monto;
if ($nuevoSaldo > 999999999){
    $_SESSION["error"] = "Depósito excede el límite.";
    header("location: deposito-new.php");
    exit;
}

ActualizarSaldo($userId, $nuevoSaldo);
GuardarTransaccion($userId, "deposito", $monto);

$_SESSION["saldo"] = $nuevoSaldo;
$_SESSION["ultimoDeposito"] = $monto;

header("location: deposito-result.php");

?>