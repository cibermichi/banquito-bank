<?php
require_once "db.php";
$stmt = $pdo->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll();
foreach ($usuarios as $u) {
    echo $u['nombre'] . " - Saldo: " . $u['saldo'] . "<br>";
}
?>