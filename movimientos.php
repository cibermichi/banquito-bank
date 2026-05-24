<?php

session_start();

if (!isset($_SESSION["Auth"])) {
    header("location: index.php");
}

require_once "config.php";
require_once "util.php";
require_once "model/class_transaccion.php";

$usuarios = array();
$file = fopen("data/user.txt", "r");
while (!feof($file)) {
    $fila = fgets($file);
    if (trim($fila) == "") continue;
    $userArray = explode("|", trim($fila));
    $usuarios[$userArray[0]] = $userArray[3]; //array asociativo con id como clave y nombre como valor
}
fclose($file);

$transacciones = array();
if (file_exists("data/transacciones.txt")) {
    $file = fopen("data/transacciones.txt", "r");
    while (!feof($file)) {
        $fila = fgets($file);
        if (trim($fila) == "") continue;
        $t = explode("|", trim($fila));
        $nombreUsuario = isset($usuarios[$t[0]]) ? $usuarios[$t[0]] : "Desconocido";
        $transacciones[] = new Transaccion($nombreUsuario, $t[1], $t[2], $t[3]);
        ;
    }
    fclose($file);
    $transacciones = array_reverse($transacciones);
    //la ultima transaccion aparece primero
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos - <?php echo $appTitle; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/main.css" />
    <style>
        body { background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%); }
    </style>
</head>
<body class="min-h-screen p-4">

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="bg-slate-800 px-6 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-400 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white"><?php echo $appTitle; ?></h1>
                        <p class="text-purple-400 text-sm">Movimientos</p>
                    </div>
                </div>
                <a href="manager.php" class="text-slate-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>
        </div>
        
        <div class="p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Historial de Transacciones</h2>
            
            <?php if (count($transacciones) == 0): ?>
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-slate-500">No hay movimientos registrados aún.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-3 px-2 text-sm font-semibold text-slate-600">Cliente</th>
                                <th class="text-left py-3 px-2 text-sm font-semibold text-slate-600">Tipo</th>
                                <th class="text-right py-3 px-2 text-sm font-semibold text-slate-600">Monto</th>
                                <th class="text-left py-3 px-2 text-sm font-semibold text-slate-600">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transacciones as $t): ?>
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="py-3 px-2 text-slate-800"><?php echo htmlspecialchars($t->usuario); ?></td>
                                <td class="py-3 px-2">
                                    <?php if($t->tipo == "deposito"): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Depósito
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            Retiro
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-2 text-right font-medium <?php echo $t->tipo == 'deposito' ? 'text-green-600' : 'text-orange-600'; ?>">
                                    <?php echo $t->tipo == "deposito" ? "+" : "-"; ?><?php echo number_format(floatval($t->monto ?? 0), 2); ?> Bs.
                                </td>
                                <td class="py-3 px-2 text-slate-500 text-sm"><?php echo htmlspecialchars($t->fecha); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            
            <div class="mt-6">
                <a href="manager.php" 
                    class="inline-flex items-center text-slate-600 hover:text-slate-800 transition">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>