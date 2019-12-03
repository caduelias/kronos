<?php
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";
      
    $codigo_treino	= $nome_treino = $duracao = $descricao = $tipo_treino = $peso_inicial = "";

    if ( isset ($p[2]) ) 
    {
      $codigo_treino =  base64_decode($p[2]);

    // SELECT DADOS TABELA TREINO
		$sql = "SELECT t.*, tm.Modalidade_codigo_modalidade FROM Treino t, Treino_Modalidade tm WHERE t.codigo_treino = :codigo_treino 
    and tm.Treino_codigo_treino = :codigo_treino LIMIT 1";
            
		$consulta = $pdo->prepare( $sql );
		$consulta->bindValue(":codigo_treino",$codigo_treino);
    $consulta->execute();
        
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

        $codigo_modalidade = $dados->Modalidade_codigo_modalidade;
        $codigo_treino = $dados->codigo_treino;
        $nome_treino = $dados->nome_treino;
        $descricao = $dados->descricao;
        $tipo_treino = $dados->tipo_treino;

    }   

?>
  
<div class="content-wrapper">
  <form class="form-horizontal" name="treino" method="POST" action="salvar/treino" data-parsley-validate>           
  <div class="card">
        <div class="card-header">
         
        <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase">Cadastro Treino</h3>
                </div>
                <div class="col">
                    <a  href="cadastros/treino" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-table"></i></a>
                    <a  href="listar/treino" class="btn btn-dark float-right m-1">Listar <i class="ml-2 fas fa-list"></i></a>
                </div>
            </div>
        </div>  
        
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
              <label>Modalidade:</label>
              <select list="modalidades" id="modalidade" placeholder="Selecione..." <?=$required;?> class="form-control" onblur="selecionaModalidade(this.value)">
                <option value="">Selecione...</option>
                <datalist id="modalidades">
                  <?php

                    $sql = "
                    
                      SELECT codigo_modalidade, nome_modalidade FROM Modalidade 
                      WHERE ativo = 1 ORDER BY codigo_modalidade
                      
                      ";
                      $consulta = $pdo->prepare( $sql );
                      $consulta->execute();
                  
                      while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) 
                      {

                        echo "<option value='$dados->codigo_modalidade'>$dados->nome_modalidade</option>";

                      }
                    
                  ?>
                </datalist> 

              </select>

              <script type="text/javascript">
                $("#modalidade").val('<?=$codigo_modalidade;?>');
              </script>

          </div>
        </div>

        <div class="col-2">
          <div class="form-group">
            <label></label>
            <input type="hidden" name="codigo_modalidade" id="codigo_modalidade" required data-parsley-required-message="<i class='fas fa-times'></i>" class="form-control"
            value="<?=$codigo_modalidade;?>" readonly>
          </div>
        </div>

        <div class="col-6">

            <div class="form-group">
              <label>Tipo:</label>
              <select class="form-control" id="tipo" name="tipo_treino" required data-parsley-required-message="<i class='fas fa-times'></i> Selecione!" >
                <option value="">Selecione...</option>
                <option value="1">Metabólico</option>
                <option value="2">Hipertrofia</option>
                <option value="3">Intervalado</option>
                <option value="4">Funcional</option>
              </select>

              <script type="text/javascript">
                $("#tipo").val('<?=$tipo_treino;?>');
              </script>

            </div>
          
        </div>
        
      </div>

      <div class="form-group">
        <input type="hidden" class="form-control" name="codigo_treino" value="<?=$codigo_treino;?>" >
        <label for="nome">Nome do Treino:</label>
        <input type="text" class="form-control" name="nome_treino" onkeypress="return ApenasLetras(event,this);" value="<?=$nome_treino;?>" placeholder="Digite um nome" autofocus required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!" >
      </div>

      <div class="form-group">
        <label>Descrição:</label>
        <textarea class="form-control" rows="3" name="descricao" maxlength="250" placeholder="Sobre o treino..." ><?=$descricao;?></textarea>
      </div>    

    </div>
        
    <div class="card-footer">
      <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> Salvar</button>
    </div>

  </form>

</div>

<script type="text/javascript">
  function selecionaModalidade(modalidade) {
    modalidade = modalidade.split(" - ");
    $("#codigo_modalidade").val(modalidade[0])
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