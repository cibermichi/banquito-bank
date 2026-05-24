<?php

session_start();

if (!isset($_SESSION["Auth"])) {
    header("location: index.php");
}

require_once "config.php";
require_once "util.php";

$userId = $_SESSION["Auth"];
$saldo = 0;
$username = "";

$file = fopen("data/user.txt", "r");
while( !feof($file)){
    $fila = fgets($file);
    $userArray = explode("|", trim($fila));
    if (isset($userArray[0]) && $userArray[0] == $userId){
        $username = $userArray[3];
        $saldo = isset($userArray[5]) ? $userArray[5] : 0;
    }
}
fclose($file);

$_SESSION["saldo"] = $saldo;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Saldo - <?php echo $appTitle; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/main.css" />
    <style>
        body { background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="bg-slate-800 px-6 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-cyan-400 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white"><?php echo $appTitle; ?></h1>
                        <p class="text-cyan-400 text-sm">Consulta de Saldo</p>
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
            <h2 class="text-xl font-bold text-slate-800 mb-1">Hola, <?php echo htmlspecialchars($username); ?>!</h2>
            <p class="text-slate-500 mb-6">Esta es su información de cuenta</p>
            
            <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl p-6 mb-6 text-white">
                <p class="text-cyan-100 text-sm mb-1">Saldo disponible</p>
                <p class="text-4xl font-bold"><?php echo number_format(floatval($saldo ?? 0), 2); ?></p>
                <p class="text-cyan-200 text-sm mt-1">Bs.</p>
            </div>
            
            <div class="bg-slate-100 rounded-xl p-4 mb-6">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-500">Número de cuenta</span>
                    <span class="font-medium text-slate-700"><?php echo str_pad($userId, 6, '0', STR_PAD_LEFT); ?></span>
                </div>
            </div>
            
            <a href="manager.php" 
                class="block w-full bg-slate-800 hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 text-center">
                Volver al inicio
            </a>
        </div>
    </div>
</div>

</body>
</html>