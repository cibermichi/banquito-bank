<?php

session_start();

$user = trim($_POST["user"]);
$pass = trim($_POST["pass"]);
$pass_confirm = trim($_POST["pass_confirm"]);
$nombre = trim($_POST["nombre"]);

if ($pass !== $pass_confirm) {
    header("location: registrar.php?error=password");
    exit;
}

if (empty($user) || empty($pass) || empty($nombre)) {
    header("location: registrar.php?error=empty");
    exit;
}

$file = fopen("data/user.txt", "r");
$exists = false;

while(!feof($file)){
    $fila = fgets($file);
    $userArray = explode("|", trim($fila));
    
    if (count($userArray) >= 2 && $userArray[1] == $user){//verifica que el indice 0 no este vacio
        $exists = true;
        break;
    }
}
fclose($file);

if ($exists) {
    header("location: registrar.php?error=exists");
    exit;
}

$file = fopen("data/user.txt", "a");
$id = 1;
$fileRead = fopen("data/user.txt", "r");
while(!feof($fileRead)){
    $fila = fgets($fileRead);
    $userArray = explode("|", trim($fila));
    if (count($userArray) >= 1){
        $id = intval($userArray[0]) + 1;
    }
}
fclose($fileRead);

$newUser = $id . "|" . $user . "|" . $pass . "|" . $nombre . "|2|0\n";
fwrite($file, $newUser);
fclose($file);

header("location: index.php?registered=1");

?>
