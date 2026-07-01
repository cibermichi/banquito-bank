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

require_once "db.php";

$userId = intval($_POST["userId"]);
$monto  = floatval($_POST["monto"]);

if ($monto <= 0 || $monto > 100000) {
    $_SESSION["error"] = "El monto debe ser mayor a 0 y no exceder de 100000 Bs.";
    header("location: deposito-new.php");
    exit;
}

$stmt = $pdo->prepare("SELECT saldo FROM usuarios WHERE id = :id");
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch();
$saldo = floatval($user['saldo']);

$nuevoSaldo = $saldo + $monto;

if ($nuevoSaldo > 999999999) {
    $_SESSION["error"] = "Depósito excede el límite.";
    header("location: deposito-new.php");
    exit;
}

$pdo->beginTransaction();
try {
    $pdo->prepare("UPDATE usuarios SET saldo = :saldo WHERE id = :id")
        ->execute([':saldo' => $nuevoSaldo, ':id' => $userId]);

    $pdo->prepare("INSERT INTO transacciones (usuario_id, tipo, monto, saldo_antes, saldo_despues)
                   VALUES (:uid, 'deposito', :monto, :antes, :despues)")
        ->execute([':uid' => $userId, ':monto' => $monto, ':antes' => $saldo, ':despues' => $nuevoSaldo]);

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION["error"] = "Error al procesar el depósito.";
    header("location: deposito-new.php");
    exit;
}

$_SESSION["saldo"]          = $nuevoSaldo;
$_SESSION["ultimoDeposito"] = $monto;
header("location: deposito-result.php");
exit;
?>