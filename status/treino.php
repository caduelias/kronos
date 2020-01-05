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
        $sql = "SELECT t.codigo_treino from Treino as t, Exercicio as e, Treino_Modalidade as tm WHERE t.codigo_treino = :codigo_treino and tm.Treino_codigo_treino = t.codigo_treino and t.codigo_treino = e.Treino_codigo_treino limit 1";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindValue(":codigo_treino",$parametro);
    }

    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $codigo_treino = $dados->codigo_treino;

    if ( !isset ($codigo_treino) )
    {
        $sql = "SELECT codigo_treino, ativo from Treino where codigo_treino = :codigo_treino limit 1";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindValue(":codigo_treino",$parametro);
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        
        $codigo_treino = $dados->codigo_treino;
        $ativo = $dados->ativo;

        if ($ativo === '0')
        {
            $sql = "
        
            UPDATE Treino
            SET ativo = 1 
            WHERE codigo_treino = :codigo_treino
            LIMIT 1
            
            ";
            
            $consulta = $pdo->prepare($sql);
            $consulta->bindValue(":codigo_treino",$codigo_treino);
    
            if ( $consulta->execute() )
            {
                $mensagem = "Status alterado!";
                $link = "listar/treino";
                sucessLink($titulo, $mensagem, $link);
            } 
            else 
            {
                $mensagem = "Não foi possível alterar o Status!";
                $link = "listar/treino-inativo";
                errorLink($titulo, $mensagem, $link);
            }
        }
        else if ($ativo === '1')
        {
            $sql = "SELECT codigo_treino, ativo from Treino where codigo_treino = :codigo_treino limit 1";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindValue(":codigo_treino",$parametro);
            $consulta->execute();
            $dados = $consulta->fetch(PDO::FETCH_OBJ);
            
            $codigo_treino = $dados->codigo_treino;
            $ativo = $dados->ativo;

            $sql = "
        
            UPDATE Treino
            SET ativo = 0 
            WHERE codigo_treino = :codigo_treino
            LIMIT 1
            
            ";
            
            $consulta = $pdo->prepare($sql);
            $consulta->bindValue(":codigo_treino",$codigo_treino);
    
            if ( $consulta->execute() )
            {
                $mensagem = "Status alterado!";
                $link = "listar/treino-inativo";
                sucessLink($titulo, $mensagem, $link);
            } 
            else 
            {
                $mensagem = "Não foi possível alterar o Status!";
                $link = "listar/treino";
                errorLink($titulo, $mensagem, $link);
            }
        }
        else 
        {   
            $titulo = "Erro!";
            $mensagem = "Não foi possível alterar o Status!";
            errorBack($titulo, $mensagem);
        }

    } 
    else 
    {
		$titulo = "Erro";
        $mensagem = "Existem exercícios registrados neste treino!";
        $link = "listar/treino";
        errorLink($titulo, $mensagem, $link);
    }
    