<?php
    
    include "config/funcoes.php";
    
$pdo->beginTransaction();
        
//se os dados vieram por POST
if ( $_POST ) {
    //iniciar as variaveis
    $atual = $nova = $redigite = "";
    foreach ($_POST as $key => $value) {
        //echo "<p>$key $value</p>";
        //$key - nome do campo
        //$value - valor do campo (digitado)
        if ( isset ( $_POST[$key] ) ) {
            $$key = trim ( $value );
        } 
    }

    //sql a ser executado select
    $sql = "SELECT senha from Admin WHERE codigo_admin = ? LIMIT 1";
    //preparar o sql para execução
    $consulta = $pdo->prepare($sql);
    //passar o parâmetro
    $consulta->bindParam(1, $codigo_admin);
    //executar
    $consulta->execute();
    //recuperar os dados da consulta
    $dados = $consulta->fetch(PDO::FETCH_OBJ); 
    $senha = $dados->senha;
    
    //var_dump ( $senha, $atual, $nova);
    
    //verificar e comparar senhas
    if ( password_verify ( $atual, $senha ) ) {
        //nova senha recebe criptografia
        $nova = password_hash($nova, PASSWORD_DEFAULT); 
        //sql a ser executado update
        $sql = "UPDATE Admin set senha = :nova where codigo_admin = :codigo LIMIT 1";
        //preparar o sql para execução
        $consulta = $pdo->prepare($sql);
        //passar parâmetros
        $consulta->bindValue(":nova",$nova);
        $consulta->bindValue(":codigo",$codigo_admin);
        //se executar sql
        if ( $consulta->execute() ) {

            //salvar no banco
            $pdo->commit();
            //exibir mensagem e deslogar usuário
            $titulo = "Senha Alterada!";
            $mensagem = "A sessão será encerrada, por favor, realize o Login com a nova senha!";
            $link = "logout.php";
            sucessLink( $titulo, $mensagem, $link);
            
        } else {
            //erro do sql
            echo $consulta->errorInfo()[2];
            $mensagem = "Erro! Não foi possível Alterar!";
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