<?php

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "permissaoAdmin.php" ) )
        include "permissaoAdmin.php";
    else
        include "../permissaoAdmin.php";

    include "config/funcoes.php";

    $codigo_admin = $_SESSION["admin"]["codigo_admin"];

	if ( isset ( $p[2] ) ) {
        $codigo = trim( $p[2] );
        
    //$codigo =  base64_decode($param);

    if ($codigo_admin == $codigo || (empty($codigo) ) ) 
    {
        $titulo = "Erro";
        $mensagem = "Parâmetros inválidos!";
        $link = "listar/admin";
        errorLink($titulo, $mensagem, $link);
        exit;
    } 
    else 
    {
        $sql = "SELECT nome, ativo FROM Admin WHERE codigo_admin = ?";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindParam(1,$codigo);
    
    }

    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $nome = $dados->nome;
    $ativo = $dados->ativo;
    
    if ($ativo == 1) 
    {
        $sql = "UPDATE Admin
		SET ativo = 0 
		WHERE codigo_admin = :codigo
        LIMIT 1";
        
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo",$codigo);

        if ( $consulta->execute() )
        {
            $mensagem = "Status alterado para Inativo!";
            $link = "listar/admin";
            sucessLink($titulo, $mensagem, $link);
        } 
        else 
        {
            $mensagem = "Não foi possível alterar o Status do usuário";
            $link = "listar/admin";
            errorLink($titulo, $mensagem, $link);
		}
    
     } 
     else if ($ativo == 0) 
     {

		$sql = "UPDATE Admin
		SET ativo = 1 
		WHERE codigo_admin = :codigo
        LIMIT 1";
        
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo",$codigo);

        if ( $consulta->execute() ) 
        {
            $mensagem = "Status alterado para Ativo!";
            $link = "listar/admin";
            sucessLink($titulo, $mensagem, $link);
        } 
        else 
        {
            $mensagem = "Não foi possível alterar o Status do usuário";
            $link = "listar/admin";
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