<?php

    if ( ( session_status() != PHP_SESSION_ACTIVE ) or ( !isset ( $_SESSION["user"]["codigo_usuario"] ) ) ) {
       
        include "pages/404.php";

        exit;
    }   