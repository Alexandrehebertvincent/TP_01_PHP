<?php
session_start();

unset($_SESSION['utilisateur']);

header('Location:Index.php');

?>