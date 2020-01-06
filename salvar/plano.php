<?php
    
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "permissaoAdmin.php" ) )
       include "permissaoAdmin.php";
    else
       include "../permissaoAdmin.php";

    include "config/funcoes.php";

    if ( $_POST ) {   
        foreach ($_POST as $key => $value) {
            //$key - nome do campo
            //$value - valor do campo (digitado)
            if ( isset ( $_POST[$key] ) ){
                $$key = trim( $value );
            } 
        }

        if ( empty( $nome_plano ) ) {
            $mensagem = "Preencha o nome!";
            warning($titulo, $mensagem);
        } else if ( empty( $taxa_adesao ) ) {
            $mensagem = "Informe uma taxa!";
            warning($titulo, $mensagem);
        } else if (empty( $mensalidade ) ) {
            $mensagem = "Informe uma mensalidade!";
            warning($titulo, $mensagem);
        }
        
        if ( empty($codigo_plano ) ) {
            // SELECT BUSCANDO PLANO COM O PLANO INFORMADO
            $sql = "SELECT codigo_plano FROM Plano WHERE nome_plano = ? LIMIT 1";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindParam(1,$nome_plano);
        } else {
            // SELECT BUSCANDO PLANO ONDE FOR DIFERENTE DO PRÓPIO PLANO
            $sql = "SELECT codigo_plano FROM Plano WHERE nome_plano = ? AND codigo_plano <> ? LIMIT 1";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindParam(1,$nome_plano);
            $consulta->bindParam(2,$codigo_plano);
        }

        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if ( isset($dados->codigo_plano ) ) {
            // ALERTA
            $mensagem = "Este plano já foi cadastrado!";
            warning($titulo, $mensagem);
            exit;
        }
        
        $taxa_adesao = formataFloat($taxa_adesao);
        $mensalidade = formataFloat($mensalidade);

        // *****************START TRANSACTION************************
        $pdo->beginTransaction();

        if ( empty ( $codigo_plano ) ) {
			// INSERT
            $sql = "
             
            INSERT INTO Plano
            (codigo_plano, status, nome_plano, taxa_adesao, mensalidade, descricao, dependentes, qtd_dependentes)
            VALUES 
            (NULL, :status, :nome_plano, :taxa_adesao, :mensalidade, :descricao, :dependentes, :qtd_dependentes);
           
            ";

            $consulta = $pdo->prepare( $sql );

            // Tabela Plano
            $consulta->bindValue(":status",$status);
            $consulta->bindValue(":nome_plano",$nome_plano);
            $consulta->bindValue(":taxa_adesao",$taxa_adesao);
            $consulta->bindValue(":mensalidade",$mensalidade);
            $consulta->bindValue(":descricao",$descricao);
            $consulta->bindValue(":dependentes",$dependentes);
            $consulta->bindValue(":qtd_dependentes",$qtd_dependentes);

            
        } else { 
			// UPDATE
			$sql = "
            UPDATE Plano SET 
            nome_plano = :nome_plano,
            status = :status, 
            taxa_adesao = :taxa_adesao, 
            mensalidade = :mensalidade, 
            descricao = :descricao,
            dependentes = :dependentes,
            qtd_dependentes = :qtd_dependentes

            WHERE codigo_plano = :codigo_plano LIMIT 1
           
            ";

            $consulta =  $pdo->prepare($sql);

            // Tabela Plano
            $consulta->bindValue(":status",$status);
            $consulta->bindValue(":nome_plano",$nome_plano);
            $consulta->bindValue(":taxa_adesao",$taxa_adesao);
            $consulta->bindValue(":mensalidade",$mensalidade);
            $consulta->bindValue(":descricao",$descricao);
            $consulta->bindValue(":codigo_plano",$codigo_plano);
            $consulta->bindValue(":dependentes",$dependentes);
            $consulta->bindValue(":qtd_dependentes",$qtd_dependentes);

		}

        if ( $consulta->execute() ) {
			// COMMIT
            $pdo->commit();
            // ALERTA
            $mensagem = "Registro salvo com sucesso!";
            $link = "listar/plano";
			sucessLink($titulo, $mensagem, $link);

        } else {
            // ROLLBACK
            $pdo->rollBack();
            echo $consulta->errorInfo()[2];
            exit;
            // ALERTA
			$mensagem = "Erro ao salvar registro!";
            errorBack( $titulo, $mensagem );
            exit;
		}
            
    } else {
        // ALERTA
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }