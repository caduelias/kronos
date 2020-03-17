l<?php

require_once __DIR__ . '/vendor/autoload.php';
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/conexao.php";
    include "config/funcoes.php";

    $url = trim ($_GET["parametro"] );

    $parametros = explode("/", $url);

    $codigo_aluno = base64_decode($parametros[2]);
  
    $sql = "              
    SELECT 
    a.*,
    date_format(a.data_nasc,'%d/%m/%Y') as nascimento, 
    date_format(a.data_cadastro,'%d/%m/%Y') as cadastro,
    e.*,
    t.*
    FROM Aluno a 
    INNER JOIN Endereco e ON e.codigo_endereco = a.Endereco_codigo_endereco
    INNER JOIN Telefone t ON t.Aluno_codigo_aluno = a.codigo_aluno
    WHERE a.codigo_aluno = :codigo_aluno
    ORDER BY codigo_telefone;
";

$consulta = $pdo->prepare($sql);
$consulta->bindValue(":codigo_aluno",$codigo_aluno);
$consulta->execute();

while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) {
// Tabela Aluno
$codigo_aluno = $linha->codigo_aluno;
$data_cadastro = $linha->cadastro;
$nome_aluno = $linha->nome_aluno;
$data_nasc 	= $linha->nascimento;
$sexo = $linha->sexo;
$rg = $linha->rg;
$cpf = $linha->cpf;
$objetivo = $linha->objetivo;
$email = $linha->email;
$status = $linha->status;

// Tabela Endereco
$estado = $linha->estado;
$cidade = $linha->cidade;
$bairro = $linha->bairro;
$rua = $linha->rua;
$numero = $linha->numero;

// Tabela Telefone
$num_telefone = $linha->num_telefone;
$num_celular = $linha->num_celular;
}

k
echo "<div clkass='content-wrapper'> <iframe name='pdf' width='100%' height='500' src='http://172.17.0.1/kronos/pdf/documento.php?codigo=$codigo_aluno'></iframe></div>";
 
?>









   
   



