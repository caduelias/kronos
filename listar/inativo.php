<?php

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "permissaoAdmin.php" ) )
        include "permissaoAdmin.php";
    else
        include "../permissaoAdmin.php";

    include "config/funcoes.php";

    $perfil = $_SESSION["user"]["perfil"];
  
    // TIPO = USUARIO MASTER
    if ($perfil == "1")
    {

?>
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Usuários Inativos</h3>
            <div class="text-right">
                <a href="cadastros/usuario" class="btn btn-success">Novo<i class="ml-1 fas fa-user-plus ml-2"></i></a>
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
                    FROM Usuario WHERE Perfil_codigo_perfil <> 1 
                    AND Perfil_codigo_perfil <> 4 
                    AND status = 0
                    ORDER BY nome";

                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) 
                    {
                        $codigo_usuario = $linha->codigo_usuario;
                        $nome = $linha->nome;
                        $perfil = $linha->Perfil_codigo_perfil;
                        $status = $linha->status;
                        $data 	= $linha->data;

                        $status = "<p class='text-danger'>Inativo</p>";

                        if ($perfil === "2") {
                            $perfil = "admin";
                        } else if ($perfil === "3") {
                            $perfil = "instrutor";
                        }
                        
                            echo "
                                <tr role='row' class='even'>
                                    <td>$status</td>
                                    <td class='sorting_1 text-uppercase'>$nome</td>
                                    <td class='text-uppercase'>$perfil</td>
                                    <td>$data</td>
                                    <td class='text-center'> 
                                    <a href='javascript:inativar/$codigo_usuario' class='btn btn-outline-danger'>Inativar</a>
                                    </td>
                                </tr>
                            ";
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
                    location.href='inativar/usuario/'+codigo;
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
                    location.href='inativar/usuario/'+codigo;
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
                    location.href='excluir/usuario/'+codigo;
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
            else if ($perfil == "2")
            {

        ?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Usuários Inativos</h3>
            <div class="text-right">
                <a href="cadastros/usuario" class="btn btn-success">Novo<i class="ml-1 fas fa-user-plus ml-2"></i></a>
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
                        FROM Usuario WHERE Perfil_codigo_perfil <> 1 
                        AND Perfil_codigo_perfil <> 2 
                        AND Perfil_codigo_perfil <> 4 
                        AND status = 0
                        ORDER BY nome";
    
                        $consulta = $pdo->prepare($sql);
                        $consulta->execute();
    
                        while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) 
                        {
                            $codigo_usuario = $linha->codigo_usuario;
                            $nome = $linha->nome;
                            $perfil = $linha->Perfil_codigo_perfil;
                            $status = $linha->status;
                            $data 	= $linha->data;
    
                            $status = "<p class='text-danger'>Inativo</p>";
    
                            if ($perfil === "3") {
                                $perfil = "instrutor";
                            } else if ($perfil === "4") {
                                $perfil = "aluno";
                            }
                            
                                echo "
                                    <tr role='row' class='even'>
                                        <td>$status</td>
                                        <td class='sorting_1 text-uppercase'>$nome</td>
                                        <td class='text-uppercase'>$perfil</td>
                                        <td>$data</td>
                                        <td class='text-center'> 
                                        <a href='javascript:inativar/$codigo_usuario' class='btn btn-outline-danger'>Inativar</a>
                                        </td>
                                    </tr>
                                ";
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
                    location.href='inativar/usuario/'+codigo;
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
                    location.href='inativar/usuario/'+codigo;
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
                    location.href='excluir/usuario/'+codigo;
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
        $titulo = "Acesso negado!";
        $mensagem = "O Usuário não tem permissão!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }