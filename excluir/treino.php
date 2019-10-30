<?php 

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "verificaLogin.php" ) )
       include "verificaLogin.php";
    else
       include "../verificaLogin.php";

    include "config/funcoes.php";


	if ( isset ( $p[2] ) )
        $parametro = (int)$p[2];
        
    //$codigo =  base64_decode($param);

    if ( empty($parametro) ) 
    {
        $titulo = "Erro";
        $mensagem = "Parâmetros inválidos!";
        $link = "listar/treino";
        errorLink($titulo, $mensagem, $link);
        exit;
    }
    else 
    {
        $sql = "SELECT t.codigo_treino, t.nome_treino from Treino as t, Exercicio as e, Treino_Modalidade as tm WHERE t.codigo_treino = :codigo_treino and t.codigo_treino = e.Treino_codigo_treino limit 1";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindValue(":codigo_treino",$codigo_treino);
    }

    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $codigo_treino = $dados->codigo_treino;

    if ( !isset ($codigo_treino) )
    {
        $sql = "
            DELETE FROM Horario 
            WHERE codigo_treino = :codigo_treino LIMIT 1
        ";

		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo_treino",$parametro);

        if ( $consulta->execute() ) 
        {
            $mensagem = "Registro removido com sucesso!";
            $link = "listar/treino";
            sucessLink($titulo, $mensagem, $link);
        } 
        else 
        {
            $titulo = "";
            $mensagem = "Erro ao excluir registro!";
            $link = "listar/treino";
            errorLink($titulo, $mensagem, $link);
        }
        
    } 
    else 
    {
		$titulo = "Erro ao excluir";
        $mensagem = "Existem alunos registrados neste horário!";
        $link = "listar/horario";
        errorLink($titulo, $mensagem, $link);
    }
    