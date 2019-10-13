<?php 

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "permissaoAdmin.php" ) )
       include "permissaoAdmin.php";
    else
       include "../permissaoAdmin.php";

    include "config/funcoes.php";

    $codigo_admin = $_SESSION["admin"]["codigo_admin"];

	if ( isset ( $p[2] ) )
        $codigo = trim( $p[2] );
        
    //$codigo =  base64_decode($param);

    if ($codigo_admin == $codigo || (empty($codigo) ) ) 
    {
        $titulo = "Erro";
        $mensagem = "Parâmetros inválidos!";
        $link = "listar/inativo";
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
        $titulo = "Erro ao Excluir";
        $mensagem = "O usuário $nome está ativo! Inative-o para realizar esta operação!";
        $link = "listar/admin";
        errorLink($titulo, $mensagem, $link);
    } 
    else 
    {
		$sql = "
            DELETE a.*, e.* 
            FROM Admin a 
            LEFT JOIN Endereco e 
            ON a.codigo_admin = :codigo 
            WHERE a.Endereco_codigo_endereco = e.codigo_endereco;
        ";

		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo",$codigo);

        if ( $consulta->execute() ) 
        {
            $mensagem = "Usuário removido com Sucesso!";
            $link = "listar/inativo";
            sucessLink($titulo, $mensagem, $link);
        } 
        else 
        {
            $titulo = "Erro ao Excluir";
            $mensagem = "Não foi possível remover o usuário";
            $link = "listar/inativo";
            errorLink($titulo, $mensagem, $link);
		}
    }
    