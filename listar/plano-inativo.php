<?php
    
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "permissaoAdmin.php" ) )
        include "permissaoAdmin.php";
    else
        include "../permissaoAdmin.php";

    include "config/funcoes.php";

    $perfil = $_SESSION["user"]["perfil"];

?>
<div class="content-wrapper"> 
    <div class="card">
        <div class="card-header">

            <div class="row">

                <div class="col-6">
                    <h4 class="text-uppercase">Planos</h4>
                </div>
                
                <div class="col-6">
                    <a  href="cadastros/plano" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-file-invoice-dollar"></i></a>
                    <a  href="listar/plano" class="btn btn-dark float-right m-1"><i class="m-1 fas fa-list"></i><i class="m-1 fas fa-check"></i></a>
                </div>

            </div>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="20%">Status</th> 
                        <th width="20%">Plano</th>
                        <th width="10%">Mensalidade</th>
                        <th width="20%">Ações</th>       
                    </tr>             
                </thead>
                <tbody>
                
                <?php
                	// SELECT DADOS TABELA TREINO
					$sql = "
                    
                    SELECT * FROM Plano
                    WHERE codigo_plano = codigo_plano AND status = 0
                    ORDER by nome_plano;
                    
                    ";

                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) {
                    
                    $codigo_plano = $linha->codigo_plano;
                    $status = $linha->status;
                    $nome_plano 	= $linha->nome_plano;
                    $taxa_adesao = $linha->taxa_adesao;
                    $mensalidade = $linha->mensalidade;
                    $descricao = $linha->descricao;

                    $modal = caracter($nome_plano);

                    $codigo = base64_encode($codigo_plano);

                    $taxa_adesao = number_format($taxa_adesao,
                    2,
                    ',',
                    '.');

                    $mensalidade = number_format($mensalidade,
                    2,
                    ',',
                    '.');
                    
                    if ($status === '1'){
                        $status = "<p class='text-success'>Ativo</p>";
                    } else if ($status === '0')
                    {
                        $status = "<p class='text-danger'>Inativo</p>";
                    } 
                    
                    if ($perfil == "1") {
                        $opcaoDelete = "<a href='javascript:excluir($codigo_plano)' class='btn btn-danger m-1'><i class='fas fa-trash'></i></a>"; 
                    } else {
                        $opcaoDelete = "";
                    }
                        echo "
                        <tr>
                            <td class='text-uppercase'>$status</td>
                            <td class='text-uppercase'>$nome_plano</td>
                            <td class='text-uppercase'>R$$mensalidade</td>
                            <td class='text-center'>
                            <a href='javascript:inativar($codigo_plano)' class='btn btn-success m-1'><i class='fas fa-check'></i></a>
                            $opcaoDelete
                            <a class='btn btn-default m-1' data-toggle='modal' data-target='#$modal'>
                                <i class='fas fa-eye'></i>
                            </a>
                            </td>
                        </tr>

                    <div class='modal' id='$modal' aria-hidden='true' style='display: none;'>
                        <div class='modal-dialog modal-xm'>
                            <div class='modal-content'>

                                <div class='modal-header'>

                                    <h4 class='modal-title'>Plano $nome_plano</h4>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>×</span>
                                    </button> 

                                </div>

                                <div class='modal-body'>

                                    <div class='form-group'>
                                        <label for='taxa'>Taxa de adesão:</label>
                                        <input type='text' class='form-control' value='R$$taxa_adesao reais' readonly>  
                                    </div>
                                    <div class='form-group'>
                                        <label for='valor'>Valor da mensalidade:</label>
                                        <input type='text' class='form-control' value='R$$mensalidade reais' readonly>  
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

    function inativar(codigo) {
        
        Swal.fire({      
            title: 'Ativar Item?',
            text: "O item ficará disponível!",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                location.href='status/plano/'+codigo;
            }
        })
	
    }
    
    function excluir(codigo) {
        
        Swal.fire({        
            title: 'Deseja excluir plano?',
            text: "O plano será excluído permanentente!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Excluir!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
                preConfirm: () => {
                    location.href='excluir/plano/'+codigo;
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

 