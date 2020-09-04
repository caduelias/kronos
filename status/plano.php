<?php

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "permissaoAdmin.php" ) )
        include "permissaoAdmin.php";
    else
        include "../permissaoAdmin.php";

    include "config/funcoes.php";

	if ( isset ( $p[2] ) ) {
        $codigo = (int)$p[2];

    if (empty($codigo) ) {
        $titulo = "Plano não encontrado!";
        $mensagem = "Parâmetros inválidos";
        $link = "listar/plano";
        errorLink($titulo, $mensagem, $link);
        exit;
    } else {
        $sql = "SELECT codigo_plano, status FROM Plano WHERE codigo_plano = ?";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindParam(1,$codigo);
    }

    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $codigo_plano = $dados->codigo_plano;
    $status = $dados->status;
    
    if ($codigo_plano && $status == "1") {
        
        $sql = "
        UPDATE Plano
		SET status = 0 
		WHERE codigo_plano = :codigo_plano
        LIMIT 1
        ";
        
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo_plano",$codigo_plano);

        if ( $consulta->execute() ){
            $titulo = "";
            $mensagem = "Status alterado!";
            $link = "listar/plano-inativo";
            sucessLink($titulo, $mensagem, $link);
        } else {
            $titulo = "";
            $mensagem = "Não foi possível alterar o Status!";
            $link = "listar/plano";
            errorLink($titulo, $mensagem, $link);
		}
    
    } 
     
    if ($codigo_plano && $status == "0") {

		$sql = "
        UPDATE Plano
		SET status = 1 
		WHERE codigo_plano = :codigo_plano
        LIMIT 1
        ";
        
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo_plano",$codigo_plano);

        if ( $consulta->execute() ) {
            $titulo = "";
            $mensagem = "Status alterado!";
            $link = "listar/plano";
            sucessLink($titulo, $mensagem, $link);
        } else {
            $titulo = "";
            $mensagem = "Não foi possível alterar o Status!";
            $link = "listar/plano-inativo";
            errorLink($titulo, $mensagem, $link);
		}
    }
    
    } else {
        $titulo = "";
        $mensagem = "Parâmetros inválidos!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }