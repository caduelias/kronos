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
		else if ( empty($senha) ) {
            $mensagem = "Preencha a senha!";
            warning($titulo, $mensagem);
        } 
        else if (empty($tipo))
        {
            $mensagem = "Selecione o Tipo!";
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

            $senha = password_hash($senha, PASSWORD_DEFAULT);
            
            //var_dump($ativo);



        $pdo->beginTransaction();


		if ( empty ( $codigo_admin ) ) {

			//insert
			$sql = "INSERT INTO Admin 
			(codigo_admin, nome, email senha, tipo, ativo, data)
			VALUES 
			(NULL, :nome, :email, :senha, :tipo, :ativo, :data)";

			$consulta = $pdo->prepare( $sql );
			$consulta->bindValue(":nome",$nome);
            $consulta->bindValue(":senha",$senha);
            $consulta->bindValue(":email",$email);
			$consulta->bindValue(":tipo",$tipo);
			$consulta->bindValue(":ativo",$ativo);
			$consulta->bindValue(":data",$data);

        
		} else {

			//update
			$sql = "UPDATE Admin SET nome = :nome,
                    email = :email,
                    senha = :senha,
                    tipo = :tipo,
                    ativo = :ativo,
                    data = :data
				WHERE codigo_admin = :codigo LIMIT 1";
            $consulta =  $pdo->prepare($sql);
            $consulta->bindValue(":codigo",$codigo_admin);
            $consulta->bindValue(":nome",$nome);
            $consulta->bindValue(":email", $email);
            $consulta->bindValue(":senha",$senha);
			$consulta->bindValue(":tipo",$tipo);
			$consulta->bindValue(":ativo",$ativo);
			$consulta->bindValue(":data",$data);
		}

		//executar
		if ( $consulta->execute() ) {

			//salvar no banco
			$pdo->commit();
            $mensagem = "Usuário cadastrado com sucesso!";
            $link = "listar/admin";
			sucessLink($titulo, $mensagem, $link);

		} else {
			//erro do sql
			//echo $consulta->errorInfo()[2];
			$mensagem = "Erro ao salvar Usuário!";
            errorBack( $titulo, $mensagem );
            exit;
		}
          
    } else {
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }