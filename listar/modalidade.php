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
                    <h3 class="card-title text-uppercase">Modalidades Ativas</h3>
                </div>
                <div class="col">
                    <a  href="cadastros/modalidade" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-table"></i></a>
                    <a  href="listar/modalidade-inativo" class="btn btn-warning float-right m-1">Inativos <i class="ml-2 fas fa-list"></i></a>
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
                        <th width="40%">Descrição</th> 
                        <th width="20%">Ações</th>       
                    </tr>             
                </thead>
                <tbody>
                
                <?php
                	// SELECT DADOS TABELA MODALIDADE
					$sql = "SELECT * FROM Modalidade
                    WHERE ativo = 1
                    ORDER BY nome_modalidade";

                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) 
                    {

                    $codigo_modalidade 	= $linha->codigo_modalidade;
                    $nome_modalidade 	= $linha->nome_modalidade;
                    $descricao = $linha->descricao;
                    $ativo = $linha->ativo;

                    $codigo = base64_encode($codigo_modalidade);
                    
                        if ($ativo === '1')
                        {
                            $ativo = "<p class='text-success'>Ativo</p>";
                            echo "
                            <tr>
                                <td>$ativo</td>
                                <td class='text-uppercase'>$nome_modalidade</td>
                                <td class='text-uppercase'>$descricao</td>
                                <td class='text-center'> 
                                <a href='javascript:inativar($codigo_modalidade)' class='btn btn-danger m-1'><i class='fas fa-trash'></i></a>
                                <a href='cadastros/modalidade/$codigo' class='btn btn-info m-1'><i class='fas fa-pencil-alt'></i></a>
                                </td>
                            </tr>
                            ";
                        } 
                        
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
            title: 'Inativar Item?',
            text: "O item ficará inacessível!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                location.href='inativar/modalidade/'+codigo;
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

 