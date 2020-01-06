<?php 

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "verificaLogin.php" ) )
       include "verificaLogin.php";
    else
       include "../verificaLogin.php";

    include "config/funcoes.php";

	if ( isset ( $p[2] ) )
        $parametro = (int)$p[2];

    if ( empty($parametro) ) {
        $titulo = "Horário não encontrado!";
        $mensagem = "Parâmetros inválidos!";
        $link = "listar/horario";
        errorLink($titulo, $mensagem, $link);
        exit;
    } else {
        $sql = "SELECT m.codigo_modalidade FROM Horario h
                INNER JOIN Modalidade m ON m.Horario_codigo_horario = h.codigo_horario 
                WHERE h.codigo_horario = :codigo_horario;
        ";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindValue(":codigo_horario",$parametro);

        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        $codigo_modalidade = $dados->codigo_modalidade;
    }

    if ( empty($codigo_modalidade) ) {
        $sql = "
            DELETE FROM Horario 
            WHERE codigo_horario = :codigo_horario LIMIT 1
        ";

		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo_horario",$parametro);

        if ($consulta->execute() ) {
            $mensagem = "Registro removido com sucesso!";
            $link = "listar/horario";
            sucessLink($titulo, $mensagem, $link);
        } else {
            $titulo = "";
            $mensagem = "Erro ao excluir registro!";
            $link = "listar/horario";
            errorLink($titulo, $mensagem, $link);
        }
        
    } else {
		$titulo = "Erro ao excluir";
        $mensagem = "Existem modalidades registradas neste horário!";
        $link = "listar/horario";
        errorLink($titulo, $mensagem, $link);
    }
    