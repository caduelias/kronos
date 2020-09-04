<?php

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "permissaoAdmin.php" ) )
        include "permissaoAdmin.php";
    else
        include "../permissaoAdmin.php";

    include "config/funcoes.php";

    $codigo_usuario = $_SESSION["user"]["codigo_usuario"];
    $perfil = $_SESSION["user"]["perfil"];

	if ( isset ( $p[2] ) ) {
        $codigo = trim( $p[2] );

        if (empty($codigo) || $codigo_usuario == $codigo) {
            $titulo = "Acesso negado!";
            $mensagem = "Parâmetros inválidos!";
            $link = "listar/usuario";
            errorLink($titulo, $mensagem, $link);
            exit;
        }

        $sql0 = "SELECT u.Perfil_codigo_perfil FROM Usuario u
        INNER JOIN Perfil p ON p.codigo_perfil = u.Perfil_codigo_perfil
        WHERE u.codigo_usuario = ? 
        LIMIT 1;
        ";

        $consulta = $pdo->prepare( $sql0 );
        $consulta->bindParam(1,$codigo);
    
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        $perfilUsuario = $dados->Perfil_codigo_perfil;

        $sql1 = "SELECT u.codigo_usuario, u.Perfil_codigo_perfil FROM Usuario u
        INNER JOIN Perfil p ON p.codigo_perfil = u.Perfil_codigo_perfil
        WHERE u.codigo_usuario = ? AND u.Perfil_codigo_perfil = ? 
        LIMIT 1;
        ";

        $consulta = $pdo->prepare( $sql1 );
        $consulta->bindParam(1,$codigo);
        $consulta->bindParam(2,$perfilUsuario);
    
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        $consultaUsuario = $dados->codigo_usuario;
        $consultaPerfil = $dados->Perfil_codigo_perfil;

        if ($perfil == $consultaPerfil) {
            $titulo = "Status não pode ser alterado!";
            $mensagem = "O Usuário não tem permissão";
            $link = "listar/usuario";
            errorLink($titulo, $mensagem, $link);
            exit;
        }      

        if ($perfil != $consultaPerfil) {

            if ($consultaPerfil == "1") {
                $titulo = "Status não pode ser alterado!";
                $mensagem = "O Usuário não tem permissão";
                $link = "listar/usuario";
                errorLink($titulo, $mensagem, $link);
                exit;
            }        

        }
           
        $sql2 = "SELECT nome, status FROM Usuario WHERE codigo_usuario = ?";
        $consulta = $pdo->prepare( $sql2 );
        $consulta->bindParam(1,$codigo);
    
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        $nome = $dados->nome;
        $status = $dados->status;
        
        if (!$nome) {
            $titulo = "";
            $mensagem = "Usuário não encontrado!";
            $link = "listar/usuario";
            errorLink($titulo, $mensagem, $link);
            exit;
        }

        if ($nome && $status == 1) {
            $sql = "UPDATE Usuario SET status = 0 WHERE codigo_usuario = :codigo LIMIT 1";
            
            $consulta = $pdo->prepare($sql);
            $consulta->bindValue(":codigo",$codigo);

            if ( $consulta->execute() ) {
                $titulo = "";
                $mensagem = "Status alterado!";
                $link = "listar/inativo";
                sucessLink($titulo, $mensagem, $link);
            } else {
                $titulo = "";
                $mensagem = "Não foi possível alterar o Status do usuário";
                $link = "listar/usuario";
                errorLink($titulo, $mensagem, $link);
            }
        }
        
        if ($nome && $status == 0) { 
            $sql = "UPDATE Usuario SET status = 1 WHERE codigo_usuario = :codigo LIMIT 1";
            
            $consulta = $pdo->prepare($sql);
            $consulta->bindValue(":codigo",$codigo);

            if ( $consulta->execute() ) {
                $titulo = "";
                $mensagem = "Status alterado!";
                $link = "listar/usuario";
                sucessLink($titulo, $mensagem, $link);
            } else {
                $titulo = "";
                $mensagem = "Não foi possível alterar o Status do usuário";
                $link = "listar/inativo";
                errorLink($titulo, $mensagem, $link);
            }
        }

    } else {
        $titulo = "";
        $mensagem = "Parâmetros Inválidos!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }