<?php
    
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "permissaoAdmin.php" ) )
       include "permissaoAdmin.php";
    else
       include "../permissaoAdmin.php";

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

        
        if ( empty( $login ) ) 
        {
            $mensagem = "Preencha o nome!";
            warning($titulo, $mensagem);
        } 
        else if ( empty( $senha ) ) 
        {
            $mensagem = "Preencha a senha!";
            warning($titulo, $mensagem);
        } 
        else if (empty( $tipo ) )
        {
            $mensagem = "Selecione o tipo!";
            warning($titulo, $mensagem);
        }
        
        //var_dump($_POST);
        
        if ( empty ( $codigo_admin ) ) 
        {
            // SELECT BUSCANDO LOGIN COM O LOGIN INFORMADO
            $sql = "SELECT codigo_admin, login FROM Admin WHERE login = ? LIMIT 1";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindParam(1,$login);

        } 
        else 
        {
            // SELECT BUSCANDO LOGIN ONDE FOR DIFERENTE DO PRÓPIO LOGIN
            $sql = "SELECT codigo_admin, login FROM Admin WHERE login = ? AND codigo_admin <> ? LIMIT 1";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindParam(1,$login);
            $consulta->bindParam(2,$codigo_admin);

        }

        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if ( isset ( $dados->codigo_admin ) ) 
        {
            // ALERTA
            $mensagem = "Já existe um usuário cadastrado com esse login!";
            warning($titulo, $mensagem);
            exit;
        }

        $dataAtual = date('d/m/Y');

        $data = formataData($dataAtual);

        $senha = password_hash($senha, PASSWORD_DEFAULT);
        
        // *****************START TRANSACTION************************
        $pdo->beginTransaction();

        if ( empty ( $codigo_admin ) ) 
        {
			// INSERT
            $sql = "
            
            SET AUTOCOMMIT=0;
            START TRANSACTION;
            
            INSERT INTO Endereco
            (codigo_endereco, estado, cidade, bairro, rua, numero)
            VALUES 
            (NULL, :estado, :cidade, :bairro, :rua, :numero);

            INSERT INTO Admin 
			(codigo_admin, nome, login, email, senha, tipo, ativo, data, Endereco_codigo_endereco)
			VALUES 
            (NULL, :nome, :login, :email, :senha, :tipo, :ativo, :data, (select LAST_INSERT_ID()));

            COMMIT;
            SET AUTOCOMMIT=1;

            ";

            $consulta = $pdo->prepare( $sql );

            // Tabela Endereco
            $consulta->bindValue(":estado",$estado);
            $consulta->bindValue(":cidade",$cidade);
            $consulta->bindValue(":bairro",$bairro);
            $consulta->bindValue(":rua",$rua);
            $consulta->bindValue(":numero",$numero);
            
            // Tabela Admin
            $consulta->bindValue(":nome",$nome);
            $consulta->bindValue(":login",$login);
            $consulta->bindValue(":senha",$senha);
            $consulta->bindValue(":email",$email);
			$consulta->bindValue(":tipo",$tipo);
			$consulta->bindValue(":ativo",$ativo);
			$consulta->bindValue(":data",$data);

        } 
        else 
        { 
			// UPDATE
			$sql = "
            UPDATE Admin as a JOIN Endereco as e SET nome = :nome,
            a.login = :login,
            a.email = :email,
            a.tipo = :tipo,
            a.ativo = :ativo,
            a.data = :data,
               
            e.estado = :estado,
            e.cidade = :cidade,
            e.bairro = :bairro,
            e.rua = :rua,
            e.numero = :numero

            WHERE a.codigo_admin = :codigo 
            AND a.Endereco_codigo_endereco = e.codigo_endereco;
                
            ";

            $consulta =  $pdo->prepare($sql);

            // Tabela Endereco
            $consulta->bindValue(":estado",$estado);
            $consulta->bindValue(":cidade",$cidade);
            $consulta->bindValue(":bairro",$bairro);
            $consulta->bindValue(":rua",$rua);
            $consulta->bindValue(":numero",$numero);

            // Tabela Admin
            $consulta->bindValue(":codigo",$codigo_admin);
            $consulta->bindValue(":nome",$nome);
            $consulta->bindValue(":login",$login);
            $consulta->bindValue(":email", $email);
			$consulta->bindValue(":tipo",$tipo);
			$consulta->bindValue(":ativo",$ativo);
			$consulta->bindValue(":data",$data);
		}

		
        if ( $consulta->execute() ) 
        {
			// COMMIT
            $pdo->commit();
            // ALERTA
            $mensagem = "Usuário cadastrado com sucesso!";
            $link = "listar/admin";
			sucessLink($titulo, $mensagem, $link);

        } 
        else 
        {
            // ROLLBACK
            $pdo->rollBack();
            //echo $consulta->errorInfo()[2];
            // ALERTA
			$mensagem = "Erro ao salvar Usuário!";
            errorBack( $titulo, $mensagem );
            exit;
		}
             
    } 
    else 
    {
        // ALERTA
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }