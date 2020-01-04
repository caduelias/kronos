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
        else if (empty( $perfil ) )
        {
            $mensagem = "Selecione o perfil!";
            warning($titulo, $mensagem);
        }
         
        if ( empty ( $codigo_usuario ) ) 
        {
            // SELECT BUSCANDO LOGIN COM O LOGIN INFORMADO
            $sql = "SELECT codigo_usuario, login FROM Usuario WHERE login = ? LIMIT 1";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindParam(1,$login);

        } 
        else 
        {
            // SELECT BUSCANDO LOGIN ONDE FOR DIFERENTE DO PRÓPIO LOGIN
            $sql = "SELECT codigo_usuario, login FROM Usuario WHERE login = ? AND codigo_usuario <> ? LIMIT 1";
            $consulta = $pdo->prepare( $sql );
            $consulta->bindParam(1,$login);
            $consulta->bindParam(2,$codigo_usuario);

        }

        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if ( isset ( $dados->codigo_usuario ) ) 
        {
            // ALERTA
            $mensagem = "Já existe um usuário cadastrado com esse login!";
            warning($titulo, $mensagem);
            exit;
        }

        $login = strtolower($login);

        $senhaformatada = strtolower($senha);
        
        $dataAtual = date('d/m/Y');

        $data = formataData($dataAtual);

        $senha = password_hash($senhaformatada, PASSWORD_DEFAULT);
 
        // *****************START TRANSACTION************************
        $pdo->beginTransaction();

        if ( empty ( $codigo_usuario ) ) 
        {
			// INSERT
            $sql = "
            
            SET AUTOCOMMIT=0;
            START TRANSACTION;
            
            INSERT INTO Endereco
            (codigo_endereco, estado, cidade, bairro, rua, numero)
            VALUES 
            (NULL, :estado, :cidade, :bairro, :rua, :numero);

            INSERT INTO Usuario 
			(codigo_usuario, Perfil_codigo_perfil, nome, login, email, senha, status, data, Endereco_codigo_endereco)
			VALUES 
            (NULL, :perfil, :nome, :login, :email, :senha, :status, :data, (select LAST_INSERT_ID()));

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
            
            // Tabela Usuario
            $consulta->bindValue(":nome",$nome);
            $consulta->bindValue(":login",$login);
            $consulta->bindValue(":senha",$senha);
            $consulta->bindValue(":email",$email);
			$consulta->bindValue(":perfil",$perfil);
			$consulta->bindValue(":status",$status);
			$consulta->bindValue(":data",$data);

        } 
        else 
        { 
			// UPDATE
			$sql = "
            UPDATE Usuario as u JOIN Endereco as e SET nome = :nome,
            u.login = :login,
            u.email = :email,
            u.Perfil_codigo_perfil = :perfil,
            u.status = :status,
            u.data = :data,
               
            e.estado = :estado,
            e.cidade = :cidade,
            e.bairro = :bairro,
            e.rua = :rua,
            e.numero = :numero

            WHERE u.codigo_usuario = :codigo_usuario 
            AND u.Endereco_codigo_endereco = e.codigo_endereco;
                
            ";

            $consulta =  $pdo->prepare($sql);

            // Tabela Endereco
            $consulta->bindValue(":estado",$estado);
            $consulta->bindValue(":cidade",$cidade);
            $consulta->bindValue(":bairro",$bairro);
            $consulta->bindValue(":rua",$rua);
            $consulta->bindValue(":numero",$numero);

            // Tabela Admin
            $consulta->bindValue(":codigo_usuario",$codigo_usuario);
            $consulta->bindValue(":nome",$nome);
            $consulta->bindValue(":login",$login);
            $consulta->bindValue(":email", $email);
			$consulta->bindValue(":perfil",$perfil);
			$consulta->bindValue(":status",$status);
			$consulta->bindValue(":data",$data);
		}

		
        if ( $consulta->execute() ) 
        {
			// COMMIT
            $pdo->commit();
            // ALERTA
            $mensagem = "Usuário registrado com sucesso!";
            $link = "listar/usuario";
			sucessLink($titulo, $mensagem, $link);

        } 
        else 
        {
            // ROLLBACK
            $pdo->rollBack();
            //echo $consulta->errorInfo()[2];
            // ALERTA
			$mensagem = "Erro ao registrar Usuário!";
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