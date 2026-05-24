<?php

session_start();
if (!isset($_SESSION["Auth"])) {
    header("location: index.php");
    exit;
}
require_once "config.php";
require_once "model/class_transaccion.php";
require_once "util.php";

$userId = $_POST["userId"];
$monto = floatval($_POST["monto"]);

if ($monto <= 0) {
    $_SESSION["error"] = "El monto debe ser mayor a 0";
    header("location: retirar-new.php");
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

if ($saldo >= $monto) {
    $nuevoSaldo = $saldo - $monto;
    ActualizarSaldo($userId, $nuevoSaldo);
    GuardarTransaccion($userId, "retiro", $monto);
    $_SESSION["saldo"] = $nuevoSaldo;
    $_SESSION["ultimoRetiro"] = $monto;
    header("location: retirar-result.php");
} else {
    $_SESSION["error"] = "Saldo insuficiente. Saldo actual: " . number_format($saldo, 2) . " Bs.";
    header("location: retirar-new.php");
}

?>