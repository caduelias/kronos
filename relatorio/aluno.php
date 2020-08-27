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

            if (isset($params['status'])) {
                $status = $params['status'];
            } else {
                $status = null;
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
                <h3 class="card-title text-uppercase">Alunos registrados</h3>
            </div>      
      
      </div>  
      
      <div class="card-body">
       
        <form class="form-horizontal" name="relatorio_aluno" method="POST" action="" data-parsley-validate>     
           
            <div class="row">

                <div class="col-3 pt-1">
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

                <div class="col-3 pt-1">
                    <div class="form-group">
                        <label for="status">Status(Opcional):</label>
                        <select id="status" class="form-control" name="status">
                            <option value="" selected>Todos</option>
                            <option value="2">Inativo</option>
                            <option value="1">Ativo</option>    
                        </select>
                    </div> 
                </div>

                <div class="col-3 pt-1">
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
                            count(a.codigo_aluno) as quantidade 
                        from aluno a 
                        where a.data_cadastro BETWEEN :data_inicial and :datafinal
                        and (case when :sexo is null then true else a.sexo = :sexo end) 
                        and (case when :status is null then true else a.status = :status end)
                    ";

                    $consulta = $pdo->prepare($sql);
                    $consulta->bindValue(":data_inicial", $data_inicial);
                    $consulta->bindValue(":datafinal", $data_final);

                    if ($sexo) {
                        $consulta->bindValue(":sexo", $sexo);
                    } else {
                        $consulta->bindValue(":sexo", null);
                    }

                    if ($status) {
                        $consulta->bindValue(":status", $status);
                    } else {
                        $consulta->bindValue(":status", null);
                    }
                
                    $consulta->execute();

                    $qtde = $consulta->fetch(PDO::FETCH_OBJ);

                    $sql = "
                    select 
                        a.*
                    from aluno a 
                    where a.data_cadastro BETWEEN :data_inicial and :datafinal
                    and (case when :sexo is null then true else a.sexo = :sexo end) 
                    and (case when :status is null then true else a.status = :status end)
                    order by a.nome_aluno
                ";
                    
                $consulta = $pdo->prepare($sql);
                $consulta->bindValue(":data_inicial", $data_inicial);
                $consulta->bindValue(":datafinal", $data_final);
                if ($sexo) {
                    $consulta->bindValue(":sexo", $sexo);
                } else {
                    $consulta->bindValue(":sexo", null);
                }
            
                if ($status) {
                    $consulta->bindValue(":status", $status);
                } else {
                    $consulta->bindValue(":status", null);
                }
               
                $consulta->execute();
    
                $result = $consulta->fetchAll(PDO::FETCH_OBJ);
    
                $table = "
                <table class='table table-bordered table-hover'>
                        <thead>
                            <tr class='text-center'>
                                <th width='10%'>Aluno</th> 
                                <th width='5%'>CPF</th>
                                <th width='5%'>Data cadastro</th>
                                <th width='5%'>Gênero</th>
                                <th width='5%'>Situação</th> 
                            </tr>             
                        </thead>
                        <tbody>
                ";

                foreach ($result as $aluno) {

                    if ($aluno->status == 1) {
                        $situacao = "<p class='text-success'>Ativo</p>";
                    } else if ($aluno->status == 2) {
                        $situacao = "<p class='text-danger'>Inativo</p>";
                    } else {
                        $situacao = "<p class='text-danger'>Inativo</p>";
                    }
                    $table .= "
                    <tr class='text-center'>
                    <td class='text-uppercase'>$aluno->nome_aluno</td>
                    <td class='text-uppercase'>$aluno->cpf</td>
                    <td class='text-uppercase'>$aluno->data_cadastro</td>
                    <td class='text-uppercase'>$aluno->sexo</td>
                    <td class='text-uppercase'>$situacao</td>
                    </tr>
                    
                    ";
                }

                $table .="
                </tbody>
                    <tfoot>
                        <tr>
                        <th id='total' colspan='5'>Total aluno(s) :$qtde->quantidade</th>
                        </tr>
                    </tfoot>
                </table>
                                
                ";

                $total = 'Total: '.$qtde->quantidade. ' aluno(s)';
                $filtros = 'Filtros: Data inicial: '.$data_inicial.' Data final: '.$data_final.' Gênero: '.$sexo.' Situacao: '.$status;
                echo $table;
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
                    filename : 'alunos' 
                },
                { 
                    text: '', 
                    extend: 'pdf', 
                    className: 'btn btn-danger fas fa-file-pdf', 
                    messageTop: '<?=$filtros;?>', 
                    messageBottom : '<?=$total;?>', 
                    title: 'Alunos registrados' , 
                    filename : 'alunos' 
                }
            ]
        });

    });
    
</script>

<?php 

    }
  
?>

<script type="text/javascript">
    
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