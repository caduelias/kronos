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
                    <h4 class="text-uppercase">Usuários</h4>
                </div>
                
                <div class="col-6">
                    <a  href="cadastros/usuario" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-user-plus"></i></a>
                    <a  href="listar/usuario" class="btn btn-dark float-right m-1">Listar <i class="ml-2 fas fa-redo-alt"></i></a>
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
                        <th width="15%">Perfil</th> 
                        <th width="10%">Data</th> 
                        <th width="20%">Ações</th>       
                    </tr>             
                </thead>
                <tbody>
                
<?php

    if ($perfil == "1") {
        // SELECT DADOS USUARIOS TABELA ADMIN DIFERENTE DE MASTER E ALUNO
        $sql = "SELECT *, date_format(data,'%d/%m/%Y') data FROM Usuario
        WHERE Perfil_codigo_perfil <> 1 AND Perfil_codigo_perfil <> 4 
        AND status = 1
        ORDER BY nome";

        $consulta = $pdo->prepare($sql);
        $consulta->execute();
    }

    if ($perfil == "2") {
        // SELECT DADOS USUARIOS TABELA ADMIN DIFERENTE DE ADMIN,MASTER E ALUNO
        $sql = "SELECT *, date_format(data,'%d/%m/%Y') data FROM Usuario
        WHERE Perfil_codigo_perfil <> 1 AND Perfil_codigo_perfil <> 2
        AND Perfil_codigo_perfil <> 4 AND status = 1
        ORDER BY nome";

        $consulta = $pdo->prepare($sql);
        $consulta->execute();
    }
                
        while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) 
        {

            $codigo_usuario = $linha->codigo_usuario;
            $nome 	= $linha->nome;
            $perfil = $linha->Perfil_codigo_perfil;
            $status = $linha->status;
            $data 	= $linha->data;

            $codigo = base64_encode($codigo_usuario);
            
            if ($status == "0") {
                $status = "<p class='text-danger'>Inativo</p>";
            } else if ($status == "1") {
                $status = "<p class='text-success'>Ativo</p>";
            }

            if ($perfil === "2") {
                $perfil = "admin";
            } else if ($perfil === "3") {
                $perfil = "instrutor";
            } else if ($perfil === "4") {
                $perfil = "aluno";
            }
                    echo "
                    <tr>
                        <td>$status</td>
                        <td class='text-uppercase'>$nome</td>
                        <td class='text-uppercase'>$perfil</td>
                        <td>$data</td>
                        <td class='text-center'> 
                        <a href='javascript:inativar($codigo_usuario)' class='btn btn-danger'>Inativar</a>
                        <a href='cadastros/usuario/$codigo' class='btn btn-info'>Alterar</a></td>
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
                location.href='status/usuario/'+codigo;
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