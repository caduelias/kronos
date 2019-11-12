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
                    <h4 class="text-uppercase">Horários</h4>
                </div>
                
                <div class="col-6">
                    <a  href="cadastros/horario" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-table"></i></a>
                </div>

            </div>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="10%">Horário</th> 
                        <th width="20%">Período</th>
                        <th width="5%">Limite</th>
                        <th width="15%">Ações</th>       
                    </tr>             
                </thead>
                <tbody>
                
            <?php
                // SELECT DADOS TABELA TREINO
                $sql = "
                
                SELECT * FROM Horario
                WHERE codigo_horario = codigo_horario
                ORDER by horario_treino;
                
                ";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) 
                {
                    
                    $codigo_horario = $linha->codigo_horario;
                    $horario_treino = $linha->horario_treino;
                    $limite 	= $linha->limite;
                    $periodo = $linha->periodo;
                
                    $codigo = base64_encode($codigo_horario);

                    if ($periodo == 1)
                    {
                        $periodo = "<i class='fas fa-sun mr-1'></i>Matutino";
                    } 
                    elseif ($periodo == 2)
                    {
                        $periodo = "<i class='fas fa-sun mr-1'></i>Diurno";
                    }
                    else if ($periodo == 3)
                    {
                        $periodo = "<i class='fas fa-moon mr-1'></i>Vespertino";
                    } 
                    else if ($periodo == 4)
                    {
                        $periodo = "<i class='fas fa-cloud-moon mr-1'></i>Noturno";
                    }
        
                    echo "
                        <tr>
                            <td class='text-uppercase'>$horario_treino</td>
                            <td class='text-uppercase'>$periodo</td>
                            <td class='text-uppercase'>$limite</td>
                            <td class='text-center'> 
                            <a href='javascript:excluir($codigo_horario)' class='btn btn-danger m-1'><i class='fas fa-trash'></i></a>
                            <a href='cadastros/horario/$codigo' class='btn btn-info m-1'><i class='fas fa-pencil-alt'></i></a>
                            </td>
                        </tr>
                            
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
            title: 'Deseja excluir horário?',
            text: "O horário será excluído permanentente!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Excluir!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
                preConfirm: () => {
                    location.href='excluir/horario/'+codigo;
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

 