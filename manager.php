<?php 

session_start();
$username = "";
$usertype = "";
$userSaldo = 0;

if ( !isset($_SESSION["Auth"])){
    header("location: index.php");
}else{
    $auth = $_SESSION["Auth"];
    $userId = $auth;

    $file = fopen("data/user.txt", "r");
    
    while( !feof($file)){
        $fila = fgets($file);
        $userArray = explode("|", $fila);
        if (isset($userArray[0]) && $userArray[0] == $userId){
            $username = $userArray[3];
            $usertype = $userArray[4];
            $userSaldo = isset($userArray[5]) ? $userArray[5] : 0;
        }
    }

    fclose($file);
}



$menuItems = [];
switch($usertype){
    case 1:
        $menuItems = [
            ["title" => "Lista de cuentas", "icon" => "users", "href" => "cuentas.php", "color" => "blue"],
            ["title" => "Movimientos generales", "icon" => "history", "href" => "movimientos.php", "color" => "purple"],
            ["title" => "Cerrar Sesión", "icon" => "logout", "href" => "logout.php", "color" => "red"]
        ];
        break;
    case 2:
        $menuItems = [
            ["title" => "Depositar dinero", "icon" => "deposit", "href" => "deposito-new.php", "color" => "green"],
            ["title" => "Retirar dinero", "icon" => "withdraw", "href" => "retirar-new.php", "color" => "orange"],
            ["title" => "Consultar saldo", "icon" => "balance", "href" => "consulta.php", "color" => "cyan"],
            ["title" => "Cerrar Sesión", "icon" => "logout", "href" => "logout.php", "color" => "red"]
        ];
        break;
}

require_once "config.php";
require_once "model/class_transaccion.php";
require_once "util.php";

function getIcon($icon) {
    $icons = [
        "users" => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
        "history" => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        "logout" => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>',
        "deposit" => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>',
        "withdraw" => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>',
        "balance" => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>'
    ];
    return $icons[$icon] ?? '';
}

function getColorClasses($color) {
    $colors = [
        "blue" => "bg-blue-50 hover:bg-blue-100 text-blue-600 border-blue-200",
        "purple" => "bg-purple-50 hover:bg-purple-100 text-purple-600 border-purple-200",
        "red" => "bg-red-50 hover:bg-red-100 text-red-600 border-red-200",
        "green" => "bg-green-50 hover:bg-green-100 text-green-600 border-green-200",
        "orange" => "bg-orange-50 hover:bg-orange-100 text-orange-600 border-orange-200",
        "cyan" => "bg-cyan-50 hover:bg-cyan-100 text-cyan-600 border-cyan-200"
    ];
    return $colors[$color] ?? "bg-gray-50";
}
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
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mb-6">
        <div class="bg-slate-800 px-6 py-5">
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
        
        <div class="p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-1">Hola, <?php echo htmlspecialchars($username); ?>!</h2>
            <?php if($usertype == 2): ?>
            <p class="text-slate-500 text-sm mb-4">Saldo actual: <span class="font-bold text-green-600"><?php echo number_format(floatval($userSaldo ?? 0), 2); ?> Bs.</span></p>
            <?php endif; ?>
            
            <div class="space-y-3">
                <?php foreach($menuItems as $item): ?>
                <a href="<?php echo $item['href']; ?>" 
                   class="flex items-center gap-4 p-4 rounded-xl border <?php echo getColorClasses($item['color']); ?> transition duration-200 group">
                    <div class="group-hover:scale-110 transition duration-200">
                        <?php echo getIcon($item['icon']); ?>
                    </div>
                    <span class="font-medium"><?php echo $item['title']; ?></span>
                    <svg class="w-5 h-5 ml-auto text-slate-400 group-hover:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <p class="text-center text-slate-400 text-sm">
        Sesión activa
    </p>
</div>

</body>
</html>