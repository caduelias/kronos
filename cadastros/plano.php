<?php
  // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
  if ( file_exists ( "permissaoAdmin.php" ) )
    include "permissaoAdmin.php";
  else
    include "../permissaoAdmin.php";

  include "config/funcoes.php";

  $codigo_plano	= $ativo = $nome_plano = $taxa_adesao = $mensalidade = $descricao = "";

  if ( isset ($p[2]) ) 
  {
    $codigo_plano =  base64_decode($p[2]);

  // SELECT DADOS TABELA PLANO
  $sql = "SELECT * FROM Plano WHERE codigo_plano = :codigo_plano LIMIT 1";
          
  $consulta = $pdo->prepare( $sql );
  $consulta->bindValue(":codigo_plano",$codigo_plano);
  $consulta->execute();
      
  $dados = $consulta->fetch(PDO::FETCH_OBJ);

      $codigo_plano = $dados->codigo_plano;
      $ativo = $dados->ativo;
      $nome_plano = $dados->nome_plano;
      $taxa_adesao = $dados->taxa_adesao;
      $mensalidade = $dados->mensalidade;
      $descricao = $dados->descricao;

      $taxa_adesao = number_format($taxa_adesao,
      2,
      ',',
      '.');

      $mensalidade = number_format($mensalidade,
      2,
      ',',
      '.');
  }   

?>
<div class="content-wrapper">
  <form class="form-horizontal" name="plano" method="POST" action="salvar/plano" data-parsley-validate>
    <div class="card">
              <div class="card-header">
                  <div class="row">

                    <div class="col">
                        <h3 class="card-title text-uppercase">Cadastro Plano</h3>
                    </div>

                    <div class="col">
                      <a  href="listar/plano" class="btn btn-dark float-right m-1">Listar<i class="ml-2 fas fa-list"></i></a>
                    </div>

                  </div>
              </div>     
              <div class="card-body">

            <div class="row">

                <div class="col-6">

                  <div class="form-group">
                    <input type="hidden" class="form-control" name="codigo_plano" value="<?=$codigo_plano;?>">
                      <label for="plano">Nome do Plano:</label>
                      <input type="text" class="form-control" name="nome_plano" maxlength="40" value="<?=$nome_plano;?>" onkeypress="return ApenasLetras(event,this);" autofocus placeholder="Digite um nome" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">
                  </div>

                </div>

                <div class="col-6">
                <div class="form-group">
                  <label for="status">Status:</label>
                  <select id="ativo" class="form-control" name="ativo" required data-parsley-required-message="<i class='fas fa-times'></i> Selecione!">
                      <option value="">Selecione... </option>
                      <option value="1" selected>Ativo</option>
                      <option value="0">Inativo</option>  
                  </select>

                  <script type="text/javascript">
                      $("#ativo").val('<?=$ativo;?>');
                  </script>

                </div>
              </div>

            </div>

            <div class="row">

                  <div class="col-6">
                    <div class="form-group">
                      <label for="taxa">Taxa de adesão:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control" name="taxa_adesao" id="taxa" value="<?=$taxa_adesao;?>" placeholder="Taxa" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">      
                      </div>
                    </div>
                  </div>

                  <div class="col-6">

                    <div class="form-group">
                      <label for="valor">Valor da mensalidade:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control" name="mensalidade" id="valor" value="<?=$mensalidade;?>" placeholder="Valor" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">  
                      </div>
                    </div>
                  </div>

            </div>

                <div class="form-group">
                  <label>Descrição:</label>
                  <textarea class="form-control" rows="3" name="descricao" maxlength="240" placeholder="Sobre a plano..." ><?=$descricao;?></textarea> 
                </div>    
      
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-success float-right"><i class="fas fa-save mr-1"></i>Salvar</button>
              </div>
    </div>
  </form>
</div>

<script type="text/javascript">

		$("#valor").maskMoney({
			thousands: ".",
			decimal: ","
		});

    $("#taxa").maskMoney({
			thousands: ".",
			decimal: ","
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

