<?php 

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "verificaLogin.php" ) )
       include "verificaLogin.php";
    else
       include "../verificaLogin.php";

    include "config/funcoes.php";


	if ( isset ( $p[2] ) )
        $parametro = (int)$p[2];
        
    //$codigo =  base64_decode($param);

    if ( empty($parametro) ) 
    {
        $titulo = "Erro";
        $mensagem = "Parâmetros inválidos!";
        $link = "listar/horario";
        errorLink($titulo, $mensagem, $link);
        exit;
    }
    else 
    {
        $sql = "SELECT h.codigo_horario FROM Horario h, Aluno a ON a.Horario_codigo_horario = :aluno_horario WHERE h.codigo_horario = :codigo_horario";
        $consulta = $pdo->prepare( $sql );
        $consulta->bindValue(":aluno_horario",$parametro);
        $consulta->bindValue(":codigo_horario",$parametro);
    }

    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $codigo_horario = $dados->codigo_horario;

    if ( !isset ($codigo_horario) )
    {
        $sql = "
            DELETE FROM Horario 
            WHERE codigo_horario = :codigo_horario LIMIT 1
        ";

		$consulta = $pdo->prepare($sql);
		$consulta->bindValue(":codigo_horario",$parametro);

        if ( $consulta->execute() ) 
        {
            $mensagem = "Registro removido com sucesso!";
            $link = "listar/horario";
            sucessLink($titulo, $mensagem, $link);
        } 
        else 
        {
            $titulo = "";
            $mensagem = "Erro ao excluir registro!";
            $link = "listar/horario";
            errorLink($titulo, $mensagem, $link);
        }
        
    } 
    else 
    {
		$titulo = "Erro ao excluir";
        $mensagem = "Existem alunos registrados neste horário!";
        $link = "listar/horario";
        errorLink($titulo, $mensagem, $link);
    }
    