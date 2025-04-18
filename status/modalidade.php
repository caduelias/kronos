<?php

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "permissaoAdmin.php" ) )
        include "permissaoAdmin.php";
    else
        include "../permissaoAdmin.php";

    include "config/funcoes.php";

	if ( isset ( $p[2] ) ) {
        $codigo = trim( $p[2] );
        
    if ((empty($codigo) ) ) {
        $titulo = "Modalidade não encontrada!";
        $mensagem = "Parâmetros inválidos";
        $link = "listar/modalidade";
        errorLink($titulo, $mensagem, $link);
        exit;
    } else {
        $sql = "SELECT nome_modalidade, status FROM Modalidade WHERE codigo_modalidade = ?";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindParam(1,$codigo);
    }

    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $nome_modalidade = $dados->nome_modalidade;
    $status = $dados->status;
    
    if (!$nome_modalidade) {
        $titulo = "";
        $mensagem = "Modalidade não encontrada!";
        $link = "listar/modalidade";
        errorLink($titulo, $mensagem, $link);
        exit;
    }

    if ($nome_modalidade && $status == "1") {
        $sql = "
        
        UPDATE Modalidade
		SET status = 2 
		WHERE codigo_modalidade = :codigo
        LIMIT 1
        
        ";
        
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo",$codigo);

        if ( $consulta->execute() ) {
            $titulo = "";
            $mensagem = "Status alterado!";
            $link = "listar/modalidade-inativo";
            sucessLink($titulo, $mensagem, $link);
        } else {
            $titulo = "";
            $mensagem = "Não foi possível alterar o Status!";
            $link = "listar/modalidade";
            errorLink($titulo, $mensagem, $link);
		}
    
     } 
     
     if ($nome_modalidade && $status == "2") {

		$sql = "
        
        UPDATE Modalidade
		SET status = 1 
		WHERE codigo_modalidade = :codigo
        LIMIT 1
        
        ";
        
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo",$codigo);

        if ( $consulta->execute() ) {
            $titulo = "";
            $mensagem = "Status alterado!";
            $link = "listar/modalidade";
            sucessLink($titulo, $mensagem, $link);
        } else {
            $titulo = "";
            $mensagem = "Não foi possível alterar o Status!";
            $link = "listar/modalidade-inativo";
            errorLink($titulo, $mensagem, $link);
		}
    }
    
    } else {
        $titulo = "";
        $mensagem = "Parâmetros Inválidos!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }