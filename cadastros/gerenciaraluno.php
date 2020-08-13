<?php
  // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
      include "verificaLogin.php";
    else
      include "../verificaLogin.php";

    include "config/funcoes.php";

    $nome_aluno = $objetivo = $data_nascimento = $sexo = "";

    if ( isset ($p[2]) ) {
      $codigo_aluno =  base64_decode($p[2]);
    
    $sql = "  SELECT 
                  a.*
              FROM aluno a
              WHERE a.codigo_aluno = :codigo_aluno 
              LIMIT 1; 
    ";

    $consulta = $pdo->prepare( $sql );
    $consulta->bindValue(":codigo_aluno",$codigo_aluno);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    // Tabela Aluno
    $nome_aluno = $dados->nome_aluno ?? null;
    $objetivo = $dados->objetivo ?? null;
    $data_nascimento = $dados->data_nasc ?? null;
    $sexo = $dados->sexo ?? null;

    if ($sexo && $sexo == "F") {
        $sexo = "Feminino";
    } else if ($sexo == "M") {
      $sexo = "Masculino";
    }

  } else {
      $titulo = "";
      $mensagem = "Selecione um aluno!";
      $link = "listar/aluno";
      errorLink( $titulo, $mensagem, $link );
  }
?>
  <div class="content-wrapper">
  <form class="form-horizontal" name="gerenciaraluno" method="POST" action="" data-parsley-validate>           
    <div class="card">
      <div class="card-header">
       
          <div class="row">
              <div class="col">
                  <h3 class="card-title text-uppercase">Gerenciar Aluno</h3>
              </div>
              <div class="col">
                  <a  href="cadastros/aluno" class="btn btn-success float-right m-1">Novo aluno<i class="ml-2 fas fa-table"></i></a>
                  <a  href="listar/aluno" class="btn btn-dark float-right m-1">Listar alunos <i class="ml-2 fas fa-list"></i></a>
              </div>
          </div>

          </div>
      <div class="card-body">

      <div class="row">
            <div class="col-3">
              <div class="form-group">
                <label for="aluno">Aluno:</label>
                <input type="text" class="form-control" value="<?=$nome_aluno;?>" readonly>      
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="sexo">Gênero:</label>
                <input type="text" class="form-control" value="<?=$sexo;?>" readonly> 
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="objetivo">Objetivo:</label>
                <textarea class="form-control" rows="3" readonly><?=$objetivo;?></textarea>   
              </div>
            </div>
          </div>
     
        <?php

        $requiredModalidade = "";
        if ( empty ( $modalidade ) ) {
          $requiredModalidade = "required data-parsley-required-message=\"<i class='fas fa-times'></i> Selecione\" ";
        }

        ?>

        <div class="row">
          <div class="col-6">
              <div class="form-group">
                <label>Modalidade:</label>
                <select class="form-control select2" style="width: 100%;" name="modalidade[]" list="modalidades" id="modalidade" multiple="multiple" placeholder="Selecione..." <?=$requiredModalidade;?>>
                  <datalist id="modalidades">
                    <?php

                      $sql = "
                        SELECT codigo_modalidade, nome_modalidade FROM modalidade 
                        WHERE status = 1 ORDER BY codigo_modalidade
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
                  $("#modalidade").val('<?=$modalidade;?>');
                </script>

              </div>
          </div>

          <?php

            $requiredPlano = "";
            if ( empty ( $codigo_plano ) ) {
              $requiredPlano = "required data-parsley-required-message=\"<i class='fas fa-times'></i> Selecione\" ";
            }

          ?>

          <div class="col-6">
          <div class="form-group">
                <label>Plano:</label>
                <select class="form-control" name="codigo_plano" list="planos" id="codigo_plano" placeholder="Selecione..." <?=$requiredPlano;?>>
                  <option value="">Selecione...</option>
                  <datalist id="planos">
                    <?php

                      $sql = "
                        SELECT codigo_plano, nome_plano FROM plano 
                        WHERE status = 1 ORDER BY codigo_plano
                        ";
                        $consulta = $pdo->prepare( $sql );
                        $consulta->execute();
                    
                        while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) 
                        {

                          echo "<option value='$dados->codigo_plano'>$dados->nome_plano</option>";

                        }
                      
                    ?>
                  </datalist> 

                </select>

                <script type="text/javascript">
                  $("#codigo_plano").val('<?=$codigo_plano;?>');
                </script>

              </div>
          </div>
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
		
</script>