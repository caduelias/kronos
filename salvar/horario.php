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
  
        if ( empty( $periodo ) ) 
        {
            $titulo = "";
            $mensagem = "Selecione um período!";
            warning($titulo, $mensagem);
        } 
        else if ( empty( $horario_treino ) ) 
        {
            $titulo = "";
            $mensagem = "Informe um horário!";
            warning($titulo, $mensagem);
        } 
        
        //var_dump($_POST); 
        
        if ( empty ( $codigo_horario ) ) 
        {
            // SELECT BUSCANDO EXERCICIO COM O NOME EXERCICIO INFORMADO
            $sql = "SELECT codigo_horario FROM Horario WHERE horario_treino = ? AND periodo = ? LIMIT 1";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindParam(1,$horario_treino);
            $consulta->bindParam(2,$periodo);

        } 
        else 
        {
            // SELECT BUSCANDO EXERCICIO ONDE FOR DIFERENTE DO PRÓPIO EXERCICIO
            $sql = "SELECT codigo_horario FROM Horario WHERE horario_treino = ? AND periodo <> ? LIMIT 1";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindParam(1,$horario_treino);
            $consulta->bindParam(2,$periodo);

        }

        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if ( isset ( $dados->codigo_horario ) ) 
        {
            // ALERTA
            $titulo = "";
            $mensagem = "Este horário já foi registrado!";
            warning($titulo, $mensagem);
            exit;
        }
        
        // *****************START TRANSACTION************************
        $pdo->beginTransaction();

        if ( empty ( $codigo_horario ) ) 
        {
			// INSERT
			$sql = "
        
            INSERT INTO Horario
            (codigo_horario, periodo, horario_treino, limite)

            VALUES 

            (NULL, :periodo, :horario_treino, :limite);
            
            ";

            $consulta = $pdo->prepare( $sql );

            // Tabela Exercicio
            $consulta->bindValue(":periodo",$periodo);
            $consulta->bindValue(":horario_treino",$horario_treino);
            $consulta->bindValue(":limite",$limite);
            
        } 
        else 
        { 
            
			// UPDATE
            $sql = " 

            UPDATE Horario SET 
            codigo_horario = :codigo_horario,
            periodo = :periodo,
            horario_treino = :horario_treino,
            limite = :limite
        
            WHERE codigo_horario = :codigo_horario ;

            ";
            $consulta = $pdo->prepare( $sql );
            
            // Tabela Exercicio
            $consulta->bindValue(":codigo_horario",$codigo_horario);
            $consulta->bindValue(":periodo",$periodo);
            $consulta->bindValue(":horario_treino",$horario_treino);
            $consulta->bindValue(":limite",$limite);
		}

		
        if ( $consulta->execute() ) 
        {    
			// COMMIT
            $pdo->commit();
            
            // ALERTA
            $titulo = "";
            $mensagem = "Registro salvo com sucesso!";
            $link = "listar/horario";
			sucessLink($titulo, $mensagem, $link);

        } 
        else 
        {
            // ROLLBACK
            $pdo->rollBack();
            echo $consulta->errorInfo()[2];
            // ALERTA
            $titulo = "";
			$mensagem = "Erro ao salvar registro !";
            errorBack( $titulo, $mensagem );
            exit;
		}
       
    // !POST       
    } 
    else 
    {
        // ALERTA
        $titulo = "";
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }