<?php
	$senha = "master";

	//criptografar
	$senhac = password_hash($senha, PASSWORD_DEFAULT);

	echo "<p>Senha: $senha <br>
	Senha criptografada: $senhac </p>"; 

	echo "<p>Senha informada: $nova</p>";

	if ( password_verify ( $senha, $senhac ) ) {
		var_dump($senhac);
	} else {
		echo "<p>A senha $nova é inválida</p>";
	}

?>