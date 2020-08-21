<?php

  // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
      include "verificaLogin.php";
    else
      include "../verificaLogin.php";

    include "config/funcoes.php";

    if (isset($p[2]) && $p[2] != null ) {
      $codigo_aluno =  base64_decode($p[2]);
    
    $sql = "  SELECT 
                  a.*
              FROM aluno a
              WHERE a.codigo_aluno = :codigo_aluno LIMIT 1; 
    ";

    $consulta = $pdo->prepare($sql);
    $consulta->bindValue(":codigo_aluno",$codigo_aluno);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $aluno = $dados;

    print_r($aluno);

    } else {
      $titulo = "";
      $mensagem = "Selecione um aluno!";
      $link = "listar/aluno";
      errorLink( $titulo, $mensagem, $link );
  }

?>

<div class="content-wrapper">
             
    <div class="card">
      <div class="card-header">
        <h3 class="card-title text-uppercase">Cadastro Avaliação Física: <?=$aluno->nome_aluno;?></h3>
        <div class="float-right">
            <a href="listar/aluno" class="btn btn-dark float-right m-1">Listar alunos<i class="ml-2 fas fa-list"></i></a>
            <a class='btn btn-success m-1' data-toggle='modal' data-target='#modalavaliacao'>Nova avaliação<i class="ml-2 fas fa-clipboard"></i></a>
        </div>
      </div>  
          
      <div class="card-body">

      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        
      </div>
    </div>
  </form>
</div>

<div class='modal' id='modalavaliacao' aria-hidden='true' style='display: none;'>
          <div class='modal-dialog modal-xl'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h4 class='modal-title'>Aluno: <?=$aluno->nome_aluno;?></h4>
                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>×</span>
                  </button> 
                </div>

                <form class="form-horizontal" name="cadastroavaliacao" method="POST" action="salvar/avaliacao">     
                  <div class='modal-body'>
                  
                    <input type="hidden" class="form-control" name="codigo_aluno" value="<?=$codigo_aluno;?>"> 
                  
                    <div class="row">

                      <div class="col-3">
                        <div class="form-group">
                          <label for="peso">Peso:</label>
                          <input type="text" class="form-control" id="peso" name="peso" placeholder=""  required data-parsley-required-message="<i class='fas fa-times'></i> Informe o peso!">
                        </div>

                        <div class="form-group">
                          <label for="axilar">Axiliar média:</label>
                          <input type="text" class="form-control" id="axilar" name="axilar_media" placeholder=""  required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                        <div class="form-group">
                          <label for="abdominal">Abdominal:</label>
                          <input type="text" class="form-control" id="abdominal" name="abdominal" placeholder=""  required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                        <div class="form-group">
                          <label for="suprailiaca">Suprailíaca:</label>
                          <input type="text" class="form-control" id="suprailiaca" name="suprailiaca" placeholder=""  required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                        <div class="form-group">
                          <label for="coxa">Coxa:</label>
                          <input type="text" class="form-control" id="coxa" name="coxa" placeholder=""  required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                        <div class="form-group">
                          <label for="panturrilha">Panturrilha:</label>
                          <input type="text" class="form-control" id="panturrilha" name="panturrilha_medial" placeholder=""  required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                      </div>   

                      <div class="col-6">   
                        <div class="form-group">  
                          <img src="./imagens-exercicio/dobras.jpg" class="m-4 rounded mx-auto d-block" alt="dobras" title="Dobras cutâneas">
                        </div>
                      </div>

                      <div class="col-3">      
                      
                        <div class="form-group">
                            <label for="altura">Altura:</label>
                            <input type="text" class="form-control" id="altura" name="altura" placeholder="" required data-parsley-required-message="<i class='fas fa-times'></i> Informe a altura!">
                        </div>

                        <div class="form-group">
                          <label for="subescapular">Subescapular:</label>
                          <input type="text" class="form-control" id="subescapular" name="subescapular" placeholder=""  required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                        <div class="form-group">
                          <label for="triceps">Tríceps:</label>
                          <input type="text" class="form-control" id="triceps" name="triceps" placeholder=""  required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                      </div>

                    </div>

                  </div>
                  <div class='modal-footer'>
                    <button type="submit" class="btn btn-success float-right"><i class="fas fa-save mr-1"></i>Salvar</button>
                      <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
                  </div>
                </form>
              </div>
      </div>
  <!-- /.modal-content -->
  </div>
<!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	
$(document).ready(function(){
  $('#axilar').mask("00#,000", {reverse: true});
  $('#abdominal').mask("00#,000", {reverse: true});
  $('#suprailiaca').mask("00#,000", {reverse: true});
  $('#coxa').mask("00#,000", {reverse: true});
  $('#panturrilha').mask("00#,000", {reverse: true});
  $('#subescapular').mask("00#,000", {reverse: true});
  $('#triceps').mask("00#,000", {reverse: true});

  $('#altura').mask('0,00'); 

  $('#peso').mask("00#,000", {reverse: true});

});
</script>