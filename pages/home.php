<?php
    
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";

    $sql = "
        SELECT 
            COUNT(a.codigo_aluno) as total_ativos
        FROM aluno a
        WHERE a.status = 1;
    ";

    $consulta = $pdo->prepare($sql);
    $consulta->execute();

    $total_alunos = $consulta->fetch(PDO::FETCH_OBJ);

    $total_alunos_ativos = (isset($total_alunos->total_ativos)) ? $total_alunos->total_ativos : 0;


    $sql = "
        SELECT 
            COUNT(a.codigo_aluno) as total_inativos
        FROM aluno a
        WHERE a.status = 2;
    ";

    $consulta = $pdo->prepare($sql);
    $consulta->execute();

    $total_aluno_inativo = $consulta->fetch(PDO::FETCH_OBJ);

    $total_alunos_inativos = (isset($total_aluno_inativo->total_inativos)) ? $total_aluno_inativo->total_inativos : 0;


    $sql = "
        SELECT 
            COUNT(e.codigo_exercicio) as total_exercicio
        FROM exercicio e
    ";

    $consulta = $pdo->prepare($sql);
    $consulta->execute();

    $total_exercicio = $consulta->fetch(PDO::FETCH_OBJ);

    $total_exercicios = (isset($total_exercicio->total_exercicio)) ? $total_exercicio->total_exercicio : 0;

    $sql = "
        SELECT 
            COUNT(m.codigo_modalidade) as total_modalidade
        FROM modalidade m
        WHERE m.status = 1;
    ";

    $consulta = $pdo->prepare($sql);
    $consulta->execute();

    $total_modalidade = $consulta->fetch(PDO::FETCH_OBJ);

    $total_modalidades = (isset($total_modalidade->total_modalidade)) ? $total_modalidade->total_modalidade : 0;


?>
<div class="content-wrapper"> 
    <div class="card">
        <div class="card-header">
        <div class="row">
        <div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=$total_alunos_ativos;?></h3>
                <p>Aluno(s)</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="relatorio/aluno" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$total_exercicios;?></h3>

                <p>Exercícios</p>
              </div>
              <div class="icon">
                <i class="fas fa-running"></i>
              </div>
              <a href="listar/exercicio" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-dark">
              <div class="inner">
                <h3><?=$total_modalidades;?></h3>

                <p>Modalidades</p>
              </div>
              <div class="icon">
                <i class="fas fa-dumbbell"></i>
              </div>
              <a href="listar/modalidade" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?=$total_alunos_inativos;?></h3>

                <p>Aluno(s)</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-times"></i>
              </div>
              <a href="listar/aluno" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
            <!-- <div class="row">

                <div class="col-6">
                    <h4 class="text-uppercase"></h4>
                </div>
                
                <div class="col-6">
                    <a  href="cadastros/aluno" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-table"></i></a>
                    <a  href="listar/aluno" class="btn btn-dark float-right m-1">Listar <i class="ml-2 fas fa-list"></i></a>
                </div>

            </div> -->

        </div>
        <!-- /.card-header -->
        <div class="card-body bg-light">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center">
                        <th width="10%">Status</th> 
                        <th width="20%">Aluno</th>
                        <th width="15%">CPF</th>
                        <th width="10%">Data Cadastro</th>
                        <th width="20%">Ações</th>       
                    </tr>             
                </thead>
                <tbody>
                
                <?php
					$sql = "              
                        SELECT 
                            a.codigo_aluno,
                            a.status,
                            a.nome_aluno,
                            a.cpf,
                            a.rg,
                            a.email,
                            a.sexo,
                            a.objetivo,
                            date_format(a.data_nasc,'%d/%m/%Y') as data_nascimento, 
                            date_format(a.data_cadastro,'%d/%m/%Y') as data_cadastro,
                            en.estado,
                            en.cidade,
                            en.bairro,
                            en.rua,
                            en.numero,
                            tf.num_telefone,
                            tf.num_celular
                        FROM aluno a 
                        INNER JOIN endereco en ON en.codigo_endereco = a.Endereco_codigo_endereco
                        INNER JOIN telefone tf ON tf.Aluno_codigo_aluno = a.codigo_aluno
                        WHERE a.codigo_aluno = a.codigo_aluno and a.status = 1
                        ORDER BY a.nome_aluno;
                    ";

                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    $alunos = $consulta->fetchAll(PDO::FETCH_OBJ);
                   
                    foreach($alunos as $aluno) {
                    
                    $modal = caracter($aluno->nome_aluno.$aluno->codigo_aluno);

                    $codigo = base64_encode($aluno->codigo_aluno);

                    if ($aluno->status == '1') {
                        $aluno->status = "<p class='text-success'>Ativo</p>";
                    } else if ($aluno->status == '2') {
                        $aluno->status = "<p class='text-danger'>Inativo</p>";
                    }

                    if ($aluno->sexo == 'F') {
                        $aluno->sexo = "Feminino";
                    } else if ($aluno->sexo == 'M') {
                        $aluno->sexo = "Masculino";
                    }

                    $sql = " SELECT 
                                DATE_FORMAT(a.data_avaliacao, '%d/%m/%Y') as ultimaavaliacao,
                                DATEDIFF(a.data_avaliacao, date_add(Now(), interval - 30 day)) as diasrestante
                            FROM avaliacao a
                            WHERE a.data_avaliacao > DATE_ADD(Now(), INTERVAL - 30 DAY) 
                            AND a.codigo_aluno = :codigo_aluno
                            HAVING diasrestante >= 0
                            LIMIT 1
                    ";

                    $consulta = $pdo->prepare($sql);
                    $consulta->bindValue(':codigo_aluno', $aluno->codigo_aluno);
                    $consulta->execute();

                    $avaliacao = $consulta->fetch(PDO::FETCH_OBJ);

                    if (isset($avaliacao->diasrestante) && $avaliacao->diasrestante <= 0) {
                        $cadastro_avaliacao = " <a href='cadastros/avaliacao/$codigo' class='btn btn-success m-1'><i class='fas fa-clipboard'></i></a>";
                    } else if (isset($avaliacao->diasrestante) && $avaliacao->diasrestante > 0) {
                        $cadastro_avaliacao = " <a href='cadastros/avaliacao/$codigo' class='btn btn-warning m-1'><i class='fas fa-clipboard'></i></a>";
                    } else {
                        $cadastro_avaliacao = " <a href='cadastros/avaliacao/$codigo' class='btn btn-success m-1'><i class='fas fa-clipboard'></i></a>";
                    }

                    $ficha = " <tr class='text-center'>
                    <td class='text-uppercase'>$aluno->status</td>
                    <td class='text-uppercase'>$aluno->nome_aluno</td>
                    <td class='text-uppercase'>$aluno->cpf</td>
                    <td class='text-uppercase'>$aluno->data_cadastro</td>
                    <td class='text-center'> 
                    $cadastro_avaliacao
                    <a href='cadastros/gerenciaraluno/$codigo' class='btn btn-info m-1'><i class='fas fa-wrench'></i></a>
                    <a class='btn btn-default m-1' data-toggle='modal' data-target='#$modal'>
                    <i class='fas fa-folder-open'></i>
                    </a>
                    </td>
                </tr>

            <div class='modal' id='$modal' aria-hidden='true' style='display: none;'>
                <div class='modal-dialog modal-xl'>
                    <div class='modal-content'>

                        <div class='modal-header'>

                            <h4 class='modal-title text-uppercase'>Aluno(a): $aluno->nome_aluno</h4>
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
                                    <div class='form-control'>$aluno->status</div>
                                </div> 
                                
                                <div class='form-group mt-2'>
                                    <label>E-mail:</label>
                                    <div class='form-control'>$aluno->email</div>
                                </div> 
                            </div>

                            <div class='col-4'>
                                <div class='form-group mt-2'>
                                    <label>CPF:</label>
                                    <div class='form-control'>$aluno->cpf</div>     
                                </div>  

                                <div class='form-group mt-2'>
                                    <label>RG:</label>
                                    <div class='form-control'>$aluno->rg</div>   
                                </div>  
                            </div>

                            <div class='col-4'>
                                <div class='form-group mt-2'>
                                    <label>Nascimento:</label>
                                    <div class='form-control'>$aluno->data_nascimento</div>    
                                </div>  

                                <div class='form-group mt-2'>
                                    <label>Gênero:</label>
                                    <div class='form-control'>$aluno->sexo</div> 
                                </div>  
                            </div>

                            </div>
                            
                            <div class='form-group mt-2'>
                                <label>Objetivo:</label>
                                <div class='form-control'>$aluno->objetivo</div>
                            </div> 

                            <hr>
                            <div class='row'>
                          
                                <div class='col-4'>
                                    <div class='form-group mt-2'>
                                        <label>Telefone:</label>
                                        <div class='form-control'>$aluno->num_celular</div>
                                    </div>  
                                </div>
                                <div class='col-4'>
                                    <div class='form-group mt-2'>
                                        <label>Celular:</label>
                                        <div class='form-control'>$aluno->num_celular</div>
                                    </div>  
                                </div>
                            </div>

                            <hr />
                            <label class='text-uppercase'>Endereço:</label>
                          
                            <div class='row'>
                                <div class='col-3'>
                                    <div class='form-group mt-2'>
                                        <label>Cidade:</label>
                                        <div class='form-control'>$aluno->cidade</div>
                                    </div>  
                                </div>

                                <div class='col-3'>
                                    <div class='form-group mt-2'>
                                        <label>Estado:</label>
                                        <div class='form-control'>$aluno->estado</div>
                                    </div>  
                                </div>

                                <div class='col-3'>
                                    <div class='form-group mt-2'>
                                        <label>Número:</label>
                                        <div class='form-control'>$aluno->numero</div>
                                    </div>  
                                </div>

                                <div class='col-6'>
                                    <div class='form-group mt-2'>
                                        <label>Rua:</label>
                                        <div class='form-control'>$aluno->rua</div>
                                    </div>  
                                </div>

                                <div class='col-6'>
                                <div class='form-group mt-2'>
                                    <label>Bairro:</label>
                                    <div class='form-control'>$aluno->bairro</div>
                                </div>  
                            </div>
                           
                            </div>
                           
                        </div>
                        

                        <div class='modal-footer'>
                            <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
                            $cadastro_avaliacao
                            <a href='cadastros/aluno/$codigo' class='btn btn-dark m-1'><i class='fas fa-pencil-alt'></i></a>
                            <a href='cadastros/gerenciaraluno/$codigo' class='btn btn-info m-1'><i class='fas fa-wrench'></i></a>
                        </div>
                    
                    </div>
                <!-- /.modal-content -->
                </div>
            <!-- /.modal-dialog -->
            </div>
                    
            ";
                   echo $ficha;
                              
                    } 
              
                    ?>

                </tbody>
            </table>     
        </div>         
    </div>
</div>  

        
<!-- FUNÇÕES DE CONFIRMAÇÃO E CONFIGURAÇÕES DE TABELA -->
<script type="text/javascript">
    
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
            },
            dom: "<'row'<'col-md-3'B><'col-md-3'f><'col-md-3'><'col-md-3'l>><'row'<'col-md-12't>><'row'<'col-md-3'i><'col-md-6'><'col-md-3'p>>",
            buttons: [
                { text: '', extend: 'excel', className: 'btn btn-success fas fa-file-excel' },
                { text: '', extend: 'pdf', className: 'btn btn-danger fas fa-file-pdf' },
            ]
        });

    });
    
</script>

 