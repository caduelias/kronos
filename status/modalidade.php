<?php

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "permissaoLogin.php" ) )
        include "permissaoLogin.php";
    else
        include "../permissaoLogin.php";

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
		SET status = 0 
		WHERE codigo_modalidade = :codigo
        LIMIT 1
        
        ";
        
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo",$codigo);

        if ( $consulta->execute() ) {
            $mensagem = "Status alterado!";
            $link = "listar/modalidade-inativo";
            sucessLink($titulo, $mensagem, $link);
        } else {
            $mensagem = "Não foi possível alterar o Status!";
            $link = "listar/modalidade";
            errorLink($titulo, $mensagem, $link);
		}
    
     } 
     
     if ($nome_modalidade && $status == "0") {

		$sql = "
        
        UPDATE Modalidade
		SET status = 1 
		WHERE codigo_modalidade = :codigo
        LIMIT 1
        
        ";
        
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo",$codigo);

        if ( $consulta->execute() ) {
            $mensagem = "Status alterado!";
            $link = "listar/modalidade";
            sucessLink($titulo, $mensagem, $link);
        } else {
            $mensagem = "Não foi possível alterar o Status!";
            $link = "listar/modalidade-inativo";
            errorLink($titulo, $mensagem, $link);
		}
    }
    
    } else {
        $mensagem = "Parâmetros Inválidos!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }