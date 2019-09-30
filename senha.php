<?php

$nova = "admin";

$senha = password_hash($nova, PASSWORD_DEFAULT); 

echo $senha;

?>