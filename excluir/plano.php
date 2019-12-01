<?php 

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "permissaoAdmin.php" ) )
       include "permissaoAdmin.php";
    else
       include "../permissaoAdmin.php";

    include "config/funcoes.php";

	if ( isset ( $p[2] ) )
        $codigo = (int)$p[2];
        
    //$codigo =  base64_decode($param);

    if (empty($codigo) ) 
    {
        $titulo = "";
        $mensagem = "Parâmetros inválidos!";
        $link = "listar/plano-inativo";
        errorLink($titulo, $mensagem, $link);
        exit;
    }
    else 
    {
        $sql = "SELECT codigo_plano, nome_plano, ativo FROM Plano WHERE codigo_plano = ?";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindParam(1,$codigo);
    }

    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $nome_plano = $dados->nome_plano;
    $ativo = $dados->ativo;
    $codigo_plano = $dados->codigo_plano;
    
    if ($ativo == 1)
    {
        $titulo = "Erro ao excluir";
        $mensagem = "O plano $nome_plano está ativo! Inative-o para realizar esta operação!";
        $link = "listar/plano";
        errorLink($titulo, $mensagem, $link);
    } 
    else 
    {
		$sql = "
            DELETE FROM Plano
            WHERE codigo_plano = :codigo_plano LIMIT 1;
        ";

		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo_plano",$codigo_plano);

        if ( $consulta->execute() ) 
        {
            $titulo = "";
            $mensagem = "Registro excluido com sucesso!";
            $link = "listar/plano-inativo";
            sucessLink($titulo, $mensagem, $link);
        } 
        else 
        {
            $titulo = "Erro ao excluir";
            $mensagem = "Não foi possível realizar esta operação!";
            $link = "listar/plano-inativo";
            errorLink($titulo, $mensagem, $link);
		}
    }
    