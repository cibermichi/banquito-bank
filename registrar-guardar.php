<?php
session_start();

$username     = trim($_POST["usuario"]);
$pass         = trim($_POST["pass"]);
$pass_confirm = trim($_POST["pass_confirm"]);
$nombre       = trim($_POST["nombre"]);

if (empty($username) || empty($pass) || empty($nombre)) {
    header("location: registrar.php?error=empty");
    exit;
}

if ($pass !== $pass_confirm) {
    header("location: registrar.php?error=password");
    exit;
}

require_once "db.php";

$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = :usuario");
$stmt->execute([':usuario' => $username]);
if ($stmt->fetch()) {
    header("location: registrar.php?error=exists");
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO usuarios (usuario, password, nombre, tipo, saldo)
    VALUES (:usuario, :password, :nombre, 2, 0.00)
");
$stmt->execute([
    ':usuario'  => $username,
    ':password' => $pass,
    ':nombre'   => $nombre
]);

header("location: index.php?registered=1");
exit;
?>