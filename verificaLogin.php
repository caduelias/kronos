<?php

    if ( ( session_status() != PHP_SESSION_ACTIVE ) or ( !isset ( $_SESSION["admin"]["codigo_admin"] ) ) ) {
       
        include "pages/500.php";

        exit;
    }   