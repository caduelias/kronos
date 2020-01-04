<?php

session_start();
// Encerrar sessão
unset($_SESSION["user"]);
// Redirecionar 
header("location: index.php");