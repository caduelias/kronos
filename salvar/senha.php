<?php
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";
    
    if ( $_POST ) {
        $atual = $nova = $redigite = "";
        
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

        $codigo_usuario = base64_decode($codigo_usuario);
    
        // ================================================================

        $sql = "SELECT senha from Usuario WHERE codigo_usuario = ? LIMIT 1";
        
        $consulta = $pdo->prepare($sql);
        
        $consulta->bindParam(1, $codigo_usuario);
        
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ); 

        $senha = $dados->senha;

        // =================================================================
    
        $pdo->beginTransaction();

        if ( password_verify($atual, $senha) ) {
            $nova = password_hash($nova, PASSWORD_DEFAULT); 
            
            $sql = "UPDATE Usuario set senha = :nova where codigo_usuario = :codigo_usuario LIMIT 1";

            $consulta = $pdo->prepare($sql);

            $consulta->bindValue(":nova",$nova);
            $consulta->bindValue(":codigo_usuario",$codigo_usuario);

            if ( $consulta->execute() ) {
                $pdo->commit();
                // ALERT AND UNSET $_SESSION
                $titulo = "Senha alterada com sucesso";
                $mensagem = "Realize o login novamente!";
                $link = "logout.php";
                updateSenha( $titulo, $mensagem, $link);
                
            } else {
                //echo $consulta->errorInfo()[2];
                $mensagem = "Não foi possível Alterar!";
                errorBack($titulo, $mensagem);
                exit;
            }
            
        } else {
            $mensagem = "Senha atual digitada é Inválida!";
            errorBack($titulo, $mensagem);
            exit;
        }

    } else {
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }