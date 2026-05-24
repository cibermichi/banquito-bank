<?php

session_start();
$userId = $_SESSION["Auth"];

require_once "config.php";
require_once "model/class_transaccion.php";
require_once "util.php";


$error = "";
if ( isset($_SESSION["error"]) ){
    $error = $_SESSION["error"];
    unset($_SESSION["error"]);
}

$saldo = 0;
$file = fopen("data/user.txt", "r");
while( !feof($file)){
    $fila = fgets($file);
    $userArray = explode("|", trim($fila));
    if (isset($userArray[0]) && $userArray[0] == $userId){
        $saldo = isset($userArray[5]) ? $userArray[5] : 0;
    }
}
fclose($file);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retirar - <?php echo $appTitle; ?></title>
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
                    <div class="w-12 h-12 bg-orange-400 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white"><?php echo $appTitle; ?></h1>
                        <p class="text-orange-400 text-sm">Retiro</p>
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
            <div class="bg-slate-100 rounded-xl p-3 mb-5 flex justify-between items-center">
                <span class="text-slate-600 text-sm">Saldo disponible</span>
                <span class="font-bold text-slate-800"><?php echo number_format(floatval($saldo ?? 0), 2); ?> Bs.</span>
            </div>
            
            <h2 class="text-xl font-bold text-slate-800 mb-2">Nuevo Retiro</h2>
            <p class="text-slate-500 mb-6">Ingrese el monto a retirar de su cuenta</p>
            
            <?php if ($error != ""): ?>
            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                <p class="text-red-600 text-sm"><?php echo htmlspecialchars($error); ?></p>
            </div>
            <?php endif; ?>
            
            <form action="retirar-save.php" method="POST">
                <input type="hidden" name="userId" value="<?php echo $userId; ?>" />
                
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Monto (Bs.)</label>
                    <input type="number" name="monto" id="monto" required min="0.01" step="0.01" max="<?php echo $saldo; ?>"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition"
                        placeholder="0.00">
                </div>
                
                <div class="flex gap-3">
                    <a href="manager.php" 
                        class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold py-3 px-4 rounded-lg transition duration-200 text-center">
                        Cancelar
                    </a>
                    <button type="submit" 
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                        Retirar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>