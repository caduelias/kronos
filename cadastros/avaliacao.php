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

    $sql = "
            SELECT 
                DATE_FORMAT(data_avaliacao, '%d/%m/%Y') as ultimaavaliacao,
                DATEDIFF(data_avaliacao, date_add(Now(), interval - 30 day)) as diasrestante
            FROM avaliacao
            WHERE data_avaliacao > DATE_ADD(Now(), INTERVAL - 30 DAY) 
            AND codigo_aluno = :codigo_aluno
            HAVING diasrestante >= 0
            LIMIT 1;
            ";
    $consulta = $pdo->prepare($sql);
    $consulta->bindValue(':codigo_aluno', $codigo_aluno);

    $consulta->execute();
    $ultima_avaliacao = $consulta->fetch(PDO::FETCH_OBJ);
    
    $data_ultima_avaliacao = $ultima_avaliacao->ultimaavaliacao ?? null;
    $dias_restante = $ultima_avaliacao->diasrestante ?? null;
    var_dump($data_ultima_avaliacao, $dias_restante);

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
      
        <?php
          if ($dias_restante && $dias_restante > 0) {
            echo "<div class='float-left'><h3 class='card-title text-uppercase'>Próxima avaliação disponível em:<a class='text-danger'> $dias_restante</a> dias!</h3></div>";
          } else {
            echo "<div class='float-left'><h3 class='card-title text-uppercase text-success'>Avaliação disponível!</h3></div>";
          }
        ?>
         
        <div class="float-right text-light">
            <a href="listar/aluno" class="btn btn-dark float-right m-1">Listar Alunos<i class="ml-2 fas fa-list"></i></a>
            <?php
                if (!$dias_restante && $dias_restante <= 0) {
                  echo "
                  <a class='btn btn-success m-1' data-toggle='modal' data-target='#modalavaliacao'>Nova Avaliação<i class='ml-2 fas fa-clipboard'></i></a>
                  ";
                }
            ?> 
        </div>
      </div>  
      
      <div class="card-body">
        <div class="float-left">
          <h6>Aluno: <strong><?=$aluno->nome_aluno;?></strong></h6>
        </div>
        
        <div class="float-right">
          <h6>Data da ultima avaliação: <strong><?=$data_ultima_avaliacao;?></strong></h6>
        </div>
      <table class="table table-bordered table-hover">
                <thead>
                
                    <tr class="text-center">
                        <th width="10%">Data avaliação</th> 
                        <th width="5%">IMC</th>
                        <th width="15%">Classificação</th>
                        <th width="10%">% Gordura</th>
                        <th width="10%">% Massa magra</th>
                        <th width="5%">Ações</th>       
                    </tr>             
                </thead>
                <tbody>
                
                <?php
                
					        $sql = "              
                        SELECT 
                        a.*,
                        date_format(a.data_avaliacao,'%d/%m/%Y') as data_avaliacao, 
                        at.*
                        FROM avaliacao a 
                        INNER JOIN antropometria at ON at.codigo_antropometria = a.codigo_antropometria
                        WHERE a.codigo_aluno = :codigo_aluno
                        ORDER BY data_avaliacao;
                    ";

                    $consulta = $pdo->prepare($sql);
                    $consulta->bindValue(":codigo_aluno", $codigo_aluno);
                    $consulta->execute();

                    $avaliacoes = $consulta->fetchAll(PDO::FETCH_OBJ);

                    //print_r($avaliacoes);
                    $codigo = base64_encode($codigo_aluno);

                    foreach ($avaliacoes as $avaliacao) {
                    
                      $modal = caracter($aluno->nome_aluno.$avaliacao->codigo_avaliacao);

                      $ficha = " 
                          <tr class='text-center'>
                            <td class='text-uppercase'>$avaliacao->data_avaliacao</td>
                            <td class='text-uppercase'>$avaliacao->imc</td>
                            <td class='text-uppercase'>$avaliacao->classificacao_imc</td>
                            <td class='text-uppercase'>$avaliacao->gordura %</td>
                            <td class='text-uppercase'>$avaliacao->massa_magra %</td>
                            <td class='text-center'> 
                              <a class='btn btn-default m-1' data-toggle='modal' data-target='#$modal'>
                              <i class='fas fa-clipboard'></i>
                              </a>
                            </td>
                        </tr>

                        <div class='modal' id='$modal' aria-hidden='true' style='display: none;'>
                            <div class='modal-dialog modal-xl'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <div class='modal-title text-uppercase'>
                                          <p>Aluno(a): $aluno->nome_aluno | Data da avaliação: $avaliacao->data_avaliacao</p>
                                        </div>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>×</span>
                                        </button> 
                                    </div>

                                    <div class='modal-body'>
                                    <div class='row'>

                                    <div class='col-4'>
                                      <div class='form-group'>
                                        <label for='peso'>Peso(kg):</label>
                                        <input class='form-control' placeholder='0' value='$avaliacao->peso' readonly>
                                      </div>
              
                                      <div class='form-group'>
                                        <label for='axilar'>Axiliar média(mm):</label>
                                        <input class='form-control' placeholder='0' value='$avaliacao->axilar_media' readonly>
                                      </div>
              
                                      <div class='form-group'>
                                        <label for='abdominal'>Abdominal(mm):</label>
                                        <input class='form-control' placeholder='0' value='$avaliacao->abdominal' readonly>
                                      </div>
              
                                      <div class='form-group'>
                                        <label for='suprailiaca'>Suprailíaca(mm):</label>
                                        <input class='form-control' placeholder='0' value='$avaliacao->suprailiaca' readonly>
                                      </div>
              
                                      <div class='form-group'>
                                        <label for='coxa'>Coxa(mm):</label>
                                        <input class='form-control' placeholder='0' value='$avaliacao->coxa' readonly>
                                      </div>
              
                                      <div class='form-group'>
                                        <label for='panturrilha'>Panturrilha(mm):</label>
                                        <input class='form-control' placeholder='0' value='$avaliacao->panturrilha_medial' readonly>
                                      </div>
              
                                    </div>   
              
                                    <div class='col-4'>      
                                    
                                      <div class='form-group'>
                                          <label for='altura'>Altura(Cm):</label>
                                          <input class='form-control' placeholder='0.00' value='$avaliacao->altura' readonly>
                                      </div>
              
                                      <div class='form-group'>
                                        <label for='subescapular'>Subescapular(mm):</label>
                                        <input class='form-control' placeholder='0' value='$avaliacao->subescapular' readonly>
                                      </div>
              
                                      <div class='form-group'>
                                        <label for='triceps'>Tríceps(mm):</label>
                                        <input class='form-control' placeholder='0' value='$avaliacao->triceps' readonly>
                                      </div>
              
                                    </div>

                                    <div class='col-4'>   

                                    <div class='form-group'>
                                      <label for='altura'>Densidade Corporal:</label>
                                      <input class='form-control' placeholder='0.00' value='$avaliacao->densidade_corporal' readonly>
                                    </div>

                                    <div class='form-group'>
                                      <label for='altura'>% Gordura:</label>
                                      <input class='form-control' placeholder='0.00' value='$avaliacao->gordura' readonly>
                                    </div>

                                    <div class='form-group'>
                                      <label for='altura'>% Massa Magra:</label>
                                      <input class='form-control' placeholder='0.00' value='$avaliacao->massa_magra' readonly>
                                    </div>

                                    <div class='form-group'>
                                      <label for='altura'>Idade:</label>
                                      <input class='form-control' placeholder='0.00' value='$avaliacao->idade anos' readonly>
                                    </div>

                                    <div class='form-group'>
                                      <label for='altura'>IMC:</label>
                                      <input class='form-control' placeholder='0.00' value='$avaliacao->imc' readonly>
                                    </div>

                                    <div class='form-group'>
                                      <label for='altura'>Classificação:</label>
                                      <input class='form-control' placeholder='0.00' value='$avaliacao->classificacao_imc' readonly>
                                    </div>

                                  </div>
              
                                  </div>
                                      
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                      ";
                   echo $ficha;
                              
                    } 
              
                    ?>

                </tbody>
            </table>     
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

                <form class="form-horizontal" name="cadastroavaliacao" method="POST" action="salvar/avaliacao" data-parsley-validate>     
                  <div class='modal-body'>
                  
                    <input type="hidden" class="form-control" name="codigo_aluno" value="<?=$codigo_aluno;?>"> 

                    <input type="hidden" class="form-control" name="data_nascimento" value="<?=$aluno->data_nasc;?>"> 

                    <input type="hidden" class="form-control" name="sexo" value="<?=$aluno->sexo;?>"> 
                  
                    <div class="row">

                      <div class="col-3">
                        <div class="form-group">
                          <label for="peso">Peso(kg):</label>
                          <input type="float" class="form-control" id="peso" name="peso" placeholder="0"  required data-parsley-required-message="<i class='fas fa-times'></i> Informe o peso!">
                        </div>

                        <div class="form-group">
                          <label for="axilar">Axiliar média(mm):</label>
                          <input type="text" class="form-control" id="axilar" name="axilar_media" placeholder="0"  required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                        <div class="form-group">
                          <label for="abdominal">Abdominal(mm):</label>
                          <input type="text" class="form-control" id="abdominal" name="abdominal" placeholder="0"  required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                        <div class="form-group">
                          <label for="suprailiaca">Suprailíaca(mm):</label>
                          <input type="text" class="form-control" id="suprailiaca" name="suprailiaca" placeholder="0"  required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                        <div class="form-group">
                          <label for="coxa">Coxa(mm):</label>
                          <input type="text" class="form-control" id="coxa" name="coxa" placeholder="0"  required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                        <div class="form-group">
                          <label for="panturrilha">Panturrilha(mm):</label>
                          <input type="text" class="form-control" id="panturrilha" name="panturrilha_medial" placeholder="0"  required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                      </div>   

                      <div class="col-6">   
                        <div class="form-group">  
                          <h5 class="text-center">Protocolo Petroski(1995)</h5>
                          <img src="./imagens-exercicio/dobras.jpg" class="m-4 pt-4 rounded mx-auto d-block" alt="dobras" title="Dobras cutâneas">
                        </div>
                      </div>

                      <div class="col-3">      
                      
                        <div class="form-group">
                            <label for="altura">Altura(Cm):</label>
                            <input type="float" class="form-control" id="altura" name="altura" placeholder="0.00" required data-parsley-required-message="<i class='fas fa-times'></i> Informe a altura!">
                        </div>

                        <div class="form-group">
                          <label for="subescapular">Subescapular(mm):</label>
                          <input type="text" class="form-control" id="subescapular" name="subescapular" placeholder="0" required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                        <div class="form-group">
                          <label for="triceps">Tríceps(mm):</label>
                          <input type="text" class="form-control" id="triceps" name="triceps" placeholder="0"  required data-parsley-required-message="<i class='fas fa-times'></i> Informe!">
                        </div>

                      </div>

                    </div>

                  </div>
                  <div class='modal-footer'>
                      <button type="submit" class="btn btn-success float-right" onclick="return verificaValor()"><i class="fas fa-save mr-1"></i>Salvar</button>
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
  $('#axilar').mask("0#.0", {reverse: true});
  $('#abdominal').mask("0#.0", {reverse: true});
  $('#suprailiaca').mask("0#.0", {reverse: true});
  $('#coxa').mask("0#.0", {reverse: true});
  $('#panturrilha').mask("0#.0", {reverse: true});
  $('#subescapular').mask("0#.0", {reverse: true});
  $('#triceps').mask("0#.0", {reverse: true});

  $('#altura').mask('0.00'); 

  $('#peso').mask("00#.00", {reverse: true});

});

