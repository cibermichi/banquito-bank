<?php

session_start();

$_SESSION["Auth"] = null;
unset($_SESSION["Auth"]);

header("location: index.php");

?>