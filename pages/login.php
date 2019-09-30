<?php
    // EFETUAR LOGIN E INICIAR SESSÃO
    
    // INCLUIR ARQUIVO DE FUNÇÕES
    include "config/conexao.php";
	
	// DADOS $_POST
	if ( $_POST ) {
		$nome = $senha = "";
		if ( isset ( $_POST["nome"] ) )
			$nome = trim ( $_POST["nome"] );
		if ( isset ( $_POST["senha"] ) )
			$senha = trim ( $_POST["senha"]);
		
		//verificar se os campos estão em branco
		if ( empty( $nome ) ) {
            echo "Preencha o Login!";
           // alerta($mensagem);    
		} else if (empty( $senha)) { 
            echo "Preencha a Senha!";
           // alerta($mensagem);
        } else {
            //se os campos estiverem preenchidos, buscar usuario no banco
			$sql = "select codigo_admin, nome, senha, tipo, ativo from Admin where nome = ? limit 1";
			//preparar o sql para execução
			$consulta = $pdo->prepare($sql);
			//passar o parâmetro
			$consulta->bindParam(1, $nome);
			//executar
			$consulta->execute();
			//recuperar os dados da consulta
			$dados = $consulta->fetch(PDO::FETCH_OBJ); 
			//se existir o id
			if ( isset( $dados->codigo_admin ) && ($dados->ativo == 1) ){
				//verificar se trouxe algum resultado	
				if ( !password_verify($senha, $dados->senha) ) {
					//verificar, se senha não é verdadeira
					echo "Senha Inválida!";
				} else {
					//guardar dados na sessão
					$_SESSION["admin"] = array(
						"codigo_admin"=>$dados->codigo_admin,
                        "nome"=>$dados->nome,
                        "tipo"=>$dados->tipo,
					);
					//verificar array
					//print_r( $_SESSION["admin"] );
					//redirecionar a tela para home com js
					echo "<script>location.href='pages/home'</script>";
					exit;
				}
			} else {
				//se não existir o id
				echo "Usuário Inexistente ou Desativado";
				
			}      
        }
    }
?>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Admin</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form name="login_admin" action="" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="nome" placeholder="login">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="senha" placeholder="senha">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->


</body>
