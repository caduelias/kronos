<?php

session_start();
// Encerrar sessão
unset($_SESSION["admin"]);
// Redirecionar 
header("location: index.php");