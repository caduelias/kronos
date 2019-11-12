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

        $cpf = validaCPF($cpf);

        $data_nascimento = formataData($data_nascimento);

        echo "<p class='text-center'>$codigo_modalidade $codigo_horario</p>";

        if ( empty ( $codigo_aluno ) ) {

			//se existe alguem, qualquer um, com o mesmo cpf
			$sql = "select id, nome from cliente where cpf = ? limit 1";
			$consulta = $pdo->prepare( $sql );
			$consulta->bindParam(1,$cpf);

		} else {

			//se existe alguem, menos ele mesmo, com o mesmo cpf
			$sql = "select id, nome from cliente where cpf = ? and id <> ? limit 1";
			$consulta = $pdo->prepare( $sql );
			$consulta->bindParam(1,$cpf);
			$consulta->bindParam(2,$id);

        }
        
    }
    else 
    {
        // ALERTA
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }
