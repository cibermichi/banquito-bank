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
    <title><?php echo $appTitle; ?></title>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white"><?php echo $appTitle; ?></h1>
                    <p class="text-cyan-400 text-sm"><?php echo $appSubtitle ?></p>
                </div>
            </div>
        </div>
        
        <div class="p-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-2">Bienvenido</h2>
            <p class="text-slate-500 mb-6">Ingrese sus credenciales para acceder</p>
            
            <?php if(isset($_GET["registered"])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    Registro exitoso. Ahora puede iniciar sesión.
                </div>
            <?php endif; ?>
            
            <form action="autenticar.php" method="POST" class="space-y-5">
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
                
                <button type="submit" 
                    class="w-full bg-slate-800 hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                    <span>Ingresar</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </button>
            </form>
            
            <div class="mt-4 text-center">
                <a href="registrar.php" class="text-cyan-600 hover:text-cyan-700 font-medium text-sm">
                    ¿No tiene cuenta? Regístrese aquí
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