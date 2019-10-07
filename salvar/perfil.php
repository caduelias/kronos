<?php

    include "config/funcoes.php";

    
        
    //se os dados vieram por POST
    if ( $_POST ) {
        //iniciar as variaveis
        foreach ($_POST as $key => $value) {
            //echo "<p>$key $value</p>";
            //$key - nome do campo
            //$value - valor do campo (digitado)
            if ( isset ( $_POST[$key] ) ) {
                $$key = trim ( $value );
            } 
        }

        if ( empty( $nome ) ) 
        {
            $mensagem = "Preencha o nome!";
            warning($titulo, $mensagem);
		}
        
        //var_dump($_POST);
            
            if ( empty ( $codigo_admin ) ) {
                $sql = "SELECT codigo_admin, nome FROM Admin WHERE nome = ? LIMIT 1";
                $consulta = $pdo->prepare( $sql );
                $consulta->bindParam(1,$nome);
    
            } else {
                $sql = "SELECT codigo_admin, nome FROM Admin WHERE nome = ? AND codigo_admin <> ? limit 1";
                $consulta = $pdo->prepare( $sql );
                $consulta->bindParam(1,$nome);
                $consulta->bindParam(2,$codigo_admin);
    
            }
    
            //executar o sql
            $consulta->execute();
            $dados = $consulta->fetch(PDO::FETCH_OBJ);
    
            //verificar se o dados trouxe algum resultado
            if ( isset ( $dados->codigo_admin ) ) {
                $mensagem = "Já existe um usuário cadastrado com esse nome!";
                warning($titulo, $mensagem);
                exit;
            }

            $dataAtual = date('d/m/Y');

            $data = formataData($dataAtual);
            
            //var_dump($ativo);



        $pdo->beginTransaction();


		if ( !empty ( $codigo_admin ) ) {

			//update
			$sql = "UPDATE Admin SET nome = :nome,
                    email = :email,
                    tipo = :tipo,
                    ativo = :ativo,
                    data = :data
				WHERE codigo_admin = :codigo LIMIT 1";
            $consulta =  $pdo->prepare($sql);
            $consulta->bindValue(":codigo",$codigo_admin);
            $consulta->bindValue(":nome",$nome);
            $consulta->bindValue(":email",$email);
			$consulta->bindValue(":tipo",$tipo);
			$consulta->bindValue(":ativo",$ativo);
			$consulta->bindValue(":data",$data);
		}

		//executar
		if ( $consulta->execute() ) {

			//salvar no banco
			$pdo->commit();
            $mensagem = "Usuário alterado com sucesso!";
			sucessBack($titulo, $mensagem);

		} else {
			//erro do sql
			//echo $consulta->errorInfo()[2];
			$mensagem = "Erro ao alterar Usuário";
            errorBack( $titulo, $mensagem );
            exit;
		}
          
    } else {
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }