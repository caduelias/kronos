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
            if ( isset ( $_POST[$key] ) ) {
                $$key = trim( $value );
            } 
        }
  
        if ( empty( $nome_exercicio ) ) {
            $mensagem = "Preencha o nome!";
            warning($titulo, $mensagem);
        } else if ( empty( $tipo_exercicio ) ) {
            $mensagem = "Selecione um tipo!";
            warning($titulo, $mensagem);
        } else if ( empty( $codigo_treino ) ) {
            $mensagem = "Selecione um treino!";
            warning($titulo, $mensagem);
        }
        
        if ( empty ( $codigo_exercicio ) ) {
            // SELECT BUSCANDO EXERCICIO COM O NOME EXERCICIO INFORMADO
            $sql = "SELECT codigo_exercicio FROM Exercicio WHERE nome_exercicio = ? AND Treino_codigo_treino = ? LIMIT 1";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindParam(1,$nome_exercicio);
            $consulta->bindParam(2,$codigo_treino);

        } else {
            // SELECT BUSCANDO EXERCICIO ONDE FOR DIFERENTE DO PRÓPIO EXERCICIO
            $sql = "SELECT codigo_exercicio FROM Exercicio WHERE nome_exercicio = ? AND Treino_codigo_treino = ? AND codigo_exercicio <> ? LIMIT 1";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindParam(1,$nome_exercicio);
            $consulta->bindParam(2,$codigo_treino);
            $consulta->bindParam(3,$codigo_exercicio);
        }

        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if ( isset ( $dados->codigo_exercicio ) ) {
            // ALERTA
            $mensagem = "Este exercício já foi cadastrado nesta modalidade!";
            warning($titulo, $mensagem);
            exit;
        }
        
        $arquivo = time();
      
        // *****************START TRANSACTION************************
        $pdo->beginTransaction();

        if ( empty ( $codigo_exercicio ) ) {
           
			// INSERT
			$sql = "
        
            INSERT INTO Exercicio
            (codigo_exercicio, Treino_codigo_treino, tipo_exercicio, nome_exercicio, serie_repeticao,
            arquivo, descricao, duracao, peso_inicial)

            VALUES 

            (NULL, :codigo_treino, :tipo_exercicio, :nome_exercicio, :serie_repeticao, :arquivo, :descricao,
            :duracao, :peso_inicial);
            
            ";

            $consulta = $pdo->prepare( $sql );

            // Tabela Exercicio
            $consulta->bindValue(":codigo_treino",$codigo_treino);
            $consulta->bindValue(":tipo_exercicio",$tipo_exercicio);
            $consulta->bindValue(":nome_exercicio",$nome_exercicio);
            $consulta->bindValue(":serie_repeticao",$serie_repeticao);
            $consulta->bindValue(":arquivo",$arquivo);
            $consulta->bindValue(":descricao",$descricao);
            $consulta->bindValue(":duracao",$duracao);
            $consulta->bindValue(":peso_inicial",$peso_inicial);
            
        } else { 
            
			// UPDATE
            $sql = " 

            UPDATE Exercicio SET codigo_exercicio = :codigo_exercicio,
            Treino_codigo_treino = :codigo_treino,
            tipo_exercicio = :tipo_exercicio,
            nome_exercicio = :nome_exercicio,
            serie_repeticao = :serie_repeticao,
            descricao = :descricao,
            duracao = :duracao,
            peso_inicial = :peso_inicial

            WHERE codigo_exercicio = :codigo_exercicio ;

            ";
            $consulta = $pdo->prepare( $sql );
            
            // Tabela Exercicio
            $consulta->bindValue(":codigo_treino",$codigo_treino);
            $consulta->bindValue(":tipo_exercicio",$tipo_exercicio);
            $consulta->bindValue(":nome_exercicio",$nome_exercicio);
            $consulta->bindValue(":serie_repeticao",$serie_repeticao);
            $consulta->bindValue(":descricao",$descricao);
            $consulta->bindValue(":duracao",$duracao);
            $consulta->bindValue(":peso_inicial",$peso_inicial);
            $consulta->bindValue(":codigo_exercicio",$codigo_exercicio);

		}
		
        if ( $consulta->execute() ) {
            
            if ( !empty ( $_FILES["arquivo"]["name"] ) ) {
                //copiar o arquivo para a pasta
    
                if ( !copy( $_FILES["arquivo"]["tmp_name"], 
                    "./imagens-exercicio/".$_FILES["arquivo"]["name"] )) {
    
                    $mensagem = "Erro ao salvar imagem!";
                    errorBack( $titulo, $mensagem );
                    exit;
                    
                }
                
                $pastaFotos = "./imagens-exercicio/";
                
                $imagem = $_FILES["arquivo"]["name"];
                
                redimensionarImagem($pastaFotos,$imagem,$arquivo);

                if ( !empty ( $codigo_exercicio ) ) {
					//update na foto
					$sql = "UPDATE Exercicio set arquivo = :arquivo	where codigo_exercicio = :codigo_exercicio limit 1";
					$consulta =  $pdo->prepare($sql);
					$consulta->bindValue(":arquivo",$arquivo);
					$consulta->bindValue(":codigo_exercicio",$codigo_exercicio);
					$consulta->execute();
				}
                
            }
            
			// COMMIT
            $pdo->commit();
            
            // ALERTA
            $mensagem = "Registro salvo com sucesso!";
            $link = "listar/exercicio";
			sucessLink($titulo, $mensagem, $link);

        } else {
            // ROLLBACK
            $pdo->rollBack();
            //echo $consulta->errorInfo()[2];
            // ALERTA
			$mensagem = "Erro ao salvar registro !";
            errorBack( $titulo, $mensagem );
            exit;
		}
          
    } else {
        // ALERTA
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }