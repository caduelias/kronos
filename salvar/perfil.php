<?php
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";

    if ( $_POST ) 
    {
        foreach ($_POST as $key => $value)
        {
            //echo "<p>$key $value</p>";
            //$key - nome do campo
            //$value - valor do campo (digitado)
            if ( isset ( $_POST[$key] ) ) 
            {
                $$key = trim ( $value );
            } 
        }

        if ( empty( $nome ) ) 
        {
            $mensagem = "Preencha o nome!";
            warning($titulo, $mensagem);
		}
        
        //var_dump($_POST);
           
            if ( empty ( $codigo_admin ) ) 
            {
                $sql = "SELECT codigo_admin, nome FROM Admin WHERE login = ? LIMIT 1";
                $consulta = $pdo->prepare( $sql );
                $consulta->bindParam(1,$login);
            } 
            else 
            {
                $sql = "SELECT codigo_admin, nome FROM Admin WHERE login = ? AND codigo_admin <> ? LIMIT 1";
                $consulta = $pdo->prepare( $sql );
                $consulta->bindParam(1,$login);
                $consulta->bindParam(2,$codigo_admin);
            }
    
            $consulta->execute();
            $dados = $consulta->fetch(PDO::FETCH_OBJ);
    
            if ( isset ( $dados->codigo_admin ) ) 
            {
                $mensagem = "Já existe um usuário cadastrado com esse nome!";
                warning($titulo, $mensagem);
                exit;
            }

            $dataAtual = date('d/m/Y');

            $data = formataData($dataAtual);
            
            // ***************************** START TRANSACTION *********************
            $pdo->beginTransaction();

            if ( !empty ( $codigo_admin ) ) 
            {
                // UPDATE
                $sql = "

                UPDATE Admin as a JOIN Endereco as e SET nome = :nome,
                a.email = :email,
                a.data = :data,
            
                e.bairro = :bairro,
                e.rua = :rua,
                e.numero = :numero

                WHERE a.codigo_admin = :codigo 
                AND a.Endereco_codigo_endereco = e.codigo_endereco;

                ";  
                
                $consulta =  $pdo->prepare($sql);

                // TABELA ADMIN
                $consulta->bindValue(":codigo",$codigo_admin);
                $consulta->bindValue(":nome",$nome);
                $consulta->bindValue(":email",$email);
                $consulta->bindValue(":data",$data);

                // TABELA ENDERECO
                $consulta->bindValue(":bairro",$bairro);
                $consulta->bindValue(":rua",$rua);
                $consulta->bindValue(":numero",$numero);
            }

            if ( $consulta->execute() ) 
            {
                $pdo->commit();
                $mensagem = "Dados atualizados com sucesso!";
                sucessBack($titulo, $mensagem);

            } 
            else 
            {
                //echo $consulta->errorInfo()[2];
                $mensagem = "Erro ao gravar!";
                errorBack( $titulo, $mensagem );
                exit;
            }
          
    } 
    else 
    {
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }