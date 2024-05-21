<?php
session_start();

$_SESSION = array(); //need to clear array

session_destroy();

header("Location: login.php");
exit;
?>
