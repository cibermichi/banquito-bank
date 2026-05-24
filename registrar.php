<?php
session_start();
if (isset($_SESSION["Auth"])){
    header("location: manager.php");
}
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - <?php echo $appTitle; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/main.css" />
    <style>
        body { background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="bg-slate-800 px-8 py-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-cyan-400 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white"><?php echo $appTitle; ?></h1>
                    <p class="text-cyan-400 text-sm"><?php echo $appSubtitle ?></p>
                </div>
            </div>
        </div>
        
        <div class="p-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-2">Crear Cuenta</h2>
            <p class="text-slate-500 mb-6">Ingrese sus datos para registrarse</p>
            
            <?php if(isset($_GET["error"])): ?>
                <?php if($_GET["error"] == "password"): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        Las contraseñas no coinciden
                    </div>
                <?php elseif($_GET["error"] == "exists"): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        El usuario ya existe
                    </div>
                <?php elseif($_GET["error"] == "empty"): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        Todos los campos son requeridos
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <form action="registrar-guardar.php" method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nombre Completo</label>
                    <input type="text" name="nombre" required 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 outline-none transition"
                        placeholder="Juan Pérez">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Usuario</label>
                    <input type="text" name="user" required 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 outline-none transition"
                        placeholder="Nombre de usuario">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Contraseña</label>
                    <input type="password" name="pass" required 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 outline-none transition"
                        placeholder="••••••••">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Confirmar Contraseña</label>
                    <input type="password" name="pass_confirm" required 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 outline-none transition"
                        placeholder="••••••••">
                </div>
                
                <button type="submit" 
                    class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                    <span>Registrarse</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
            </form>
            
            <div class="mt-4 text-center">
                <a href="index.php" class="text-cyan-600 hover:text-cyan-700 font-medium text-sm">
                    ¿Ya tiene cuenta? Ingrese aquí
                </a>
            </div>
        </div>
    </div>
    
    <p class="text-center text-slate-400 text-sm mt-4">
        Sistema Bancario v1.0
    </p>
</div>

</body>
</html>
