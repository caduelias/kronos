<?php
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
       include "verificaLogin.php";
    else
       include "../verificaLogin.php";

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

        $data_nascimento = formataData($data_nascimento);

        if ( empty ( $codigo_aluno ) ) {

			//se existe alguem, qualquer um, com o mesmo cpf
			$sql = "select codigo_aluno, nome_aluno from Aluno where cpf = ? limit 1";
			$consulta = $pdo->prepare( $sql );
			$consulta->bindParam(1,$cpf);

		} else {

			//se existe alguem, menos ele mesmo, com o mesmo cpf
			$sql = "select codigo_aluno, nome_aluno from Aluno where cpf = ? and codigo_aluno <> ? limit 1";
			$consulta = $pdo->prepare( $sql );
			$consulta->bindParam(1,$cpf);
			$consulta->bindParam(2,$codigo_aluno);
        }

        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if ( isset ( $dados->codigo_aluno ) ) 
        {
            // ALERTA
            $mensagem = "Este CPF já foi registrado!";
            warning($titulo, $mensagem);
            exit;
        }

        if($codigo_horario)
        {
            $sql = "select limite from Horario where codigo_horario = :codigo_horario limit 1;";
			$consulta = $pdo->prepare( $sql );
            $consulta->bindValue(":codigo_horario",$codigo_horario);

            $consulta->execute();
            $dados = $consulta->fetch(PDO::FETCH_OBJ);

            $limite = $dados->limite;
        
            $sql = "select count(codigo_aluno) as atual from Aluno where Horario_codigo_horario = :codigo_horario";
			$consulta = $pdo->prepare( $sql );
            $consulta->bindValue(":codigo_horario",$codigo_horario);
            
            $consulta->execute();
            $dados = $consulta->fetch(PDO::FETCH_OBJ);

            $atual = $dados->atual;

            if($atual > $limite) 
            {
                $titulo = "Horário indisponível";
                $mensagem = "O horário selecionado já atingiu o nº máximo de alunos!";
                errorBack( $titulo, $mensagem );
                exit;
            }

        }
           


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
   
               INSERT INTO Aluno 
               (codigo_aluno,
                nome_aluno, 
                data_nasc, 
                sexo, 
                rg, 
                cpf, 
                objetivo, 
                email, 
                ativo, 
                Horario_codigo_horario,
                Endereco_codigo_endereco
                )
               VALUES 
               (NULL, 
               :nome_aluno, 
               :data_nasc, 
               :sexo, 
               :rg, 
               :cpf, 
               :objetivo, 
               :email, 
               :ativo,
               :codigo_horario, 
               (select LAST_INSERT_ID()));

               INSERT INTO Telefone 
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
               $consulta->bindValue(":estado",$estado);
               $consulta->bindValue(":cidade",$cidade);
               $consulta->bindValue(":bairro",$bairro);
               $consulta->bindValue(":rua",$rua);
               $consulta->bindValue(":numero",$numero);

               // Tabela Aluno
               $consulta->bindValue(":nome_aluno",$nome_aluno);
               $consulta->bindValue(":data_nasc",$data_nascimento);
               $consulta->bindValue(":sexo",$sexo);
               $consulta->bindValue(":rg",$rg);
               $consulta->bindValue(":cpf",$cpf);
               $consulta->bindValue(":objetivo",$objetivo);
               $consulta->bindValue(":email",$email);
               $consulta->bindValue(":ativo",$ativo);
               $consulta->bindValue(":codigo_horario",$codigo_horario);

               // Tabela Telefone
               $consulta->bindValue(":telefone",$num_telefone);
               $consulta->bindValue(":celular",$num_celular);
   
           }
           
           if ( $consulta->execute() ) 
           {
               // COMMIT
               $pdo->commit();
               // ALERTA
               $mensagem = "Aluno registrado com sucesso!";
               $link = "listar/aluno";
               sucessLink($titulo, $mensagem, $link);
   
           } 
           else 
           {
               // ROLLBACK
               $pdo->rollBack();
               echo $consulta->errorInfo()[2];
               // ALERTA
               $mensagem = "Erro ao registrar aluno!";
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
