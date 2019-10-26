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

                <div class="col-6">
                    <h4 class="text-uppercase">Exercícios</h4>
                </div>
                
                <div class="col-6">
                    <a  href="cadastros/exercicio" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-table"></i></a>
                    <a  href="listar/exercicio" class="btn btn-dark float-right m-1">Listar <i class="ml-2 fas fa-list"></i></a>
                </div>

            </div>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="10%">Treino</th> 
                        <th width="50%">Exercício</th>
                        <th width="20%">Ações</th>       
                    </tr>             
                </thead>
                <tbody>
                
                <?php
                	// SELECT DADOS TABELA TREINO
					$sql = "
                    
                    SELECT e.*, t.nome_treino FROM Exercicio e, Treino t
                    WHERE e.codigo_exercicio = e.codigo_exercicio and e.Treino_codigo_treino = t.codigo_treino
                    ORDER by e.nome_exercicio;
                    
                    ";

                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) 
                    {
                    
                    $codigo_exercicio = $linha->codigo_exercicio;
                    $nome_exercicio = $linha->nome_exercicio;
                    $nome_treino 	= $linha->nome_treino;
                    $arquivo = $linha->arquivo;
                
                    $descricao = $linha->descricao;
                    
                    $imagem = "./imagens-exercicio/".$arquivo."p.jpg";

                    $modal = caracter($nome_exercicio);

                    $codigo = base64_encode($codigo_exercicio);
                    
                    echo "
                        <tr>
                            <td class='text-uppercase'>$nome_treino</td>
                            <td class='text-uppercase'>$nome_exercicio</td>
                            <td class='text-center'> 
                            <a href='javascript:excluir($codigo_exercicio)' class='btn btn-danger m-1'><i class='fas fa-trash'></i></a>
                            <a href='cadastros/exercicio/$codigo' class='btn btn-info m-1'><i class='fas fa-pencil-alt'></i></a>
                            <a class='btn btn-default m-1' data-toggle='modal' data-target='#$modal'>
                            <i class='fas fa-bars'></i>
                            </a>
                            </td>
                        </tr>

                    <div class='modal' id='$modal' aria-hidden='true' style='display: none;'>
                        <div class='modal-dialog modal-xm'>
                            <div class='modal-content'>

                                <div class='modal-header'>

                                    <h4 class='modal-title'>$nome_exercicio</h4>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>×</span>
                                    </button> 

                                </div>

                                <div class='modal-body'>
                                    <label>Imagem</label>
                                    <div class='img-thumbnail text-center'>
                                    <img src='$imagem'>
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

    function excluir(codigo) {
        
        Swal.fire({        
            title: 'Deseja excluir Treino?',
            text: "O treino será excluído permanentente!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Excluir!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
                preConfirm: () => {
                    location.href='excluir/treino/'+codigo;
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

 