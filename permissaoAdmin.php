<?php

    if ( ( session_status() != PHP_SESSION_ACTIVE ) or (( $_SESSION["admin"]["tipo"] ) != "admin") && (( $_SESSION["admin"]["tipo"] ) != "master") ) {
       
        include "pages/404.php";
        
        exit;
    } 