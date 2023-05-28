<?php
// Inicias la sesión
session_start();

// Destruyes todas las variables de sesión
$_SESSION = array();
session_destroy();

// Rediriges al usuario a index.php
header("Location: ../index.php");
exit;
?>
