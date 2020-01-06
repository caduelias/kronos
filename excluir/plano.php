<?php 

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "permissaoAdmin.php" ) )
       include "permissaoAdmin.php";
    else
       include "../permissaoAdmin.php";

    include "config/funcoes.php";

	if ( isset ( $p[2] ) )
        $codigo = (int)$p[2];

    if (empty($codigo) ) {
        $titulo = "Plano não encontrado!";
        $mensagem = "Parâmetros inválidos";
        $link = "listar/plano";
        errorLink($titulo, $mensagem, $link);
        exit;
    } else {
        $sql = "SELECT nome_plano 
                FROM Plano p 
                INNER JOIN Mensalidade m on m.Plano_codigo_plano = p.codigo_plano
                WHERE p.codigo_plano = ? LIMIT 1;";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindParam(1,$codigo);

        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        $nome_plano = $dados->nome_plano;
    }

    if ($nome_plano) {
        $titulo = "Erro ao excluir!";
        $mensagem = "O plano está vinculado a uma mensalidade";
        $link = "listar/plano";
        errorLink($titulo, $mensagem, $link);
        exit;
    }
 
    $sql = "SELECT codigo_plano, status FROM Plano WHERE codigo_plano = ?";
    $consulta = $pdo->prepare( $sql );
    $consulta->bindParam(1,$codigo);

    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $status = $dados->status;
    $codigo_plano = $dados->codigo_plano;
    
    if ($status == "1") {
        $titulo = "Erro ao excluir";
        $mensagem = "O plano está ativo! Inative-o para realizar esta operação!";
        $link = "listar/plano";
        errorLink($titulo, $mensagem, $link);
    } else {
		$sql = "
            DELETE FROM Plano
            WHERE codigo_plano = :codigo_plano LIMIT 1;
        ";

		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo_plano",$codigo_plano);

        if ( $consulta->execute() ) {
            $titulo = "";
            $mensagem = "Registro excluido com sucesso!";
            $link = "listar/plano-inativo";
            sucessLink($titulo, $mensagem, $link);
        } else {
            $titulo = "";
            $mensagem = "Erro ao excluir registro!";
            $link = "listar/plano-inativo";
            errorLink($titulo, $mensagem, $link);
		}
    }
    