function verificaValor(){
  var peso = cadastroavaliacao.peso.value;
  var altura = cadastroavaliacao.altura.value;
  var axilar = cadastroavaliacao.axilar.value;
  var abdominal = cadastroavaliacao.abdominal.value;
  var suprailiaca  = cadastroavaliacao.suprailiaca.value;
  var coxa = cadastroavaliacao.coxa.value;
  var panturrilha = cadastroavaliacao.panturrilha.value;
  var subescapular = cadastroavaliacao.subescapular.value;
  var triceps = cadastroavaliacao.triceps.value;

        const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                    
        })
    
        if(!peso || parseFloat(peso) == 0){
            Toast.fire({
                    type: 'error',
                    title: 'Informe um peso válido!'
                    
                })
            cadastroavaliacao.peso.focus();
            return false;
        }

        
        if(!altura || parseFloat(altura) == 0){
            Toast.fire({
                    type: 'error',
                    title: 'Informe uma altura válida!'
                    
                })
            cadastroavaliacao.altura.focus();
            return false;
        }

        if(!axilar || parseFloat(axilar) == 0){
            Toast.fire({
                    type: 'error',
                    title: 'Valor da dobra (Axiliar média) incorreto!'
                    
                })
            cadastroavaliacao.axilar.focus();
            return false;
        }

        if(!subescapular || parseFloat(subescapular) == 0){
            Toast.fire({
                    type: 'error',
                    title: 'Valor da dobra (Subescapular) incorreto!'
                    
                })
            cadastroavaliacao.subescapular.focus();
            return false;
        }

        if(!abdominal || parseFloat(abdominal) == 0){
            Toast.fire({
                    type: 'error',
                    title: 'Valor da dobra (Abdominal) incorreto!'
                    
                })
            cadastroavaliacao.abdominal.focus();
            return false;
        }

        if(!triceps || parseFloat(triceps) == 0){
            Toast.fire({
                    type: 'error',
                    title: 'Valor da dobra (Tríceps) incorreto!'
                    
                })
            cadastroavaliacao.triceps.focus();
            return false;
        }

        if(!suprailiaca || parseFloat(suprailiaca) == 0){
            Toast.fire({
                    type: 'error',
                    title: 'Valor da dobra (Suprailíaca) incorreto!'
                    
                })
            cadastroavaliacao.suprailiaca.focus();
            return false;
        }

        if(!coxa || parseFloat(coxa) == 0){
            Toast.fire({
                    type: 'error',
                    title: 'Valor da dobra (Coxa) incorreto!'
                    
                })
            cadastroavaliacao.coxa.focus();
            return false;
        }

        if(!panturrilha || parseFloat(panturrilha) == 0){
            Toast.fire({
                    type: 'error',
                    title: 'Valor da dobra (Panturrilha) incorreto!'
                    
                })
            cadastroavaliacao.panturrilha.focus();
            return false;
        }
    } 

</script>

<script type="text/javascript">
    
	$(document).ready( function () {

	    $('.table').DataTable( {
            "language": {
                "lengthMenu": "Exibindo _MENU_ resultados por página",
                "zeroRecords": "Nenhum registro encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro adicionado!",
                "infoFiltered": "(filtrando de _MAX_ em um total de registros)",
                "search":"Filtrar",
                paginate: {
                    previous: 'Anterior',
                    next:     'Próximo'
                },
                responsive: {
                    details: true
                }
            },
            dom: "<'row'<'col-md-3'B><'col-md-3'f><'col-md-3'><'col-md-3'l>><'row'<'col-md-12't>><'row'<'col-md-3'i><'col-md-6'><'col-md-3'p>>",
            buttons: [
                { text: '', extend: 'excel', className: 'btn btn-success fas fa-file-excel' },
                { text: '', extend: 'pdf', className: 'btn btn-danger fas fa-file-pdf' },
            ]
        });

    });
    
</script>