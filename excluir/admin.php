<?php 

    include "config/funcoes.php";
	//iniciar as variaveis
	//recuperar as variaveis
	//$p[0] - excluir
	//$p[1] - quadrinho-personagem
	//$p[2] - id do quadrinho
	//$p[3] - id do personagem
	if ( isset ( $p[2] ) )
        $codigo_admin = trim( $p[2] );
        
        echo $codigo_admin;

	//verificar se algum esta em branco
	if ( ( empty ( $codigo_admin ) ) ) {
        $titulo = "Erro";
        $mensagem = "Parâmetros inválidos";
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
        $titulo = "Erro ao Excluir";
        $mensagem = "O usuário $nome está ativo! Inative para realizar esta operação!";
        $link = "listar/admin";
        errorLink($titulo, $mensagem, $link);
    
     } else {

		$sql = "DELETE FROM Admin
		WHERE codigo_admin = :codigo 
		AND nome = :nome
		LIMIT 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo",$codigo_admin);
        $consulta->bindValue(":nome",$nome);

		if ( $consulta->execute() ){
            $mensagem = "Usuário removido com Sucesso!";
            $link = "listar/lista-inativo";
            sucessLink($titulo, $mensagem, $link);
		} else {
            $titulo = "Erro ao Excluir";
            $mensagem = "Não foi possível remover o usuário";
            $link = "listar/lista-inativo";
            errorLink($titulo, $mensagem, $link);
		}
	}