<?php
session_start();

unset($_SESSION['utilisateur']);

header('Location:../connexion.php?erreur=1');

?>