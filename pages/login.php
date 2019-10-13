<?php
    // EFETUAR LOGIN E INICIAR SESSÃO
    
    // INCLUIR ARQUIVO DE FUNÇÕES
    include "config/conexao.php";
    include "config/funcoes.php";
	
	// DADOS $_POST
  if ( $_POST ) {
      $login = $senha = "";
      if ( isset ( $_POST["login"] ) )
        $login = trim ( $_POST["login"] );
      if ( isset ( $_POST["senha"] ) )
        $senha = trim ( $_POST["senha"]);
      
       // verificar se os campos estão em preenchidos
        if ( empty( $login ) ) {
              $titulo = "Preencha o Login!";
              toastLogin($titulo);    
        } else if (empty( $senha)) { 
              $titulo = "Preencha a Senha!";
              toastLogin($titulo);   
        } else {
          // se os campos estiverem preenchidos, buscar usuario no banco
          $sql = "SELECT codigo_admin, nome, login, senha, tipo, ativo FROM Admin WHERE login = ? LIMIT 1";
          //preparar o sql para execução
          $consulta = $pdo->prepare($sql);
          //passar o parâmetro
          $consulta->bindParam(1, $login);
          //executar
          $consulta->execute();
          //recuperar os dados da consulta
          $dados = $consulta->fetch(PDO::FETCH_OBJ); 

            // se existir o CÓDIGO
            if ( isset( $dados->codigo_admin ) && ($dados->ativo == 1) ){
              //verificar se trouxe algum resultado	
              if ( !password_verify($senha, $dados->senha) ) {
                //verificar, se senha não é verdadeira
                $mensagem = "Senha Inválida!";
                error($titulo, $mensagem);
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
              //se não existir o código ou estiver inativo
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
    <p class="text-light">Nome Sistema</p>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body bg-transparent">
      <p class="login-box-msg">Realizar login para iniciar a sessão!</p>

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
          <!-- /.col -->
     
          <!-- /.col -->
        </div>
      
      <div class="social-auth-links text-center mb-3">
      <button type="submit" class="btn btn-block btn-info">
          Login  <i class="fas fa-sign-in-alt ml-2"></i>
  </button>
      </div>
      <!-- /.social-auth-links -->
      </form>
      <p class="mb-1">
        <a href="#">Esqueceu sua senha?</a>
      </p>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

  </div>
</body>
