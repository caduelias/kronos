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
            
            $codigo_modalidade = $params['codigo_modalidade'] ?? null;

            if (isset($params['statusaluno'])) {
                $statusaluno = $params['statusaluno'];
            } else {
                $statusaluno = null;
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
                <h3 class="card-title text-uppercase">Modalidades e alunos</h3>
            </div>      
      
      </div>  
      
      <div class="card-body">
       
        <form class="form-horizontal" name="relatorio_modalidade" method="POST" action="" data-parsley-validate>     
           
            <div class="row">

            <div class="col-3">
                <div class="form-group">
                    <label>Modalidade(Opcional):</label>
                    <select list="modalidades" name="codigo_modalidade" class="form-control">
                        <option value="">Todas</option>
                        <?php
                            $sql = "
                            SELECT codigo_modalidade, nome_modalidade FROM Modalidade ORDER BY nome_modalidade
                            ";
                            $consulta = $pdo->prepare( $sql );
                            $consulta->execute();
                        
                            while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) 
                            {

                                echo "<option value='$dados->codigo_modalidade'>$dados->nome_modalidade</option>";

                            }
                            
                        ?>

                    </select>
                </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label for="status">Status Modalidade(Opcional):</label>
                        <select id="status" class="form-control" name="status">
                            <option value="" selected>Todos</option>
                            <option value="2">Modalidade Inativa</option>
                            <option value="1">Modalidade Ativa</option>    
                        </select>
                    </div> 
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label for="status">Situação Alunos(Opcional):</label>
                        <select id="status" class="form-control" name="statusaluno">
                            <option value="" selected>Todos</option>
                            <option value="1">Alunos Ativos</option>
                            <option value="2">Alunos Inativos</option>    
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
                            m.nome_modalidade, 
                            count(soma.codigo_aluno) as qtde, 
                            m.status ,
                            h.horario_treino
                        from modalidade m
                        INNER join (
                            select 
                                DISTINCT(am.codigo_aluno), 
                                am.codigo_modalidade 
                            from aluno_modalidade am 
                            inner join aluno a on a.codigo_aluno = am.codigo_aluno
                            where (case when :statusaluno is null then true else a.status = :statusaluno end)
                            GROUP by am.codigo_aluno, am.codigo_modalidade) soma on soma.codigo_modalidade = m.codigo_modalidade 
                            inner join horario h on h.codigo_horario = m.Horario_codigo_horario
                            WHERE (case when :codigo_modalidade is null then true else m.codigo_modalidade = :codigo_modalidade end) and
                            (case when :status is null then true else m.status = :status end)
                        GROUP by m.codigo_modalidade
                        order by m.nome_modalidade
                    ";

                    $consulta = $pdo->prepare($sql);
                  
                    if ($codigo_modalidade) {
                        $consulta->bindValue(":codigo_modalidade", $codigo_modalidade);
                    } else {
                        $consulta->bindValue(":codigo_modalidade", null);
                    }

                    if ($statusaluno) {
                        $consulta->bindValue(":statusaluno", $statusaluno);
                    } else {
                        $consulta->bindValue(":statusaluno", null);
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
                                    <th width='10%'>Modalidade</th> 
                                    <th width='10%'>Qtde de alunos</th>
                                    <th width='5%'>Horário</th>
                                    <th width='5%'>Situação</th>  
                                </tr>             
                            </thead>
                            <tbody>
                    ";

                foreach ($result as $modalidade) {

                    if ($modalidade->status == 1) {
                        $situacao = "<p class='text-success'>Ativo</p>";
                    } else if ($modalidade->status == 2) {
                        $situacao = "<p class='text-danger'>Inativo</p>";
                    } else {
                        $situacao = "<p class='text-danger'>Inativo</p>";
                    }
                    $table .= "
                    <tr class='text-center'>
                    <td class='text-uppercase'>$modalidade->nome_modalidade</td>
                    <td class='text-uppercase'>$modalidade->qtde</td>
                    <td class='text-uppercase'>$modalidade->horario_treino</td>
                    <td class='text-uppercase'>$situacao</td>
                    </tr>
                    
                    ";
                }

                $table .="
                </tbody>
                </table>           
                ";

                $filtros = 'Filtros: codigo_modalidade: '.$codigo_modalidade. ' Situacao modalidade: '.$status.' Situacao alunos: '.$statusaluno;
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
                    filename : 'modalidade_aluno' 
                },
                { 
                    text: '', 
                    extend: 'pdf', 
                    className: 'btn btn-danger fas fa-file-pdf', 
                    messageTop: '<?=$filtros;?>', 
                    title: 'Alunos por modalidade' , 
                    filename : 'modalidade_aluno' 
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