 
<?php
	//conexão com banco PDO
	//Conexão Local
	$servidor = "localhost";
	$usuario = "root";
	$senha = "";
	//selecionar banco IMC
	$banco = "kronos_v1.1";
	
	$charset = "utf8";
	try {
		//CONEXAO PDO
		$pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=$charset", $usuario, $senha);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $erro) {
		$msg = $erro -> getMessage();
		echo "<p>Erro ao conectar no Banco: $msg</p>";
	}
?>