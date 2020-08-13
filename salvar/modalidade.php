<?php
    
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
       include "verificaLogin.php";
    else
       include "../verificaLogin.php";

    include "config/funcoes.php";


    if ( $_POST ) {
        
        foreach ($_POST as $key => $value) {
            //$key - nome do campo
            //$value - valor do campo (digitado)
            if ( isset ( $_POST[$key] ) )
            {
                $$key = trim( $value );
            } 
        }
  
        if ( empty( $nome_modalidade ) ) {
            $titulo = "";
            $mensagem = "Preencha o nome!";
            warning($titulo, $mensagem);
        }  
        
        if ( empty ( $codigo_modalidade ) ) {
            // SELECT BUSCANDO LOGIN COM O LOGIN INFORMADO
            $sql = "SELECT codigo_modalidade FROM Modalidade WHERE nome_modalidade = ? LIMIT 1";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindParam(1,$nome_modalidade);

        } else {
            // SELECT BUSCANDO LOGIN ONDE FOR DIFERENTE DO PRÓPIO LOGIN
            $sql = "SELECT codigo_modalidade FROM Modalidade WHERE nome_modalidade = ? AND codigo_modalidade <> ? LIMIT 1";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindParam(1,$nome_modalidade);
            $consulta->bindParam(2,$codigo_modalidade);
        }

        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if ( isset ( $dados->codigo_modalidade ) ) {
            // ALERTA
            $titulo = "";
            $mensagem = "Essa modalidade já foi cadastrada!";
            warning($titulo, $mensagem);
            exit;
        }
        
        // *****************START TRANSACTION************************
        $pdo->beginTransaction();

        if ( empty ( $codigo_modalidade ) ) {
			// INSERT
			$sql = "
            
            INSERT INTO Modalidade
            (codigo_modalidade, Horario_codigo_horario, nome_modalidade, descricao, status)
            VALUES 
            (NULL, :codigo_horario, :nome_modalidade, :descricao, :status);
            
            ";

            $consulta = $pdo->prepare( $sql );

            // Tabela Modalidade
            $consulta->bindValue(":codigo_horario",$codigo_horario);
            $consulta->bindValue(":nome_modalidade",$nome_modalidade);
            $consulta->bindValue(":descricao",$descricao);
            $consulta->bindValue(":status",$status);

        } else { 
			// UPDATE
            $sql = "
            
            UPDATE Modalidade 
            
            SET Horario_codigo_horario = :codigo_horario,
            nome_modalidade = :nome_modalidade,
            descricao = :descricao,
            status = :status

            WHERE codigo_modalidade = :codigo_modalidade;
                
            ";

            $consulta =  $pdo->prepare($sql);

            // Tabela Modalidade
            $consulta->bindValue(":codigo_horario",$codigo_horario);
            $consulta->bindValue(":nome_modalidade",$nome_modalidade);
            $consulta->bindValue(":descricao",$descricao);
            $consulta->bindValue(":status",$status);
            $consulta->bindValue(":codigo_modalidade",$codigo_modalidade);
		}

        if ( $consulta->execute() ) {
			// COMMIT
            $pdo->commit();
            // ALERTA
            $titulo = "";
            $mensagem = "Registro salvo com sucesso!";
            $link = "listar/modalidade";
			sucessLink($titulo, $mensagem, $link);

        } else {
            // ROLLBACK
            $pdo->rollBack();
            //echo $consulta->errorInfo()[2];
            // ALERTA
            $titulo = "";
			$mensagem = "Erro ao salvar registro!";
            errorBack( $titulo, $mensagem );
            exit;
		}
         
    } else {
        // ALERTA
        $titulo = "";
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }