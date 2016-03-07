<?php
session_start();

unset($_SESSION['utilisateur']);
if (isset($_SERVER['HTTP_COOKIE'])) {
    unset($_COOKIE["resterConnId"]);
    setcookie("resterConnId", '', time()-3600);
}

$_SESSION["messages"][] = 1;
header('Location:../connexion.php');

?>