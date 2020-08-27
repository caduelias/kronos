<?php

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
      include "verificaLogin.php";
    else
      include "../verificaLogin.php";

    include "config/funcoes.php";

    try {
        $params = $_POST ?? null;

        if ($params) {
            $array_datas = explode('-', $params['periodo']);
            $data_inicial = date('Y-m-d', strtotime(str_replace('/', '-', $array_datas[0])));
            $data_final = date('Y-m-d', strtotime(str_replace('/', '-', $array_datas[1])));
        
            if (isset($params['sexo'])) {
                $sexo = $params['sexo'];
            } else {
                $sexo = null;
            }

            if (isset($params['categoria_idade'])) {
                $categoria_idade = $params['categoria_idade'];
            } else {
                $categoria_idade = 1;
            }

            if (isset($params['situacao_imc'])) {
                $situacao_imc = $params['situacao_imc'];
            } else {
                $situacao_imc = null;
            }

            if (isset($params['codigo_aluno'])) {
                $codigo_aluno = $params['codigo_aluno'];
            } else {
                $codigo_aluno = null;
            }

        }
        
    } catch (Exception $e) {
        $mensagem = $e->getMessage() . " - " . strval($e->getCode());
        errorBack(null, $mensagem);
    }
?>

<div class="content-wrapper">
             
    <div class="card">
      <div class="card-header">

            <div class="col">
                <h3 class="card-title text-uppercase">Situação dos alunos</h3>
            </div>      
      
      </div>  
      
      <div class="card-body">
       
        <form class="form-horizontal" name="relatorio_aluno" method="POST" action="" data-parsley-validate>     
           
            <div class="row">

                <div class="col-4">
                    <div class="form-group">
                        <label>Período:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="fas fa-calendar"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="periodo" name="periodo" readonly required data-parsley-required-message="Informe um período!">
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="sexo">Situação:</label>
                        <select class="form-control" name="situacao_imc">
                            <option value="1">Abaixo do peso</option>
                            <option value="2" selected>Peso Ideal</option>  
                            <option value="3">Sobrepeso</option>
                            <option value="4">Obesidade</option>
                        </select>
                    </div>
                </div>
   
                <div class="col-4">
                <div class="form-group ml-5">
                <label>Idade:</label>
                  <div class="radio">
                    <label>
                      <input type="radio" id="idade" name="categoria_idade" value="1" checked>
                      Adulto: idade <= 65 anos
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" id="idade" name="categoria_idade" value="2">
                      Idoso: idade > 65 anos
                    </label>
                  </div>
                </div>
                </div>

            
            </div>

            <div class="row">

                <div class="col-6">
                    <div class="form-group">
                        <label>Aluno(Opcional):</label>
                        <select list="alunos" name="codigo_aluno" class="form-control select2 select2-hidden-accessible">
                            <option value="">Todos</option>
                            <datalist id="alunos">
                            <?php
                                $sql = "
                                
                                SELECT 
                                    a.codigo_aluno, 
                                    a.nome_aluno, 
                                    a.cpf,
                                    YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.data_nasc))) AS idade
                                FROM aluno a
                                ORDER BY a.nome_aluno
                                
                                ";
                                $consulta = $pdo->prepare( $sql );
                                $consulta->execute();
                            
                                while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) 
                                {

                                echo "<option data-select2-id='$dados->codigo_aluno' value='$dados->codigo_aluno'>Nome : $dados->nome_aluno - CPF: $dados->cpf - Idade: $dados->idade</option>";

                                }   
                            ?>
                            </datalist> 
                        </select>
                        </div>
                    </div>
  
                    <div class="col-3">
                        <div class="form-group">
                            <label for="sexo">Gênero(Opcional):</label>
                            <select class="form-control" name="sexo">
                                <option value="" selected>Todos</option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>    
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-3 mt-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success ml-4 mt-4"><i class="fas fa-clipboard-list mr-1"></i>Consultar</button>
                        </div>
                    </div>
                </div>

            </form>
     
      </div>
      <!-- /.card-body -->
      <div class="card-footer">

    <?php 

    if ($params) {

                $sql = "
                    select 
                        a.codigo_aluno, 
                        a.nome_aluno,  
                        av.classificacao_imc,
                        av.idade,
                        av.peso,
                        av.altura,
                        av.imc,
                        av.gordura,
                        av.massa_magra,
                        DATE_FORMAT(av.data_avaliacao, '%d/%m/%Y') as data_avaliacao
                    from aluno a 
                        INNER join (
                                select 
                                DISTINCT(a.codigo_aluno)
                                from avaliacao a 
                                WHERE a.data_avaliacao BETWEEN :datainicial and :datafinal
                                and a.imc BETWEEN :mediaum and :mediadois ) alunos
                                on alunos.codigo_aluno = a.codigo_aluno
                        INNER join avaliacao av on av.codigo_aluno = a.codigo_aluno
                    WHERE av.imc BETWEEN :mediaum and :mediadois 
                    and (case when :idade is null then true else av.idade BETWEEN :idadeum and :idadedois end)
                    and (case when :sexo is null then true else a.sexo = :sexo end) 
                    and (case when :codigo_aluno is null then true else a.codigo_aluno = :codigo_aluno end) 
                    GROUP by a.codigo_aluno  
                ";
                    
                $consulta = $pdo->prepare($sql);
                $consulta->bindValue(":datainicial", $data_inicial);
                $consulta->bindValue(":datafinal", $data_final);

                if ($categoria_idade == 1) {

                    if ($situacao_imc == 1) {
                        $consulta->bindValue(":mediaum", 1);
                        $consulta->bindValue(":mediadois", 18.50);
                    } else if ($situacao_imc == 2) {
                        $consulta->bindValue(":mediaum", 18.50);
                        $consulta->bindValue(":mediadois", 24.99);
                    } else if ($situacao_imc == 3) {
                        $consulta->bindValue(":mediaum", 25.00);
                        $consulta->bindValue(":mediadois", 29.99);
                    } else if ($situacao_imc == 4) {
                        $consulta->bindValue(":mediaum", 30.00);
                        $consulta->bindValue(":mediadois", 99.99);
                    }

                    $consulta->bindValue(":idade", true);
                    $consulta->bindValue(":idadeum", 1);
                    $consulta->bindValue(":idadedois", 65);
                } else if ($categoria_idade == 2) {

                    if ($situacao_imc == 1) {
                        $consulta->bindValue(":mediaum", 1);
                        $consulta->bindValue(":mediadois", 22.00);
                    } else if ($situacao_imc == 2) {
                        $consulta->bindValue(":mediaum", 22.00);
                        $consulta->bindValue(":mediadois", 27.00);
                    } else if ($situacao_imc == 3) {
                        $consulta->bindValue(":mediaum", 27.00);
                        $consulta->bindValue(":mediadois", 99.99);
                    } else if ($situacao_imc == 4) {
                        $consulta->bindValue(":mediaum", 27.00);
                        $consulta->bindValue(":mediadois", 99.99);
                    }
                    $consulta->bindValue(":idade", true);
                    $consulta->bindValue(":idadeum", 66);
                    $consulta->bindValue(":idadedois", 100);
                }
                
                if ($sexo) {
                    $consulta->bindValue(":sexo",$sexo);
                } else {
                    $consulta->bindValue(":sexo", null);
                }

                if ($codigo_aluno) {
                    $consulta->bindValue(":codigo_aluno", $codigo_aluno);
                } else {
                    $consulta->bindValue(":codigo_aluno", null);
                }
            
                $consulta->execute();
    
                $alunos = $consulta->fetchAll(PDO::FETCH_OBJ);
    
                $sql = "
                select 
                    COUNT(a.codigo_aluno) as total
                from aluno a 
                    INNER join (
                            select 
                            DISTINCT(a.codigo_aluno) 
                            from avaliacao a 
                            WHERE a.data_avaliacao BETWEEN :datainicial and :datafinal) alunos
                            on alunos.codigo_aluno = a.codigo_aluno
                        INNER join avaliacao av on av.codigo_aluno = a.codigo_aluno
                    WHERE (case when :idade is null then true else av.idade BETWEEN :idadeum and :idadedois end)
                    and av.imc BETWEEN :mediaum and :mediadois
                    and (case when :sexo is null then true else a.sexo = :sexo end) 
                    and (case when :codigo_aluno is null then true else a.codigo_aluno = :codigo_aluno end) 
                ";
                
                $consulta = $pdo->prepare($sql);
                $consulta->bindValue(":datainicial", $data_inicial);
                $consulta->bindValue(":datafinal", $data_final);

                if ($categoria_idade == 1) {

                    if ($situacao_imc == 1) {
                        $consulta->bindValue(":mediaum", 1);
                        $consulta->bindValue(":mediadois", 18.50);
                    } else if ($situacao_imc == 2) {
                        $consulta->bindValue(":mediaum", 18.50);
                        $consulta->bindValue(":mediadois", 24.99);
                    } else if ($situacao_imc == 3) {
                        $consulta->bindValue(":mediaum", 25.00);
                        $consulta->bindValue(":mediadois", 29.99);
                    } else if ($situacao_imc == 4) {
                        $consulta->bindValue(":mediaum", 30.00);
                        $consulta->bindValue(":mediadois", 99.99);
                    }

                    $consulta->bindValue(":idade", true);
                    $consulta->bindValue(":idadeum", 1);
                    $consulta->bindValue(":idadedois", 65);
                } else if ($categoria_idade == 2) {

                    if ($situacao_imc == 1) {
                        $consulta->bindValue(":mediaum", 1);
                        $consulta->bindValue(":mediadois", 22.00);
                    } else if ($situacao_imc == 2) {
                        $consulta->bindValue(":mediaum", 22.00);
                        $consulta->bindValue(":mediadois", 27.00);
                    } else if ($situacao_imc == 3) {
                        $consulta->bindValue(":mediaum", 27.00);
                        $consulta->bindValue(":mediadois", 99.99);
                    } else if ($situacao_imc == 4) {
                        $consulta->bindValue(":mediaum", 27.00);
                        $consulta->bindValue(":mediadois", 99.99);
                    }
                    $consulta->bindValue(":idade", true);
                    $consulta->bindValue(":idadeum", 66);
                    $consulta->bindValue(":idadedois", 100);
                }
            
                if ($sexo) {
                    $consulta->bindValue(":sexo",$sexo);
                } else {
                    $consulta->bindValue(":sexo", null);
                }

                if ($codigo_aluno) {
                    $consulta->bindValue(":codigo_aluno", $codigo_aluno);
                } else {
                    $consulta->bindValue(":codigo_aluno", null);
                }
        
                $consulta->execute();

                $total = $consulta->fetch(PDO::FETCH_OBJ);

                $table = "
                <table class='table table-bordered table-hover'>
                        <thead>
                            <tr class='text-left'>
                                <th width='20%'>Aluno</th> 
                                <th width='5%'>Classificação</th>
                                <th width='5%'>Idade</th>
                                <th width='5%'>Peso</th> 
                                <th width='5%'>Altura</th> 
                                <th width='5%'>IMC</th>
                                <th width='5%'>% Gordura</th> 
                                <th width='5%'>% Massa Magra</th> 
                                <th width='5%'>Data avaliação</th> 
                            </tr>             
                        </thead>
                        <tbody>
                ";

                foreach ($alunos as $aluno) {

                    $table .= "
                    <tr class='text-left'>
                    <td class='text-uppercase'>$aluno->nome_aluno</td>
                    <td class='text-uppercase'>$aluno->classificacao_imc</td>
                    <td class='text-uppercase'>$aluno->idade</td>
                    <td class='text-uppercase'>$aluno->peso</td>
                    <td class='text-uppercase'>$aluno->altura</td>
                    <td class='text-uppercase'>$aluno->imc</td>
                    <td class='text-uppercase'>$aluno->gordura</td>
                    <td class='text-uppercase'>$aluno->massa_magra</td>
                    <td class='text-uppercase'>$aluno->data_avaliacao</td>
                    </tr>
                    
                    ";
                }

                $table .="
                </tbody>
                    <tfoot>
                        <tr>
                        <th colspan='9'>Total aluno(s) : $total->total</th>
                        </tr>
                    </tfoot>
                </table>
                                
                ";

                echo $table;

                $resultadoTotal = 'Total: '.$total->total. ' aluno(s)';
                $filtros = 'Filtros: Data_inicio:'.$data_inicial.' Data_fim:'.$data_final.' Idade:'.$categoria_idade.' Gênero:'.$sexo.' Situacao:'.$situacao_imc.' Aluno:'.$codigo_aluno;
    ?>

</div>

<script>
	$(document).ready( function () {

	    $('.table').DataTable( {
            "language": {
                "lengthMenu": "Exibindo _MENU_ resultados por página",
                "zeroRecords": "Nenhum registro encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro encontrado!",
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
                { 
                    text: '', 
                    extend: 'excel', 
                    className: 'btn btn-success fas fa-file-excel',
                    filename : 'situacao_aluno' 
                },
                { 
                    text: '', 
                    extend: 'pdf', 
                    className: 'btn btn-danger fas fa-file-pdf', 
                    messageTop: '<?=$filtros;?>', 
                    messageBottom : '<?=$resultadoTotal;?>', 
                    title: 'Situação alunos' , 
                    filename : 'situacao_aluno' 
                }
            ]
        });

    });
    
</script>

<?php 

    }
  
?>

<script type="text/javascript">
    $('.select2').select2()

    $('#periodo').daterangepicker(
        {
        locale : {
            applyLabel : 'Aplicar',
            cancelLabel : 'Cancelar',
            customRangeLabel : 'Selecionar uma data',
            separator: ' - '
        },
        ranges   : {
          'Hoje'       : [moment(), moment()],
          'Ontem'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Ultímos 7 dias' : [moment().subtract(6, 'days'), moment()],
          'Ultímos 30 dias': [moment().subtract(29, 'days'), moment()],
          'Esse mês'  : [moment().startOf('month'), moment().endOf('month')],
          'Mês Anterior'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate  : moment(),
        applyClass: 'btn-success',
        cancelClass: 'btn-danger'
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
      }
    );
</script>