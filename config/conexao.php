 
<?php
	//conexão com banco PDO
	//Conexão Local
	$servidor = "localhost";
	$usuario = "admin";
	$senha = "123";
	//selecionar banco IMC
	$banco = "kronos_v1.1";
	
	$charset = "utf8";
	try {
		//CONEXAO PDO
		$pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=$charset", $usuario, $senha);
	} catch (PDOException $erro) {
		$msg = $erro -> getMessage();
		echo "<p>Erro ao conectar no Banco: $msg</p>";
	}
?>