<?php

require_once __DIR__ . '/vendor/autoload.php';
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";

    $url = trim ($_GET["parametro"] );

    $parametros = explode("/", $url);

    $html = $parametros[2];

    if (empty($html)) {
        $titulo = "Erro ao gerar documento";
        $mensagem = "Parâmetros inválidos";
        $link = "index.php";
        errorLink( $titulo, $mensagem, $link );
        exit;
    }
      
    echo "<div class='content-wrapper'> <iframe name='pdf' width='100%' height='500' src='http://172.17.0.1/kronos/pdf/documento.php?html=$html'></iframe></div>
    ";
        
    

   
   



