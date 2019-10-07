<?php

    include "config/funcoes.php";
	//iniciar as variaveis
	//recuperar as variaveis
	//$p[0] - excluir
	//$p[1] - quadrinho-personagem
	//$p[2] - id do quadrinho
	//$p[3] - id do personagem
	if ( isset ( $p[2] ) ) {
        $codigo_admin = trim( $p[2] );
        
	//verificar se algum esta em branco
	if ( empty ( $codigo_admin ) ) {
        $titulo = "Erro";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    } else {
        $sql = "SELECT nome, ativo FROM Admin WHERE codigo_admin = ?";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindParam(1,$codigo_admin);
    
    }

    //executar o sql
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $nome = $dados->nome;
    $ativo = $dados->ativo;
    
    if ($ativo == 1){
        $sql = "UPDATE Admin
		SET ativo = 0 
		WHERE codigo_admin = :codigo
		LIMIT 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo",$codigo_admin);

		if ( $consulta->execute() ){
            $mensagem = "Status do Usuário alterado para Inativo!";
            $link = "listar/admin";
            sucessLink($titulo, $mensagem, $link);
		} else {
            $mensagem = "Não foi possível alterar o Status do usuário";
            $link = "listar/admin";
            errorLink($titulo, $mensagem, $link);
		}
    
     } else if ($ativo == 0) {

		$sql = "UPDATE Admin
		SET ativo = 1 
		WHERE codigo_admin = :codigo
		LIMIT 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo",$codigo_admin);

		if ( $consulta->execute() ){
            $mensagem = "Status do Usuário alterado para Ativo!";
            $link = "listar/admin";
            sucessLink($titulo, $mensagem, $link);
		} else {
            $mensagem = "Não foi possível alterar o Status do usuário";
            $link = "listar/admin";
            errorLink($titulo, $mensagem, $link);
		}
    }
    
} else {
    $mensagem = "Parâmetros Inválidos!";
    $link = "listar/admin";
    errorLink($titulo, $mensagem, $link);
}