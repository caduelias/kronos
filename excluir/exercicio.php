<?php 

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "verificaLogin.php" ) )
       include "verificaLogin.php";
    else
       include "../verificaLogin.php";

    include "config/funcoes.php";

	if ( isset ( $p[2] ) )
        $parametro = (int)$p[2];
        
    if ( empty($parametro) ) {
        $titulo = "Erro ao buscar exercício";
        $mensagem = "Parâmetros inválidos!";
        $link = "listar/exercicio";
        errorLink($titulo, $mensagem, $link);
        exit;
    } else {
        $sql = "SELECT codigo_exercicio FROM Exercicio WHERE codigo_exercicio = :codigo_exercicio LIMIT 1";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindValue(":codigo_exercicio",$parametro);
    }

    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $codigo_exercicio = $dados->codigo_exercicio ?? null;

    if ( isset($codigo_exercicio) ) {
        $sql = "
            DELETE FROM Exercicio 
            WHERE codigo_exercicio = :codigo_exercicio LIMIT 1
        ";

		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo_exercicio",$codigo_exercicio);

        if ( $consulta->execute() ) {
            $titulo = "";
            $mensagem = "Registro removido com sucesso!";
            $link = "listar/exercicio";
            sucessLink($titulo, $mensagem, $link);
        } else {
            $titulo = "";
            $mensagem = "Erro ao excluir registro!";
            $link = "listar/exercicio";
            errorLink($titulo, $mensagem, $link);
        }
        
    } else {
		$titulo = "Erro ao excluir";
        $mensagem = "Parâmetros inválidos!";
        $link = "listar/exercicio";
        errorLink($titulo, $mensagem, $link);
    }
    