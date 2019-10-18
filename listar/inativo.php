<?php

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "permissaoAdmin.php" ) )
        include "permissaoAdmin.php";
    else
        include "../permissaoAdmin.php";

    include "config/funcoes.php";

    $perfil = $_SESSION["admin"]["tipo"];
  
    // TIPO = USUARIO MASTER
    if ($perfil == "master")
    {

?>
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Usuários Inativos</h3>
            <div class="text-right">
                <a href="cadastros/admin" class="btn btn-success">Novo<i class="fas fa-user-plus ml-2"></i></a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="10%">Status</th> 
                        <th width="20%">Nome</th>
                        <th width="15%">Perfil</th> 
                        <th width="10%">Data</th> 
                        <th width="20%">Ações</th>              
                    </tr>
                </thead>
                <tbody>
                
                <?php
                	// SELECT USUARIOS INATIVOS DIFERENTE DE MASTER
					$sql = "SELECT *, date_format(data,'%d/%m/%Y') data 
                    FROM Admin WHERE tipo <> 'master'
                    AND ativo = 0
                    ORDER BY nome";

                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) 
                    {

                        $codigo_admin 	= $linha->codigo_admin;
                        $nome 	= $linha->nome;
                        $tipo = $linha->tipo;
                        $ativo = $linha->ativo;
                        $data 	= $linha->data;

                        if ($ativo === '1')
                        {
                            $ativo = "<p class='text-success'>Ativo</p>";
                            echo "
                                <tr role='row' class='even'>
                                    <td>$ativo</td>
                                    <td class='sorting_1 text-uppercase'>$nome</td>
                                    <td class='text-uppercase'>$tipo</td>
                                    <td>$data</td>
                                    <td class='text-center'> 
                                    <a href='javascript:inativar/$codigo' class='btn btn-outline-danger'>Inativar</a>
                                    </td>
                                </tr>
                            ";

                        } 
                        else if ($ativo === '0')
                        {
                            $ativo = "<p class='text-danger'>Inativo</p>";
                            echo "
                                <tr role='row' class='even'>
                                    <td>$ativo</td>
                                    <td class='sorting_1 text-uppercase'>$nome</td>
                                    <td class='text-uppercase'>$tipo</td>
                                    <td>$data</td>
                                    <td class='text-center'> 
                                    <a href='javascript:excluir($codigo_admin)' class='mr-2 btn btn-danger'>Excluir</a>
                                    <a href='javascript:ativar($codigo_admin)' class='btn btn-dark'>Ativar</a>
                                    </td>
                                </tr>
                            ";
                        } 
                    }

                ?>

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div> 

<!-- FUNÇÕES DE CONFIRMAÇÃO E CONFIGURAÇÕES DE TABELA -->
<script type="text/javascript">

	function inativar(codigo) {
   
        Swal.fire({           
            title: 'Inativar Usuário?',
            text: "O usuário não terá acesso ao sistema!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, Inativar!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
                preConfirm: () => {
                    location.href='inativar/admin/'+codigo;
                }
        })
	
    }
    
    function ativar(codigo) {
      
        Swal.fire({         
            title: 'Ativar o Usuário?',
            text: "O usuário voltará a ter acesso ao sistema!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, Ativar!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
                preConfirm: () => {
                    location.href='inativar/admin/'+codigo;
                }
        })
	
    }
    
    function excluir(codigo) {
        
        Swal.fire({        
            title: 'Deseja excluir Usuário?',
            text: "O usuário será excluído permanentente!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Excluir!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
                preConfirm: () => {
                    location.href='excluir/admin/'+codigo;
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

        <!-- ******************* TIPO = USUÁRIO ADMIN *************************** -->
        <?php

            } 
            else if ($perfil == "admin")
            {

        ?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Usuários Inativos</h3>
            <div class="text-right">
                <a href="cadastros/admin" class="btn btn-success">Novo<i class="fas fa-user-plus ml-2"></i></a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="10%">Status</th> 
                        <th width="20%">Nome</th>
                        <th width="15%">Perfil</th> 
                        <th width="10%">Data</th> 
                        <th width="20%">Ações</th>               
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                        // SELECT USUARIOS INATIVOS DIFERENTE DE MASTER E ADMIN
                        $sql = "SELECT *, date_format(data,'%d/%m/%Y') data 
                        FROM Admin WHERE tipo <> 'master' 
                        AND tipo <> 'admin' 
                        AND ativo = 0
                        ORDER BY nome";

                        $consulta = $pdo->prepare($sql);
                        $consulta->execute();

                        while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) 
                        {

                            $codigo_admin 	= $linha->codigo_admin;
                            $nome 	= $linha->nome;
                            $tipo = $linha->tipo;
                            $ativo = $linha->ativo;
                            $data 	= $linha->data;
                        
                            if ($ativo === '1')
                            {
                                $ativo = "<p class='text-success'>Ativo</p>";
                                echo "
                                    <tr role='row' class='even'>
                                        <td>$ativo</td>
                                        <td class='sorting_1 text-uppercase'>$nome</td>
                                        <td class='text-uppercase'>$tipo</td>
                                        <td>$data</td>
                                        <td class='text-center'> <a href='javascript:inativar($codigo_admin)' class='btn btn-danger'>Inativar</a>
                                        </td>
                                    </tr>
                                ";
                            } 
                            else if ($ativo === '0')
                            {
                                $ativo = "<p class='text-danger'>Inativo</p>";
                                echo "
                                    <tr role='row' class='even'>
                                        <td>$ativo</td>
                                        <td class='sorting_1 text-uppercase'>$nome</td>
                                        <td class='text-uppercase'>$tipo</td>
                                        <td>$data</td>
                                        <td class='text-center'> 
                                        <a href='javascript:ativar($codigo_admin)' class='btn btn-dark'>Ativar</a></td>
                                    </tr>
                                ";
                            } 

                        }
                    
                    ?>

                </tbody>    
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div> 

<!-- FUNÇÕES DE CONFIRMAÇÃO E CONFIGURAÇÕES DE TABELA -->
<script type="text/javascript">

	function inativar(codigo) {
   
        Swal.fire({           
            title: 'Inativar Usuário?',
            text: "O usuário não terá acesso ao sistema!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, Inativar!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
                preConfirm: () => {
                    location.href='inativar/admin/'+codigo;
                }
        })
	
    }
    
    function ativar(codigo) {
      
        Swal.fire({         
            title: 'Ativar o Usuário?',
            text: "O usuário voltará a ter acesso ao sistema!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, Ativar!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
                preConfirm: () => {
                    location.href='inativar/admin/'+codigo;
                }
        })
	
    }
    
    function excluir(codigo) {
        
        Swal.fire({        
            title: 'Deseja excluir Usuário?',
            text: "O usuário será excluído permanentente!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Excluir!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
                preConfirm: () => {
                    location.href='excluir/admin/'+codigo;
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

<?php

    } 
    else 
    {   
        // ALERTA
        $titulo = "Erro de Acesso";
        $mensagem = "O Usuário não tem permissão!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }