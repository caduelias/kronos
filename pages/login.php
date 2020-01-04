<?php
    // EFETUAR LOGIN E INICIAR SESSÃO
    include "config/conexao.php";
    include "config/funcoes.php";
	
  if ( $_POST ) 
  {
      $login = $senha = "";

      if ( isset ( $_POST["login"] ) )
        $login = trim ( $_POST["login"] );

      if ( isset ( $_POST["senha"] ) )
        $senha = trim ( $_POST["senha"]);
      
        if ( empty( $login ) ) {
          $titulo = "Preencha o Login!";
          toastLogin($titulo);    
        } else if (empty( $senha)) 
        { 
          $titulo = "Preencha a Senha!";
          toastLogin($titulo);   
        } else {
          $sql = "SELECT codigo_usuario, nome, login, senha, Perfil_codigo_perfil, status FROM Usuario WHERE login = ? LIMIT 1";
  
          $consulta = $pdo->prepare($sql);
          
          $consulta->bindParam(1, $login);
          
          $consulta->execute();
          
          $dados = $consulta->fetch(PDO::FETCH_OBJ); 

            if ( isset( $dados->codigo_usuario ) && ($dados->status == 1) ){
              
              if ( !password_verify($senha, $dados->senha) ) {
                $mensagem = "Senha Inválida!";
                error($titulo, $mensagem);
              } else {
                $_SESSION["user"] = array(
                  "codigo_usuario"=>$dados->codigo_usuario,
                  "nome"=>$dados->nome,
                  "perfil"=>$dados->Perfil_codigo_perfil
                );

                echo "<script>location.href='pages/home'</script>";
              }

            } else {
              // ERRO
              $mensagem = "Usuário Inexistente ou Desativado";
              error($titulo, $mensagem);
            }
        }
  }
  
?>

<body style="background: #000;">
  <div class="hold-transition">
    <div class="login-box">
      <div class="login-logo">
        <p class="text-light">Kronos</p>
      </div>
  
      <div class="card">
        <div class="card-body login-card-body bg-transparent">
          <p class="login-box-msg">Realize o login para iniciar a sessão!</p>

          <form name="login" action="" method="POST">

            <div class="input-group mb-3">
              <input type="text" class="form-control" id="login" name="login" placeholder="login" autofocus>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
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
                    Lembrar Senha
                  </label>
                </div>
              </div>
            </div>
            <div class="social-auth-links text-center mb-3">
              <button type="submit" class="btn btn-block btn-info">
                Login<i class="fas fa-sign-in-alt ml-2"></i>
              </button>
            </div>

          </form>
          <p class="mb-1">
            <a href="recuperar-senha.php">Esqueceu sua senha?</a>
          </p>

        </div>
      </div>
    </div>
  </div>
</body>
