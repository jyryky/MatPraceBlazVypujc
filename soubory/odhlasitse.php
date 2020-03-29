<?php
session_start();
unset($_SESSION["uzivatel"]);
header("Location: index.php");
?>