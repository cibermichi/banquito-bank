<?php

session_start();

$user = trim($_POST["user"]);
$pass = trim($_POST["pass"]);

$file = fopen("data/user.txt", "r");
$found = false;
$userId = "";
$userType = "";
$saldo = 0;

while( !feof($file) ){
    $fila = fgets($file);
    $userArray = explode("|", trim($fila));
    
    if (count($userArray) >= 5 && $userArray[1] == $user && $userArray[2] == $pass ){
        $found = true;
        $userId = $userArray[0];
        $userType = $userArray[4];
        $saldo = isset($userArray[5]) ? floatval($userArray[5]) : 0;
        break;
    }
}

fclose($file);

if ($found) {
    $_SESSION["Auth"] = $userId;
    $_SESSION["userType"] = $userType;
    $_SESSION["saldo"] = $saldo;
    header("location: manager.php");
    exit();
} else {
    header("location: index.php");
    exit();
}

?>