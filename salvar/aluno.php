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

        $aluno = $_POST;

        if (!validaCPF($aluno['cpf']) ) {
            throw new Exception("CPF inválido", 400);
        }
        
        if (isset($aluno['codigo_aluno']) ) {
            //se existe alguem, menos ele mesmo, com o mesmo cpf
            $sql = "select codigo_aluno, nome_aluno from aluno where cpf = ? and codigo_aluno <> ? limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(1,$aluno['cpf']);
            $consulta->bindParam(2,$aluno['codigo_aluno']);
        } else {
            //se existe alguem, qualquer um, com o mesmo cpf
            $sql = "select codigo_aluno, nome_aluno from aluno where cpf = ? limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(1,$aluno['cpf']);
        }
        
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if (isset($dados->codigo_aluno) ) {
            throw new Exception("Este aluno já foi registrado", 400);
        }
      
        if (!validaData($aluno['data_nascimento']) ){
            throw new Exception("Data de nascimento inválida", 400);
        }

        if (!validaIdade($aluno['data_nascimento'])) {
            throw new Exception("A idade do aluno está fora dos padrões aceitaveis", 403);
        }

        if ($aluno['codigo_aluno']) {
            //UPDATE
            try {
                $pdo->beginTransaction();
                $sql = "
                UPDATE aluno as a JOIN endereco as e JOIN telefone as t SET
                a.nome_aluno =  :nome_aluno, 
                a.data_nasc  = :data_nasc, 
                a.sexo       =   :sexo, 
                a.rg         =  :rg, 
                a.cpf  = :cpf, 
                a.objetivo  = :objetivo, 
                a.email  = :email, 
                a.status  = :status,
                
                e.estado = :estado,
                e.cidade = :cidade,
                e.bairro = :bairro,
                e.rua = :rua,
                e.numero = :numero,

                t.num_telefone = :telefone,
                t.num_celular  = :celular

                WHERE a.codigo_aluno = :codigo_aluno 
                AND a.Endereco_codigo_endereco = e.codigo_endereco
                AND a.codigo_aluno = t.Aluno_codigo_aluno;
                ";
                
                $consulta = $pdo->prepare($sql);
        
                // Tabela Endereco
                $consulta->bindValue(":estado", $aluno['estado']);
                $consulta->bindValue(":cidade", $aluno['cidade']);
                $consulta->bindValue(":bairro", $aluno['bairro']);
                $consulta->bindValue(":rua", $aluno['rua']);
                $consulta->bindValue(":numero", $aluno['numero']);

                // Tabela Aluno
                $consulta->bindValue(":codigo_aluno",$aluno['codigo_aluno']);
                $consulta->bindValue(":nome_aluno", $aluno['nome_aluno']);
                $consulta->bindValue(":data_nasc", formataData($aluno['data_nascimento']));
                $consulta->bindValue(":sexo", $aluno['sexo']);
                $consulta->bindValue(":rg", $aluno['rg']);
                $consulta->bindValue(":cpf", $aluno['cpf']);
                $consulta->bindValue(":objetivo", $aluno['objetivo']);
                $consulta->bindValue(":email", $aluno['email']);
                $consulta->bindValue(":status", $aluno['status']);

                // Tabela Telefone
                $consulta->bindValue(":telefone", $aluno['num_telefone']);
                $consulta->bindValue(":celular", $aluno['num_celular']);

                $consulta->execute();

                $pdo->commit();
                sucessLink(null, "Registro salvo!", "listar/aluno");
            } catch (PDOException $erro) {
                $pdo->rollBack();
                // echo $consulta->errorInfo()[2];
                // exit;
                throw new Exception("Erro ao salvar registro", 500);
            }

        } else {
            //INSERT
            try {
                $pdo->beginTransaction();
                $sql = "
                SET AUTOCOMMIT=0;
                START TRANSACTION;
                
                INSERT INTO endereco
                (codigo_endereco, estado, cidade, bairro, rua, numero)
                VALUES 
                (NULL, :estado, :cidade, :bairro, :rua, :numero);
    
                INSERT INTO aluno 
                (codigo_aluno,
                    data_cadastro,
                    nome_aluno, 
                    data_nasc, 
                    sexo, 
                    rg, 
                    cpf, 
                    objetivo, 
                    email, 
                    status, 
                    Endereco_codigo_endereco
                    )
                VALUES 
                (NULL, 
                :data_cadastro,
                :nome_aluno, 
                :data_nasc, 
                :sexo, 
                :rg, 
                :cpf, 
                :objetivo, 
                :email, 
                :status,
                (select LAST_INSERT_ID()));

                INSERT INTO telefone 
                (codigo_telefone,
                    num_telefone, 
                    num_celular, 
                    Aluno_codigo_aluno
                    )
                VALUES 
                (NULL,
                :telefone,
                :celular,
                (select LAST_INSERT_ID()));

                COMMIT;
                SET AUTOCOMMIT=1;
                ";
    
                $consulta = $pdo->prepare($sql);
        
                // Tabela Endereco
                $consulta->bindValue(":estado", $aluno['estado']);
                $consulta->bindValue(":cidade", $aluno['cidade']);
                $consulta->bindValue(":bairro", $aluno['bairro']);
                $consulta->bindValue(":rua", $aluno['rua']);
                $consulta->bindValue(":numero", $aluno['numero']);

                // Tabela Aluno
                $consulta->bindValue(":data_cadastro", date('Y/m/d'));
                $consulta->bindValue(":nome_aluno", $aluno['nome_aluno']);
                $consulta->bindValue(":data_nasc", formataData($aluno['data_nascimento']));
                $consulta->bindValue(":sexo", $aluno['sexo']);
                $consulta->bindValue(":rg", $aluno['rg']);
                $consulta->bindValue(":cpf", $aluno['cpf']);
                $consulta->bindValue(":objetivo", $aluno['objetivo']);
                $consulta->bindValue(":email", $aluno['email']);
                $consulta->bindValue(":status", $aluno['status']);

                // Tabela Telefone
                $consulta->bindValue(":telefone", $aluno['num_telefone']);
                $consulta->bindValue(":celular", $aluno['num_celular']);

                $consulta->execute();

                $pdo->commit();
                sucessLink(null, "Registro salvo!", "listar/aluno");
            } catch (PDOException $erro) {
                $pdo->rollBack();
                // echo $consulta->errorInfo()[2];
                // exit;
                throw new Exception("Erro ao salvar registro", 500);
            }
        }
       
    } catch (Exception $e) {
        $mensagem = $e->getMessage() . " - " . strval($e->getCode());
        errorBack(null, $mensagem);
    }