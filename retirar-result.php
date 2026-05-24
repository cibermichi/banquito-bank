<?php

session_start();

require_once "config.php";
require_once "util.php";

$monto = isset($_SESSION["ultimoRetiro"]) ? $_SESSION["ultimoRetiro"] : 0;
$saldo = isset($_SESSION["saldo"]) ? $_SESSION["saldo"] : 0;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retiro Exitoso - <?php echo $appTitle; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/main.css" />
    <style>
        body { background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="bg-orange-500 px-6 py-6 flex justify-center">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
        
        <div class="p-6 text-center">
            <h2 class="text-xl font-bold text-slate-800 mb-2">¡Retiro Exitoso!</h2>
            <p class="text-slate-500 mb-6">Su transacción ha sido procesada correctamente</p>
            
            <div class="bg-orange-50 rounded-xl p-4 mb-4">
                <p class="text-sm text-orange-600 mb-1">Monto retirado</p>
                <p class="text-2xl font-bold text-orange-700">-<?php echo number_format(floatval($monto ?? 0), 2); ?> Bs.</p>
            </div>
            
            <div class="bg-slate-100 rounded-xl p-4 mb-6">
                <p class="text-sm text-slate-500 mb-1">Nuevo saldo</p>
                <p class="text-xl font-bold text-slate-700"><?php echo number_format(floatval($saldo ?? 0), 2); ?> Bs.</p>
            </div>
            
            <div class="flex gap-3">
                <a href="retirar-new.php" 
                    class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold py-3 px-4 rounded-lg transition duration-200">
                    Nuevo retiro
                </a>
                <a href="manager.php" 
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>