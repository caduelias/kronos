<?php

    if ( ( session_status() != PHP_SESSION_ACTIVE ) or (( $_SESSION["user"]["perfil"] ) != "1") && (( $_SESSION["user"]["perfil"] ) != "2") ) {
       
        include "pages/404.php";
        
        exit;
    } 