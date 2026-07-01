<?php
session_start();
require_once "db.php";

$usuario  = trim($_POST["user"]);
$password = trim($_POST["pass"]);

if (empty($usuario) || empty($password)) {
    header("Location: index.php?error=Completa todos los campos");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
$stmt->execute([':usuario' => $usuario]);
$user = $stmt->fetch();

if (!$user || $user['password'] !== $password) {
    header("Location: index.php?error=Usuario o contraseña incorrectos");
    exit;
}

$_SESSION['Auth']    = true;
$_SESSION['id']      = $user['id'];
$_SESSION['usuario'] = $user['usuario'];
$_SESSION['nombre']  = $user['nombre'];
$_SESSION['tipo']    = intval($user['tipo']);
$_SESSION['saldo']   = $user['saldo'];

header("Location: manager.php");
exit;
?>