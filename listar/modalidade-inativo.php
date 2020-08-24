<?php
    
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";

?>
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
         
        <div class="row">
                <div class="col">
                    <h3 class="text-uppercase">Modalidades</h3>
                </div>
                <div class="col">
                    <a  href="cadastros/modalidade" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-table"></i></a>
                    <a  href="listar/modalidade" class="btn btn-dark float-right m-1"><i class="m-1 fas fa-list"></i><i class="m-1 fas fa-check"></i></a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="10%">Status</th> 
                        <th width="20%">Nome</th>
                        <th width="10%">Horário</th>
                        <th width="20%">Ações</th>       
                    </tr>             
                </thead>
                <tbody>
                
                <?php
                	// SELECT DADOS TABELA MODALIDADE
                    $sql = "SELECT m.*, h.* 
                    FROM Modalidade m
                    INNER JOIN Horario h on m.Horario_codigo_horario = h.codigo_horario
                    WHERE status = 2
                    ORDER BY nome_modalidade";

                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) 
                    {

                    $codigo_modalidade 	= $linha->codigo_modalidade;
                    $nome_modalidade 	= $linha->nome_modalidade;
                    $descricao = $linha->descricao;
                    $status = $linha->status;
                    $horario = $linha->horario_treino;
                    $periodo = $linha->periodo;

                    $modal = caracter($nome_modalidade);

                    $codigo = base64_encode($codigo_modalidade);

                    $status = "<p class='text-danger'>Inativo</p>";

                    if ($periodo == "1") {
                        $periodo = "Matutino";
                    } else if ($periodo == "2") {
                        $periodo = "Diurno";
                    } else if ($periodo == "3") {
                        $periodo = "Vespertino";
                    } else if ($periodo == "4") {
                        $periodo = "Noturno";
                    }

                    echo "
                        <tr>
                            <td class='text-uppercase'>$status</td>
                            <td class='text-uppercase'>$nome_modalidade</td>
                            <td>$horario</td>
                            <td class='text-center'>
                            <a href='javascript:ativar($codigo_modalidade)' class='btn btn-success m-1'><i class='fas fa-check'></i></a>
                            <a class='btn btn-default m-1' data-toggle='modal' data-target='#$modal'>
                                <i class='fas fa-folder-open'></i>
                            </a>
                            </td>
                        </tr>

                    <div class='modal' id='$modal' aria-hidden='true' style='display: none;'>
                        <div class='modal-dialog modal-xm'>
                            <div class='modal-content'>

                                <div class='modal-header'>

                                    <h4 class='modal-title'>$nome_modalidade</h4>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>×</span>
                                    </button> 

                                </div>

                                <div class='modal-body'>

                                    <div class='form-group mt-2'>
                                        <label>Período:</label>
                                        <div class='form-control'>$periodo</div>
                                    </div> 

                                    <div class='form-group mt-2'>
                                        <label>Descrição:</label>
                                        <textarea class='form-control' rows='5' readonly>$descricao </textarea>
                                    </div>  

                                </div>

                                <div class='modal-footer justify-content-between'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
                                </div>
                            
                            </div>
                        <!-- /.modal-content -->
                        </div>
                    <!-- /.modal-dialog -->
                    </div>
                    ";
                } 
                    ?>

                </tbody>
            </table>     
        </div>         
    </div>
</div>  

<!-- FUNÇÕES DE CONFIRMAÇÃO E CONFIGURAÇÕES DE TABELA -->
<script type="text/javascript">
    
    function ativar(codigo) {
        
        Swal.fire({      
            title: 'Ativar item?',
            text: "O item ficará disponível!",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                location.href='status/modalidade/'+codigo;
            }
        })
	
    }
    
	$(document).ready( function () {

	    $('.table').DataTable( {
            "language": {
                "lengthMenu": "Exibindo _MENU_ resultados por página",
                "zeroRecords": "Nenhum registro encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro adicionado!",
                "infoFiltered": "(filtrando de _MAX_ em um total de registros)",
                "search":"Buscar",
                paginate: {
                    previous: 'Anterior',
                    next:     'Próximo'
                },
                responsive: {
                    details: true
                }
            }
        });

    });
    
</script>

 