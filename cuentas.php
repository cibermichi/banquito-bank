<?php

session_start();

if (!isset($_SESSION["Auth"])) {
    header("location: index.php");
    exit;
}

if ($_SESSION["userType"] != 1) {
    header("location: manager.php");
    exit;
}

require_once "config.php";
require_once "util.php";
require_once "model/class_cuentas.php";


$usuarios = array();
$file = fopen("data/user.txt", "r");
while (!feof($file)) {
    $fila = fgets($file);
    if (trim($fila) == "") continue;
    $userArray = explode("|", trim($fila));
    /*$usuarios[] = array(
        "id"     => $userArray[0],
        "usuario"=> $userArray[1],
        "nombre" => $userArray[3],
        "tipo"   => $userArray[4],
        "saldo"  => isset($userArray[5]) ? $userArray[5] : 0
    );*/

   $usuarios[] = new Cuentas($userArray[0], $userArray[1], $userArray[3], $userArray[4], isset($userArray[5]) ? $userArray[5] : 0);
}
fclose($file);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuentas - <?php echo $appTitle; ?></title>
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
                    <div class="w-12 h-12 bg-blue-400 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white"><?php echo $appTitle; ?></h1>
                        <p class="text-blue-400 text-sm">Administración</p>
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
            <h2 class="text-xl font-bold text-slate-800 mb-4">Lista de Cuentas</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-3 px-2 text-sm font-semibold text-slate-600">ID</th>
                            <th class="text-left py-3 px-2 text-sm font-semibold text-slate-600">Usuario</th>
                            <th class="text-left py-3 px-2 text-sm font-semibold text-slate-600">Nombre</th>
                            <th class="text-center py-3 px-2 text-sm font-semibold text-slate-600">Tipo</th>
                            <th class="text-right py-3 px-2 text-sm font-semibold text-slate-600">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $u): ?>
                        <tr class="border-b border-slate-100 hover:bg-slate-50">
                            <td class="py-3 px-2 text-slate-500"><?php echo $u->id; ?></td>
                            <td class="py-3 px-2 text-slate-800 font-medium"><?php echo htmlspecialchars($u->usuario); ?></td>
                            <td class="py-3 px-2 text-slate-800"><?php echo htmlspecialchars($u->nombre); ?></td>
                            <td class="py-3 px-2 text-center">
                                <?php if($u->tipo == 1): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        Admin
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800">
                                        Cliente
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-2 text-right font-medium text-slate-700">
                                <?php echo number_format(floatval($u->saldo ?? 0), 2); ?> Bs.
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
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