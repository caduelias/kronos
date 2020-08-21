<?php

declare(strict_types=1);

include "config/funcoes.php";   
   
    if (file_exists("verificaLogin.php") )
       include "verificaLogin.php";
    else
       include "../verificaLogin.php";

    try {

        if (!$_POST) {
            throw new Exception("Requisição inválida", 400);
        }

        $exercicios = $_POST;

        if (!isset($exercicios['codigo_aluno'])) {
            throw new Exception("O código do aluno é obrigatório!", 400);
        }

        if (!isset($exercicios['listexercicios'])) {
            throw new Exception("Informe ao menos um exercício!", 400);
        }

        try {
            $sql = "
            SELECT 
                ae.*
            FROM aluno_exercicio ae 
            WHERE ae.codigo_aluno = :codigo_aluno;
            ";
            $consulta = $pdo->prepare($sql);
            $consulta->bindValue(":codigo_aluno", $exercicios['codigo_aluno']);
            $consulta->execute();
            $dados = $consulta->fetchAll(PDO::FETCH_OBJ);

            $exercicios_old = $dados ?? null;
        } catch (PDOException $erro) {
            // echo $consulta->errorInfo()[2];
            // exit;
            throw new Exception("Erro ao consultar exercícios do aluno!", 500);
        }

        try {
            $pdo->beginTransaction();
            // ALUNO_EXERCICIOS

            try {
                foreach($exercicios['listexercicios'] as $exercicio) { 
                    $sql = "
                    SELECT 
                       am.codigo_modalidade
                    FROM aluno_modalidade am 
                        INNER JOIN aluno_exercicio ae ON ae.codigo_aluno = am.codigo_aluno
                    WHERE am.codigo_aluno = :codigo_aluno and ae.codigo_exercicio = $exercicio;
                    ";
                    $consulta = $pdo->prepare($sql);
                    $consulta->bindValue(":codigo_aluno", $exercicios['codigo_aluno']);
                    $consulta->execute();
                    $dados = $consulta->fetchAll(PDO::FETCH_OBJ);
        
                    $checkModalidades = $dados ?? null;

                    if (!isset($checkModalidades)) {
                        throw new Exception("O aluno não está vinculado a modalidade referente ao exercicio selecionado!", 500);
                    }
                }
            } catch (PDOException $erro) {
                // echo $consulta->errorInfo()[2];
                // exit;
                throw new Exception("Erro ao consultar modalidades do aluno!", 500);
            }

            try {
                if (isset($exercicios_old)) {
                    $del = "DELETE FROM aluno_exercicio WHERE codigo_aluno = :codigo_aluno";
                    $consulta = $pdo->prepare($del);
                    $consulta->bindValue(":codigo_aluno", $exercicios['codigo_aluno']);
                    $consulta->execute();
                }
               
                foreach($exercicios['listexercicios'] as $exercicio) {

                    $sql = "INSERT INTO aluno_exercicio
                    (codigo_aluno_exercicio, codigo_aluno, codigo_exercicio)
                    VALUES 
                    (NULL, :codigo_aluno, :codigo_exercicio)";
    
                    $consulta = $pdo->prepare($sql);
                    $consulta->bindValue(":codigo_aluno", $exercicios['codigo_aluno']);
                    $consulta->bindValue(":codigo_exercicio", $exercicio);
                    $consulta->execute();
                }
            } catch (PDOException $erro) {
                throw new Exception("Erro ao registrar exercícios do aluno!", 500);
            }   
            $pdo->commit();
            $codigo_aluno = base64_encode($exercicios['codigo_aluno']);
            sucessLink(null, "Registro salvo!", "cadastros/gerenciaraluno/".$codigo_aluno);
        } catch (PDOException $erro) {
            $pdo->rollBack();
            // echo $consulta->errorInfo()[2];
            // exit;
            throw new Exception("Erro ao salvar exercícios do aluno!", 500);
        }
 
    } catch (Exception $e) {
        $mensagem = $e->getMessage() . " - " . strval($e->getCode());
        errorBack(null, $mensagem);
    }