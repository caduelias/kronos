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

        if(validaCPF($cpf) == false){
            $titulo = "CPF inválido!";
            $mensagem = "Informe um CPF válido!";
            errorBack( $titulo, $mensagem );
            exit;
        }
        
        if (!empty($codigo_aluno)) {

			//se existe alguem, menos ele mesmo, com o mesmo cpf
			$sql = "select codigo_aluno, nome_aluno from Aluno where cpf = ? and codigo_aluno <> ? limit 1";
			$consulta = $pdo->prepare( $sql );
			$consulta->bindParam(1,$cpf);
            $consulta->bindParam(2,$codigo_aluno);
            
        } else if ( empty($codigo_aluno) ) {

			//se existe alguem, qualquer um, com o mesmo cpf
			$sql = "select codigo_aluno, nome_aluno from Aluno where cpf = ? limit 1";
			$consulta = $pdo->prepare( $sql );
			$consulta->bindParam(1,$cpf);

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

        if($codigo_horario){
            $sql = "select limite from Horario where codigo_horario = :codigo_horario limit 1;";
			$consulta = $pdo->prepare( $sql );
            $consulta->bindValue(":codigo_horario",$codigo_horario);

            $consulta->execute();
            $dados = $consulta->fetch(PDO::FETCH_OBJ);

            $limite = $dados->limite;
        
            if (empty ($codigo_aluno)){

                $sql = "select count(codigo_aluno) as atual from Aluno where Horario_codigo_horario = :codigo_horario";
                $consulta = $pdo->prepare( $sql );
                $consulta->bindValue(":codigo_horario",$codigo_horario);
                $consulta->bindValue(":codigo_aluno",$codigo_aluno);

            } else  {
               
                $sql = "select count(codigo_aluno) as atual from Aluno where codigo_aluno <> :codigo_aluno and Horario_codigo_horario = :codigo_horario";
                $consulta = $pdo->prepare( $sql );
                $consulta->bindValue(":codigo_horario",$codigo_horario);
                $consulta->bindValue(":codigo_aluno",$codigo_aluno);
            }

            $consulta->execute();
            $dados = $consulta->fetch(PDO::FETCH_OBJ);

            $atual = $dados->atual;

            if($atual >= $limite) {
                $titulo = "Horário indisponível";
                $mensagem = "O horário selecionado já atingiu o nº máximo de alunos!";
                errorBack( $titulo, $mensagem );
                exit;
            }

        }

        if(ValidaData($data_nascimento) == true){
          
            $data = $data_nascimento;
        
            // Separa em dia, mês e ano
            list($dia, $mes, $ano) = explode('/', $data);
        
            // Descobre que dia é hoje e retorna a unix timestamp
            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            // Descobre a unix timestamp da data de nascimento do fulano
            $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
        
            // Depois apenas fazemos o cálculo já citado :)
            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

            if ($idade > 100 || $idade < 8){
                $titulo = "";
                $mensagem = "Informe uma Data válida";
                errorBack( $titulo, $mensagem );
                exit;
            }

        } else {
            $titulo = "Data inválida";
            $mensagem = "";
            errorBack( $titulo, $mensagem );
            exit;
        }

        $data_nascimento = formataData($data_nascimento);

        $data_cadastro = date('Y/m/d');

           // *****************START TRANSACTION************************
           $pdo->beginTransaction();

         
           if ( !empty ($codigo_aluno)){

            //echo "<p class='text-center'>$codigo_aluno</p>";
            //exit;
            $sql = "

            UPDATE Aluno as a JOIN Endereco as e JOIN Telefone as t SET
            a.nome_aluno =  :nome_aluno, 
            a.data_nasc  = :data_nasc, 
            a.sexo       =   :sexo, 
            a.rg         =  :rg, 
            a.cpf  = :cpf, 
            a.objetivo  = :objetivo, 
            a.email  = :email, 
            a.ativo  = :ativo,
            a.Horario_codigo_horario = :codigo_horario, 
               
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
            $consulta->bindValue(":estado",$estado);
            $consulta->bindValue(":cidade",$cidade);
            $consulta->bindValue(":bairro",$bairro);
            $consulta->bindValue(":rua",$rua);
            $consulta->bindValue(":numero",$numero);

            // Tabela Aluno
            $consulta->bindValue(":codigo_aluno",$codigo_aluno);
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


           } else if (empty ($codigo_aluno) ) {

            //echo "<p class='text-center'>esta setado? -> $codigo_aluno</p>";
            //exit;
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
                data_cadastro,
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
               :data_cadastro,
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
               $consulta->bindValue(":data_cadastro",$data_cadastro);
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
   
           } else {
                $mensagem = "Parâmetros inválidos!";
                errorBack( $titulo, $mensagem );
                exit;
           }
           
           if ( $consulta->execute() ) {
               // COMMIT
               $pdo->commit();
               // ALERTA
               $mensagem = "Aluno registrado com sucesso!";
               $link = "listar/aluno";
               sucessLink($titulo, $mensagem, $link);
   
           } else {
               // ROLLBACK
               $pdo->rollBack();
               //echo $consulta->errorInfo()[2];
               // ALERTA
               $mensagem = "Erro ao registrar aluno!";
               errorBack( $titulo, $mensagem );
               exit;
           }

    } else {
        // ALERTA
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }
