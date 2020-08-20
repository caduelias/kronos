<?php
  // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
      include "verificaLogin.php";
    else
      include "../verificaLogin.php";

    include "config/funcoes.php";

    $nome_aluno = $objetivo = $data_nascimento = $sexo = $selects = "";

    if ( isset ($p[2]) ) {
      $codigo_aluno =  base64_decode($p[2]);
    
    $sql = "  SELECT 
                  a.*,
                  p.*
              FROM aluno a
                LEFT JOIN aluno_plano p ON p.codigo_aluno = a.codigo_aluno
              WHERE a.codigo_aluno = :codigo_aluno 
              LIMIT 1; 
    ";

    $consulta = $pdo->prepare($sql);
    $consulta->bindValue(":codigo_aluno",$codigo_aluno);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    // Tabela aluno e aluno_plano
   
    $nome_aluno = $dados->nome_aluno ?? null;
    $objetivo = $dados->objetivo ?? null;
    $data_nascimento = $dados->data_nasc ?? null;
    $sexo = $dados->sexo ?? null;
    $codigo_plano = $dados->codigo_plano ?? null;

    $sql2 = " SELECT 
              codigo_modalidade
            FROM aluno_modalidade m
            WHERE m.codigo_aluno = :codigo_aluno";

    $consulta = $pdo->prepare( $sql2 );
    $consulta->bindValue(":codigo_aluno", $codigo_aluno);
    $consulta->execute();
    $data = $consulta->fetchAll(PDO::FETCH_OBJ);

    // Tabela aluno_modalidade
    $codigos_modalidades = null;
    $modalidades = $data ?? null;

    if ($modalidades) {
      foreach($modalidades as $codigo_modalidade) {
        $codigos_modalidades .= $codigo_modalidade->codigo_modalidade;
        $codigos_modalidades .= ",";
      }
      $codigos_modalidades = rtrim($codigos_modalidades, ',');
    }

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
  <form class="form-horizontal" name="gerenciaraluno" method="POST" action="gerenciar/aluno" data-parsley-validate>           
    <div class="card">
      <div class="card-header">
       
          <div class="row">
              <div class="col">
                  <h3 class="card-title text-uppercase">Gerenciar Aluno</h3>
              </div>
              <div class="col">
                  <a  href="cadastros/aluno" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-table"></i></a>
                  <a  href="listar/aluno" class="btn btn-dark float-right m-1">Listar<i class="ml-2 fas fa-list"></i></a>
              </div>
          </div>

          </div>
      <div class="card-body">

      <input type="hidden" class="form-control" name="codigo_aluno" value="<?=$codigo_aluno;?>">  
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
     
        <div class="row">
          <?php

            $requiredModalidade = "";
            if ( empty ( $modalidade ) ) {
              $requiredModalidade = "required data-parsley-required-message=\"<i class='fas fa-times'></i> Selecione\" ";
            }

          ?>
          <div class="col-6">
              <div class="form-group">
                <label>Modalidade:</label>
                <select class="form-control select2" style="width: 100%;" name="modalidade[]" list="modalidades" id="modalidades" multiple="multiple" placeholder="Selecione" <?=$requiredModalidade;?>>
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
              
                  $("#modalidades").val([<?=$codigos_modalidades;?>]);

                </script>

              </div>
          </div>

          <?php

            $requiredPlano = "";
            if ( empty ( $codigo_plano ) ) {
              $requiredPlano = "required data-parsley-required-message=\"<i class='fas fa-times'></i> Selecione\" ";
            }

          ?>

          <div class="col-4">
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
      


        <?php

        if ($codigos_modalidades && $codigo_plano) {
          echo "
            <div class='col-2'>
            <div class='form-group'>
              <label>Exercicios:</label>
              <a target='_blank' class='form-control btn btn-info' data-toggle='modal' data-target='#exercicio'>
              <i class='fas fa-running'>
              </i><i class='ml-2 fas fa-dumbbell'></i>
              <i class='ml-2 fas fa-walking'></i>
              </a>
            </div>
            </div>
          ";
        }

        ?>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        <button type="submit" class="btn btn-success float-right"><i class="fas fa-save mr-1"></i>Salvar</button>
      </div>
    </div>
  </form>
</div>

<?php
    if ($codigos_modalidades && $codigo_plano) {
?>
<div class='modal' id='exercicio' aria-hidden='true' style='display: none;'>
          <div class='modal-dialog modal-xl'>
              <div class='modal-content'>

                  <div class='modal-header'>

                      <h4 class='modal-title text-uppercase'>cadastro exercícios do aluno</h4>
                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                          <span aria-hidden='true'>×</span>
                      </button> 

                  </div>
                  <div class='modal-body'>
                  <form class="form-horizontal" name="gerenciarexercicios" method="POST" action="gerenciar/exercicio">     
                  <input type="hidden" class="form-control" name="codigo_aluno" value="<?=$codigo_aluno;?>"> 
                  <?php
                      $sql = "
                            SELECT 
                              m.codigo_modalidade,
                              m.nome_modalidade,
                              t.codigo_treino,
                              t.nome_treino
                            FROM modalidade m 
                              INNER JOIN treino_modalidade tm ON tm.Modalidade_codigo_modalidade = m.codigo_modalidade 
                              INNER JOIN treino t ON t.codigo_treino = tm.Treino_codigo_treino
                              WHERE tm.Modalidade_codigo_modalidade IN($codigos_modalidades) order by m.nome_modalidade
                      ";

                      $consulta = $pdo->prepare($sql);
                      $consulta->execute();
                      $dados = $consulta->fetchAll(PDO::FETCH_OBJ);

                      $modalidades = $dados ?? null;

                      $codigos_treinos = null;
                      if ($modalidades) {
                        foreach($modalidades as $modalidade) {
                          $codigos_treinos .= $modalidade->codigo_treino;
                          $codigos_treinos .= ",";
                        }
                        $codigos_treinos = rtrim($codigos_treinos, ',');
                      }
                
                      $sql = "
                            SELECT 
                              ae.*
                            FROM aluno_exercicio ae 
                              WHERE ae.codigo_aluno = $codigo_aluno
                      ";

                      $consulta = $pdo->prepare($sql);
                      $consulta->execute();
                      $dados = $consulta->fetchAll(PDO::FETCH_OBJ);

                      $exercicios_old = "";
                      if ($dados) {
                        foreach($dados as $old) {
                          $exercicios_old .= $old->codigo_exercicio;
                          $exercicios_old .= ",";
                        }
                        $exercicios_old = rtrim($exercicios_old, ',');
                      }
                    
                      foreach($modalidades as $modalidade) {
                      
                        $selects .= '
                        <div class="card card-default">
                          <div class="card-header text-light bg-dark">
                          <h6 class="text-center">
                            Modalidade: '.$modalidade->nome_modalidade.' | Treino: '.$modalidade->nome_treino.'
                          </h6>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                          </div>
                        
                        <div class="card-body">
                          <div class="form-group">  
                          <select class="duallistbox form-control" size="10" name="exercicios[]" multiple="multiple">
                        ';

                        $sql = "
                          SELECT e.* FROM exercicio e 
                            INNER JOIN treino t ON t.codigo_treino = e.Treino_codigo_treino
                          WHERE e.Treino_codigo_treino = $modalidade->codigo_treino AND t.status = 1
                          ORDER BY e.nome_exercicio
                        ";
                        $consulta = $pdo->prepare($sql);
                        
                        $consulta->execute();
                
                        $dados = $consulta->fetchAll(PDO::FETCH_OBJ);
                       
                        if ($dados) {
                            foreach($dados as $exercicio) {
                              // var_dump($exercicio);
                             
                              $peso = " - ". $exercicio->peso_inicial . "Kg" ?? null;
                              $selects .= '
                                <option value="'.$exercicio->codigo_exercicio.'">'.$exercicio->nome_exercicio.$peso.'</option>
                              ';
                            }
                        }

                        $selects .= '
                          </select>
                          </div>    
                        </div>      
                        </div>
                        <script type="text/javascript">
                          $(".duallistbox").val(['.$exercicios_old.']);
                        </script>
                        ';

                      }
                      echo $selects;
                    ?>
                    
                      <div class='modal-footer'>
                      <button type="submit" class="btn btn-success float-right"><i class="fas fa-save mr-1"></i>Salvar exercícios</button>
                        <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
                      </div>
                    </form>
                  </div>
      </div>
  <!-- /.modal-content -->
  </div>
<!-- /.modal-dialog -->
</div>
                    
<script>
var selectCustom = $('.duallistbox').bootstrapDualListbox({
  filterTextClear:'Todos',
  filterPlaceHolder:'Filtrar',
  moveSelectedLabel:'Mover selecionado',
  moveAllLabel:'Mover todos',
  removeSelectedLabel:'Remover selecionado',
  infoTextEmpty:'Sem exercícios', 
  infoTextFiltered: '<span class="badge badge-warning">Filtrando</span> {0} de {1} exercícios',
  removeAllLabel:'Remover todos',
  infoText:'Exibindo {0} exercícios',
  nonSelectedListLabel: 'Exercícios não selecionados',
  selectedListLabel: 'Exercícios selecionados',
  preserveSelectionOnMove: 'moved',
  btnClass: 'btn-outline-dark',
  btnMoveText: '<span class="text-success">Adicionar</span>',    
  btnRemoveText: '<span class="text-danger">Remover</span>',
  btnMoveAllText: '<span class="text-success">Adiconar todos</span>',    
  btnRemoveAllText: '<span class="text-danger">Remover todos</span>', 
  moveOnSelect: false
});
</script>

<?php
  }
?>