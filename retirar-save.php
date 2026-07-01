<?php
session_start();
if (!isset($_SESSION["Auth"])) {
    header("location: index.php");
    exit;
}

require_once "db.php";

$userId = intval($_POST["userId"]);
$monto  = floatval($_POST["monto"]);

if ($monto <= 0) {
    $_SESSION["error"] = "El monto debe ser mayor a 0";
    header("location: retirar-new.php");
    exit;
}

$stmt = $pdo->prepare("SELECT saldo FROM usuarios WHERE id = :id");
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch();
$saldo = floatval($user['saldo']);

if ($saldo < $monto) {
    $_SESSION["error"] = "Saldo insuficiente. Saldo actual: " . number_format($saldo, 2) . " Bs.";
    header("location: retirar-new.php");
    exit;
}

$nuevoSaldo = $saldo - $monto;

$pdo->beginTransaction();
try {
    $pdo->prepare("UPDATE usuarios SET saldo = :saldo WHERE id = :id")
        ->execute([':saldo' => $nuevoSaldo, ':id' => $userId]);

    $pdo->prepare("INSERT INTO transacciones (usuario_id, tipo, monto, saldo_antes, saldo_despues)
                   VALUES (:uid, 'retiro', :monto, :antes, :despues)")
        ->execute([':uid' => $userId, ':monto' => $monto, ':antes' => $saldo, ':despues' => $nuevoSaldo]);

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION["error"] = "Error al procesar el retiro.";
    header("location: retirar-new.php");
    exit;
}

$_SESSION["saldo"]        = $nuevoSaldo;
$_SESSION["ultimoRetiro"] = $monto;
header("location: retirar-result.php");
exit;
?>