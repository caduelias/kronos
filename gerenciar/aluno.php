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

        $dados_aluno = $_POST;

        if (!($dados_aluno['codigo_aluno']) ) {
            throw new Exception("O código do aluno é obrigatório!", 400);
        }

        if (!$dados_aluno['modalidade']) {
            throw new Exception("Informe ao menos uma modalidade!", 400);
        }

        if (!($dados_aluno['codigo_plano']) ) {
            throw new Exception("O plano é obrigatório!", 400);
        }
    
        try {
            $sql = "select codigo_aluno_modalidade from aluno_modalidade where codigo_aluno = ? limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(1, $dados_aluno['codigo_aluno']);
        
            $consulta->execute();
            $aluno_modalidade = $consulta->fetch(PDO::FETCH_OBJ);

            $sql = "select codigo_aluno_plano from aluno_plano where codigo_aluno = ? limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(1, $dados_aluno['codigo_aluno']);
        
            $consulta->execute();
            $aluno_plano = $consulta->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            throw new Exception("Erro ao consultar informações do aluno!", 500);
        }

        try {
            $pdo->beginTransaction();

             // ALUNO_MODALIDADE
            if (isset($aluno_modalidade->codigo_aluno_modalidade)) {
                try {
                    $del = "DELETE FROM aluno_modalidade WHERE codigo_aluno = :codigo_aluno";
                    $consulta = $pdo->prepare($del);
                    $consulta->bindValue(":codigo_aluno", $dados_aluno['codigo_aluno']);
                    $consulta->execute();
    
                    foreach($dados_aluno['modalidade'] as $codigo_modalidade) {
    
                        // $sql = "UPDATE aluno_modalidade 
                        // SET codigo_aluno = :codigo_aluno, 
                        //     codigo_modalidade = :codigo_modalidade
                        // WHERE codigo_aluno = :codigo_aluno";
    
                        // $consulta = $pdo->prepare($sql);
                        // $consulta->bindValue(":codigo_aluno", $dados_aluno['codigo_aluno']);
                        // $consulta->bindValue(":codigo_modalidade", $codigo_modalidade);
                        // $consulta->execute();
    
                        $sql = "INSERT INTO aluno_modalidade
                        (codigo_aluno_modalidade, codigo_aluno, codigo_modalidade)
                        VALUES 
                        (NULL, :codigo_aluno, :codigo_modalidade)";
        
                        $consulta = $pdo->prepare($sql);
                        $consulta->bindValue(":codigo_aluno", $dados_aluno['codigo_aluno']);
                        $consulta->bindValue(":codigo_modalidade", $codigo_modalidade);
                        $consulta->execute();
                    }
                } catch (PDOException $erro) {
                    throw new Exception("Erro ao atualizar modalidades do aluno!", 500);
                }   
            } else {
                try {
                    foreach($dados_aluno['modalidade'] as $codigo_modalidade) {
                        $sql = "INSERT INTO aluno_modalidade
                        (codigo_aluno_modalidade, codigo_aluno, codigo_modalidade)
                        VALUES 
                        (NULL, :codigo_aluno, :codigo_modalidade)";
        
                        $consulta = $pdo->prepare($sql);
                        $consulta->bindValue(":codigo_aluno", $dados_aluno['codigo_aluno']);
                        $consulta->bindValue(":codigo_modalidade", $codigo_modalidade);
                        $consulta->execute();
                    }
                } catch (PDOException $erro) {
                    throw new Exception("Erro ao salvar modalidades do aluno!", 500);
                }
            }

            // ALUNO_PLANO
            if (isset($aluno_plano->codigo_aluno_plano)) {
                try {
                        $sql = "UPDATE aluno_plano
                        SET codigo_plano = :codigo_plano
                        WHERE codigo_aluno = :codigo_aluno";
        
                        $consulta = $pdo->prepare($sql);
                        $consulta->bindValue(":codigo_aluno", $dados_aluno['codigo_aluno']);
                        $consulta->bindValue(":codigo_plano", $dados_aluno['codigo_plano']);
                        $consulta->execute();
                } catch (PDOException $erro) {
                    throw new Exception("Erro ao atualizar plano do aluno!", 500);
                }
            } else {
                try {
                        $sql = "INSERT INTO aluno_plano
                        (codigo_aluno_plano, codigo_aluno, codigo_plano)
                        VALUES 
                        (NULL, :codigo_aluno, :codigo_plano)";
                        $consulta = $pdo->prepare($sql);
                        $consulta->bindValue(":codigo_aluno", $dados_aluno['codigo_aluno']);
                        $consulta->bindValue(":codigo_plano", $dados_aluno['codigo_plano']);
                        $consulta->execute();
                } catch (PDOException $erro) {
                    throw new Exception("Erro ao salvar plano do aluno!", 500);
                }
            }
    
            $pdo->commit();
            $codigo_aluno = base64_encode($dados_aluno['codigo_aluno']);
            sucessLink(null, "Registro salvo!", "cadastros/gerenciaraluno/".$codigo_aluno);
        } catch (PDOException $erro) {
            $pdo->rollBack();
            // echo $consulta->errorInfo()[2];
            // exit;
            throw new Exception("Erro ao salvar dados do aluno!", 500);
        }
 
    } catch (Exception $e) {
        $mensagem = $e->getMessage() . " - " . strval($e->getCode());
        errorBack(null, $mensagem);
    }