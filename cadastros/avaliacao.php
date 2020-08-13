<?php

  // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
      include "verificaLogin.php";
    else
      include "../verificaLogin.php";

    include "config/funcoes.php";

?>

<div class="content-wrapper">
  <form class="form-horizontal" name="avaliacao" method="POST" action="" data-parsley-validate>           
    <div class="card">
      <div class="card-header">
       
          <div class="row">
              <div class="col">
                  <h3 class="card-title text-uppercase">Cadastro Avaliação Física</h3>
              </div>
              <div class="col">
                  <a  href="cadastros/aluno" class="btn btn-success float-right m-1">Novo aluno<i class="ml-2 fas fa-table"></i></a>
                  <a  href="listar/" class="btn btn-dark float-right m-1">Listar alunos <i class="ml-2 fas fa-list"></i></a>
              </div>
          </div>
      </div>  
          
      <div class="card-body">

      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button type="submit" class="btn btn-success float-right"><i class="fas fa-save mr-1"></i>Salvar</button>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
		
</script>