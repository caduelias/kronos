<?php

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "permissaoLogin.php" ) )
        include "permissaoLogin.php";
    else
        include "../permissaoLogin.php";

    include "config/funcoes.php";

	if ( isset ( $p[2] ) ) {
        $codigo = trim( $p[2] );
        
    //$codigo =  base64_decode($param);

    if ((empty($codigo) ) ) 
    {
        $titulo = "Erro";
        $mensagem = "Parâmetros inválidos!";
        $link = "listar/modalidade";
        errorLink($titulo, $mensagem, $link);
        exit;
    } 
    else 
    {
        $sql = "SELECT nome_modalidade, ativo FROM Modalidade WHERE codigo_modalidade = ?";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindParam(1,$codigo);
    }

    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $nome_modalidade = $dados->nome_modalidade;
    $ativo = $dados->ativo;
    
    if ($ativo == 1) 
    {
        $sql = "
        
        UPDATE Modalidade
		SET ativo = 0 
		WHERE codigo_modalidade = :codigo
        LIMIT 1
        
        ";
        
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo",$codigo);

        if ( $consulta->execute() )
        {
            $mensagem = "Status alterado!";
            $link = "listar/modalidade-inativo";
            sucessLink($titulo, $mensagem, $link);
        } 
        else 
        {
            $mensagem = "Não foi possível alterar o Status!";
            $link = "listar/modalidade";
            errorLink($titulo, $mensagem, $link);
		}
    
     } 
     else if ($ativo == 0) 
     {

		$sql = "
        
        UPDATE Modalidade
		SET ativo = 1 
		WHERE codigo_modalidade = :codigo
        LIMIT 1
        
        ";
        
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo",$codigo);

        if ( $consulta->execute() ) 
        {
            $mensagem = "Status alterado!";
            $link = "listar/modalidade";
            sucessLink($titulo, $mensagem, $link);
        } 
        else 
        {
            $mensagem = "Não foi possível alterar o Status!";
            $link = "listar/modalidade";
            errorLink($titulo, $mensagem, $link);
		}
    }
    

    } 
    else 
    {
        $mensagem = "Parâmetros Inválidos!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }