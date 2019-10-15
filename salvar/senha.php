<?php
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";
    
    if ( $_POST ) 
    {
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

        $codigo_admin = base64_decode($codigo_admin);
    
        // ================================================================

        $sql = "SELECT senha from Admin WHERE codigo_admin = ? LIMIT 1";
        
        $consulta = $pdo->prepare($sql);
        
        $consulta->bindParam(1, $codigo_admin);
        
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ); 

        $senha = $dados->senha;

        // =================================================================
    
        //echo "<p class='text-center'> ( $senha), $atual, $nova</p>";

        $pdo->beginTransaction();

        if ( password_verify ( $atual, $senha ) ) 
        {
            $nova = password_hash($nova, PASSWORD_DEFAULT); 
            
            $sql = "UPDATE Admin set senha = :nova where codigo_admin = :codigo LIMIT 1";

            $consulta = $pdo->prepare($sql);

            $consulta->bindValue(":nova",$nova);
            $consulta->bindValue(":codigo",$codigo_admin);

            if ( $consulta->execute() ) 
            {
                $pdo->commit();
                // ALERT AND UNSET $_SESSION
                $titulo = "Senha Alterada com Sucesso";
                $mensagem = "Realize o Login novamente!";
                $link = "logout.php";
                updateSenha( $titulo, $mensagem, $link);
                
            } 
            else 
            {
                //echo $consulta->errorInfo()[2];
                $mensagem = "Erro! Não foi possível Alterar!";
                errorBack($titulo, $mensagem);
                exit;
            }
            
        } 
        else 
        {
            $mensagem = "Senha atual digitada é Inválida!";
            errorBack($titulo, $mensagem);
            exit;
        }

    } 
    else 
    {
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }