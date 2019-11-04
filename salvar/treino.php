<?php
    
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
       include "verificaLogin.php";
    else
       include "../verificaLogin.php";

    include "config/funcoes.php";


    if ( $_POST ) 
    {
        
        foreach ($_POST as $key => $value) 
        {
            //$key - nome do campo
            //$value - valor do campo (digitado)
            if ( isset ( $_POST[$key] ) )
            {
                $$key = trim( $value );
            } 
        }
  
        if ( empty( $nome_treino ) ) 
        {
            $mensagem = "Preencha o nome!";
            warning($titulo, $mensagem);
        } 
        else if ( empty( $codigo_modalidade ) ) 
        {
            $mensagem = "Selecione uma modalidade!";
            warning($titulo, $mensagem);
        } 
        
        //var_dump($_POST);
     

        if ( empty ( $codigo_treino ) ) 
        {
            // SELECT BUSCANDO TREINO COM O TREINO INFORMADO
            $sql = "SELECT t.codigo_treino FROM Treino as t, Treino_Modalidade as tm WHERE nome_treino = ? AND t.codigo_treino = tm.Treino_codigo_treino AND tm.Modalidade_codigo_modalidade = ? LIMIT 1 ";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindParam(1,$nome_treino);
            $consulta->bindParam(2,$codigo_modalidade);

        } 
        else 
        {
            // SELECT BUSCANDO TREINO ONDE FOR DIFERENTE DO PRÓPIO TREINO
            $sql = "

            SELECT t.codigo_treino FROM Treino t, Treino_Modalidade tm WHERE t.nome_treino = :nome AND t.codigo_treino <> :treino AND tm.Treino_codigo_treino <> t.codigo_treino AND tm.Modalidade_codigo_modalidade = :modalidade LIMIT 1
        
           " ;
            
            $consulta = $pdo->prepare( $sql );
            $consulta->bindValue(":nome",$nome_treino);
            $consulta->bindParam(":treino",$codigo_treino);
            $consulta->bindParam(":modalidade",$codigo_modalidade);

        }

        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if ( isset ( $dados->codigo_treino ) ) 
        {
            // ALERTA
            $mensagem = "Este treino já foi cadastrado nesta modalidade!";
            warning($titulo, $mensagem);
            exit;
        }
           
        
        // *****************START TRANSACTION************************
        $pdo->beginTransaction();

        if ( empty ( $codigo_treino ) ) 
        {
			// INSERT
			$sql = "
            
            SET AUTOCOMMIT=0;
            START TRANSACTION;
            
            INSERT INTO Treino
            (codigo_treino, nome_treino, descricao, tipo_treino, ativo)
            VALUES 
            (NULL, :nome_treino, :descricao, :tipo_treino, 1);

            INSERT INTO Treino_Modalidade 
			(Modalidade_codigo_modalidade, Treino_codigo_treino)
			VALUES 
            (:codigo_modalidade, (select LAST_INSERT_ID()));

            COMMIT;
            SET AUTOCOMMIT=1;
            
            ";

            $consulta = $pdo->prepare( $sql );

            // Tabela Treino
            $consulta->bindValue(":nome_treino",$nome_treino);
            $consulta->bindValue(":descricao",$descricao);
            $consulta->bindValue(":tipo_treino",$tipo_treino);

             // Tabela Treino_Modalidade
            $consulta->bindValue(":codigo_modalidade",$codigo_modalidade);

        } 
        else 
        { 
			// UPDATE
            $sql = "

            UPDATE Treino as t JOIN Treino_Modalidade as tm SET 

            t.nome_treino = :nome_treino,
            t.descricao = :descricao,
            t.tipo_treino = :tipo_treino,
               
            tm.Modalidade_codigo_modalidade = :codigo_modalidade,
            tm.Treino_codigo_treino = :codigo_treino

            WHERE t.codigo_treino = :codigo_treino 
            AND tm.Treino_codigo_treino = t.codigo_treino;
                
            ";

            $consulta =  $pdo->prepare($sql);

            // Tabela Treino
            $consulta->bindValue(":nome_treino",$nome_treino);
            $consulta->bindValue(":descricao",$descricao);
            $consulta->bindValue(":tipo_treino",$tipo_treino);

             // Tabela Treino_Modalidade
            $consulta->bindValue(":codigo_treino",$codigo_treino);
            $consulta->bindValue(":codigo_modalidade",$codigo_modalidade);

		}

		
        if ( $consulta->execute() ) 
        {
			// COMMIT
            $pdo->commit();
            // ALERTA
            $mensagem = "Registro salvo com sucesso!";
            $link = "listar/treino";
			sucessLink($titulo, $mensagem, $link);

        } 
        else 
        {
            // ROLLBACK
            $pdo->rollBack();
            //echo $consulta->errorInfo()[2];
            // ALERTA
			$mensagem = "Erro ao salvar registro!";
            errorBack( $titulo, $mensagem );
            exit;
		}
       
    // !POST       
    } 
    else 
    {
        // ALERTA
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }