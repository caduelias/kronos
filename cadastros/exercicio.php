<?php

  // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
  if ( file_exists ( "verificaLogin.php" ) )
    include "verificaLogin.php";
  else
    include "../verificaLogin.php";

  include "config/funcoes.php";

?>
<div class="content-wrapper">
    <form class="form-horizontal" name="exercicio" method="POST" action="#" enctype="multipart/form-data" data-parsley-validate>           
      <div class="card-body">

      <div class="row">

      <?php

      $required = "";
      if ( empty ( $codigo_modalidade ) ) {
        $required = "required data-parsley-required-message=\"<i class='fas fa-times'></i> Selecione uma modalidade\" ";
      }

      ?>

        <div class="col-4">
          <div class="form-group">
              <label>Treino:</label>
              <select list="treinos" id="treino" placeholder="Selecione..." <?=$required;?> class="form-control" onblur="selecionaTreino(this.value)">
                <option value="">Selecione...</option>
                <datalist id="treinos">
                  <?php

                    $sql = "
                    
                      SELECT t.codigo_treino, t.nome_treino, m.nome_modalidade FROM Treino t, Modalidade m, Treino_Modalidade tm
                      WHERE t.codigo_treino = tm.Treino_codigo_treino AND tm.Modalidade_codigo_modalidade = m.codigo_modalidade
                       ORDER BY t.codigo_treino, m.nome_modalidade
                      
                      ";
                      $consulta = $pdo->prepare( $sql );
                      $consulta->execute();
                  
                      while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) 
                      {

                        echo "<option>$dados->codigo_treino - $dados->nome_treino - $dados->nome_modalidade </option>";

                      }
                    
                  ?>
                </datalist> 

              </select>
          </div>
        </div>

        <div class="col-2">
          <div class="form-group">
            <label>Código:</label>
            <input type="number" name="codigo_treino" id="codigo_treino" required data-parsley-required-message="<i class='fas fa-times'></i>" class="form-control"
            value="<?=$codigo_treino;?>" readonly>
          </div>
        </div>

        <div class="col-6">
          <div class="form-group">
            <label>Peso Inicial:</label>
              <select class="form-control" id="peso" name="peso_inicial">
                <option value="">Selecione...</option>
                <option value="5">5 KG</option>
                <option value="10">10 KG</option>
                <option value="15">15 KG</option>
                <option value="20">20 KG</option>
                <option value="25">25 KG</option>
              </select>

              <script type="text/javascript">
                $("#peso").val('<?=$peso_inicial;?>');
              </script>
          </div>
        </div>

      
      </div>

      <div class="row">

      <div class="col-4">
          <div class="form-group">
            <label>Duração:</label>  
              <input type="text" id="time" class="form-control" name="duracao" value="<?=$duracao;?>" placeholder="Horas:Minutos" maxlength="5" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha!" />
          </div>
        </div>

        <div class="col-4">
                <div class="form-group">
                        <label>Tipo:</label>
                        <select class="form-control" name="tipo" required data-parsley-required-message="<i class='fas fa-times'></i>Selecione!" >
                          <option value="">Selecione...</option>
                          <option value="1">Aparelho</option>
                          <option value="2">Aeróbico</option>
                          <option value="3">Anaeróbico</option>
                        </select>
                     
                      </div>

                    </div>

                    <div class="col-4">



                    <div class="form-group">
                        <label>Repetições:</label>
                        <select class="form-control" name="serie_repeticao" required data-parsley-required-message="<i class='fas fa-times'></i>Selecione!">
                          <option value="">Selecione...</option>
                          <option value="10">10x</option>
                          <option value="20">20x</option>
                          <option value="30">30x</option>
                          <option value="40">40x</option>
                        </select>
                    
                      </div>


                    </div>
      </div>         

                  <div class="form-group">
                  <input type="hidden" class="form-control" name="codigo_exercicio">
                    <label for="nome">Nome do Exercício:</label>
                    <input type="text" class="form-control" name="nome_exercicio" onkeypress="return ApenasLetras(event,this);" placeholder="Digite um nome" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">
               
                </div>

                  <div class="form-group">
                    <label for="exampleInputFile">Imagem</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="imagem" class="custom-file-input" accept=".jpg" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Selecionar arquivo</label>
                      </div>
                    </div>
                  </div>

                
                  <div class="form-group">
                        <label>Descrição:</label>
                        <textarea class="form-control" rows="3" name="descricao" placeholder="Sobre o exercício..."></textarea>
                    </div>    


                    <!-- time Picker -->
        
                  <!-- /.form group -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success float-right"><i class="fas fa-folder-plus"></i> Salvar</button>
                </div>



    </form>

    
                    </div>


<script type="text/javascript">

  function selecionaTreino(treino) {
    treino = treino.split(" - ");
    $("#codigo_treino").val(treino[0])
  }
  
  $(document).ready(function(){
  $('#time').mask('00:00');

});

function ApenasLetras(e, t) {
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        } else if (e) {
            var charCode = e.which;
        } else {
            return true;
        }
        if (
            (charCode > 8 && charCode < 46) ||
            (charCode > 64 && charCode < 91) || 
            (charCode > 96 && charCode < 123) ||
            (charCode > 191 && charCode <= 255) // letras com acentos
        ){
            return true;
        } else {
            return false;
        }
    } catch (err) {
        alert(err.Description);
    }
}
</script>
