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
                    <h4 class="text-uppercase">Alunos</h4>
                </div>
                
                <div class="col-6">
                    <a  href="cadastros/aluno" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-table"></i></a>
                    <a  href="listar/aluno" class="btn btn-dark float-right m-1">Listar <i class="ml-2 fas fa-list"></i></a>
                </div>

            </div>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center">
                        <th width="10%">Status</th> 
                        <th width="20%">Aluno</th>
                        <th width="15%">CPF</th>
                        <th width="5%">Data</th>
                        <th width="20%">Ações</th>       
                    </tr>             
                </thead>
                <tbody>
                
                <?php
                	// SELECT DADOS TABELA TREINO
					$sql = "
                    
                    SELECT a.*, e.*, t.num_telefone, t.num_celular, date_format(a.data_nasc,'%d/%m/%Y') as nascimento, date_format(a.data_cadastro,'%d/%m/%Y') as data, h.horario_treino FROM Aluno a, Horario h, Endereco e, Telefone t
                    WHERE a.codigo_aluno = a.codigo_aluno and a.Horario_codigo_horario = h.codigo_horario and e.codigo_endereco = a.Endereco_codigo_endereco and a.codigo_aluno = t.Aluno_codigo_aluno
                    ORDER by codigo_aluno;
                    
                    ";

                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) 
                    {
                    // Tabela Aluno
                    $codigo_aluno = $linha->codigo_aluno;
                    $data_cadastro = $linha->data;
                    $nome_aluno = $linha->nome_aluno;
                    $data_nasc 	= $linha->nascimento;
                    $sexo = $linha->sexo;
                    $rg = $linha->rg;
                    $cpf = $linha->cpf;
                    $objetivo = $linha->objetivo;
                    $email = $linha->email;
                    $ativo = $linha->ativo;
                    
                    // Tabela Horario
                    $horario_treino = $linha->horario_treino;

                    // Tabela Endereco
                    $estado = $linha->estado;
                    $cidade = $linha->cidade;
                    $bairro = $linha->bairro;
                    $rua = $linha->rua;
                    $numero = $linha->numero;

                    // Tabela Telefone
                    $num_telefone = $linha->num_telefone;
                    $num_celular = $linha->num_celular;
                    
                    $modal = caracter($nome_aluno.$codigo_aluno);

                    $codigo = base64_encode($codigo_aluno);

                    if ($ativo === '1')
                    {
                        $ativo = "<p class='text-success'>Ativo</p>";
                    } else if ($ativo === '0')
                    {
                        $ativo = "<p class='text-danger'>Inativo</p>";
                    }
                    
                    echo "
                        <tr class='text-center'>
                            <td class='text-uppercase'>$ativo</td>
                            <td class='text-uppercase'>$nome_aluno</td>
                            <td class='text-uppercase'>$cpf</td>
                            <td class='text-uppercase'>$data_cadastro</td>
                            <td class='text-center'> 
                            <a href='cadastros/avaliacao/$codigo' class='btn btn-success m-1'><i class='fas fa-clipboard'></i></a>
                            <a href='cadastros/aluno/$codigo' class='btn btn-info m-1'><i class='fas fa-pencil-alt'></i></a>
                            <a class='btn btn-default m-1' data-toggle='modal' data-target='#$modal'>
                            <i class='fas fa-eye'></i>
                            </a>
                            </td>
                        </tr>

                    <div class='modal' id='$modal' aria-hidden='true' style='display: none;'>
                        <div class='modal-dialog modal-xl'>
                            <div class='modal-content'>

                                <div class='modal-header'>

                                    <h4 class='modal-title text-uppercase'>Aluno(a): $nome_aluno</h4>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>×</span>
                                    </button> 

                                </div>

                                <div class='modal-body'>
                                    <label class='text-uppercase'>Informações:</label>
                                    <div class='row'>
                                    
                                    <div class='col-4'>

                                        <div class='form-group mt-2'>
                                            <label>Status:</label>
                                            <div class='form-control'>$ativo</div>
                                        </div> 
                                        

                                        <div class='form-group mt-2'>
                                            <label>E-mail:</label>
                                            <input type='text' class='form-control' value='$email' readonly>
                                        </div> 
                                    </div>
                                    <div class='col-4'>
                                        <div class='form-group mt-2'>
                                            <label>CPF:</label>
                                            <input type='text' class='form-control' value='$cpf' readonly>
                                            
                                        </div>  

                                        <div class='form-group mt-2'>
                                            <label>RG:</label>
                                            <input type='text' class='form-control' value='$rg' readonly>
                                        </div>  
                                    </div>

                                    <div class='col-4'>
                                        <div class='form-group mt-2'>
                                            <label>Nascimento:</label>
                                            <input type='text' class='form-control' value='$data_nasc' readonly>
                                        </div>  

                                        <div class='form-group mt-2'>
                                            <label>Gênero:</label>
                                            <input type='text' class='form-control' value='$sexo' readonly>
                                        </div>  
                                    </div>
                                    </div>
                                    
                                    <div class='form-group mt-2'>
                                        <label>Objetivo:</label>
                                        <textarea class='form-control' rows='3' readonly>$objetivo </textarea>
                                    </div> 

                                    <hr>
                                    <div class='row'>
                                        <div class='col-4'>
                                            <div class='form-group mt-2'>
                                                <label>Horário Treino:</label>
                                                <input type='text' class='form-control' value='$horario_treino' readonly>
                                            </div>  
                                        </div>

                                        <div class='col-4'>
                                            <div class='form-group mt-2'>
                                                <label>Telefone:</label>
                                                <input type='text' class='form-control' value='$num_telefone' readonly>
                                            </div>  
                                        </div>
                                        <div class='col-4'>
                                            <div class='form-group mt-2'>
                                                <label>Celular:</label>
                                                <input type='text' class='form-control' value='$num_celular' readonly>
                                            </div>  
                                        </div>
                                    </div>

                                    <hr />
                                    <label class='text-uppercase'>Endereço:</label>
                                  
                                    <div class='row'>
                                        <div class='col-3'>
                                            <div class='form-group mt-2'>
                                                <label>Cidade:</label>
                                                <input type='text' class='form-control' value='$cidade' readonly>
                                            </div>  
                                        </div>

                                        <div class='col-3'>
                                            <div class='form-group mt-2'>
                                                <label>Estado:</label>
                                                <input type='text' class='form-control' value='$estado' readonly>
                                            </div>  
                                        </div>

                                        <div class='col-3'>
                                        <div class='form-group mt-2'>
                                            <label>Número:</label>
                                            <input type='text' class='form-control' value='$numero' readonly>
                                        </div>  
                                        </div>

                                        <div class='col-6'>
                                            <div class='form-group mt-2'>
                                                <label>Rua:</label>
                                                <input type='text' class='form-control' value='$rua' readonly>
                                            </div>  
                                        </div>

                                        <div class='col-6'>
                                        <div class='form-group mt-2'>
                                            <label>Bairro:</label>
                                            <input type='text' class='form-control' value='$bairro' readonly>
                                        </div>  
                                    </div>
                                   
                                    </div>
                                    <div class='float-right'>
                                        <a href='cadastros/avaliacao/$codigo' class='btn btn-success m-1'><i class='fas fa-clipboard'></i></a>
                                    </div>
                                </div>

                                <div class='modal-footer justify-content-between'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
                                    
                                    <a href='cadastros/aluno/$codigo' class='btn btn-info m-1'><i class='fas fa-pencil-alt'></i></a>
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
            title: 'Deseja excluir item?',
            text: "O item será excluído permanentente!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Excluir!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
                preConfirm: () => {
                    location.href='excluir/exercicio/'+codigo;
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

 