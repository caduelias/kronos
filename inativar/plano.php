<?php

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "permissaoAdmin.php" ) )
        include "permissaoAdmin.php";
    else
        include "../permissaoAdmin.php";

    include "config/funcoes.php";

	if ( isset ( $p[2] ) ) {
        $codigo = (int)$p[2];

    if (empty($codigo) ) 
    {
        $titulo = "";
        $mensagem = "Parâmetros inválidos!";
        $link = "listar/plano";
        errorLink($titulo, $mensagem, $link);
        exit;
    } 
    else 
    {
        $sql = "SELECT codigo_plano, ativo FROM Plano WHERE codigo_plano = ?";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindParam(1,$codigo);
    }

    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $codigo_plano = $dados->codigo_plano;
    $ativo = $dados->ativo;
    
    if ($ativo == 1) 
    {
        $sql = "
        
        UPDATE Plano
		SET ativo = 0 
		WHERE codigo_plano = :codigo_plano
        LIMIT 1
        
        ";
        
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo_plano",$codigo_plano);

        if ( $consulta->execute() )
        {
            $mensagem = "Status alterado!";
            $link = "listar/plano-inativo";
            sucessLink($titulo, $mensagem, $link);
        } 
        else 
        {
            $mensagem = "Não foi possível alterar o Status!";
            $link = "listar/plano";
            errorLink($titulo, $mensagem, $link);
		}
    
     } 
     else if ($ativo == 0) 
     {

		$sql = "
        
        UPDATE Plano
		SET ativo = 1 
		WHERE codigo_plano = :codigo_plano
        LIMIT 1
        
        ";
        
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo_plano",$codigo_plano);

        if ( $consulta->execute() ) 
        {
            $mensagem = "Status alterado!";
            $link = "listar/plano";
            sucessLink($titulo, $mensagem, $link);
        } 
        else 
        {
            $mensagem = "Não foi possível alterar o Status!";
            $link = "listar/plano";
            errorLink($titulo, $mensagem, $link);
		}
    }
    

    } 
    else 
    {
        $mensagem = "Parâmetros inválidos!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }