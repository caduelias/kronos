<?php
    include "config/funcoes.php";

    $tipo = $_SESSION["admin"]["tipo"];
  
    if ($tipo == "master"){
?>
<div class="content-wrapper">
<div class="card">
            <div class="card-header">
              <h3 class="card-title">&amp; Administradores e Usuários ativos</h3>
              <div class="text-right">
                <a href="cadastros/admin" class="btn btn-success">Novo</a>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                        <th width="10%">Nome</th>
                        <th width="5%">Status</th> 
                        <th width="10%">Nível</th> 
                        <th width="5%">Data</th> 
                        <th width="10%">Ações</th>  
                </tr>             

            </thead>
                <tbody>
                
                <?php
                	//selecionar os dados do editora
					$sql = "SELECT *, date_format(data,'%d/%m/%Y') data from Admin WHERE tipo <> 'master'
                    AND ativo = 1
                    ORDER BY nome";
                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                //laço de repetição para separar as linhas
                while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) {

                    //separar os dados
                    $codigo_admin 	= $linha->codigo_admin;
                    $nome 	= $linha->nome;
                    $tipo = $linha->tipo;
                    $ativo = $linha->ativo;
                    $data 	= $linha->data;
                    
                    if ($ativo === '1'){
                        $ativo = "<p class='text-success'>Ativo</p>";
                        echo "
                        <tr>
                  <td class='text-uppercase'>$nome</td>
                  <td>$ativo</td>
                  <td class='text-uppercase'>$tipo</td>
                  <td>$data</td>
                  <td class='text-center'> <a href='javascript:inativar($codigo_admin)' class='btn btn-outline-danger'>Inativar</a>
                  <a href='cadastros/admin/$codigo_admin' class='btn btn-outline-info'>Alterar</a></td>
               
                  </td>
                </tr>";
                    } else if ($ativo === '0'){
                        $ativo = "<p class='text-danger'>Inativo</p>";
                        echo "
                        <tr>
                  <td class='text-uppercase'>$nome</td>
                  <td>$ativo</td>
                  <td class='text-uppercase'>$tipo</td>
                  <td>$data</td>
                  <td class='text-center'> 
                  <a href='javascript:ativar($codigo_admin)' class='btn btn-outline-success'>Ativar</a></td>
                  </tr>";
                    } 

                    //montar as linhas e colunas da tabela
                 

                }


?>
          </tbody>
              </table>
            
            </div>

            
          </div>


</div>  

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
  text: "O usuário terá acesso ao sistema!",
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
    
	$(document).ready( function () {
	    $('.table').DataTable( {
        "language": {
			"lengthMenu": "Exibindo _MENU_ resultados por página",
                "zeroRecords": "Nenhum registro encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro adiciondo!",
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
    } else if ($tipo == "admin"){

        ?>

<div class="content-wrapper">
<div class="card">
    <div class="card-header">
              <h3 class="card-title">&amp; Usuários ativos do sistema</h3>
              <div class="text-right">
                <a href="cadastros/admin" class="btn btn-success">Novo</a>
            </div>
            </div>
</div>
            <!-- /.card-header -->
            <div class="card-body">
                          <table class="table table-bordered table-hover dataTable">
                <thead>
                <tr>
                        <th width="10%">Nome</th>
                        <th width="5%">Status</th> 
                        <th width="10%">Nível</th> 
                        <th width="5%">Data</th> 
                        <th width="10%">Ações</th>               
</tr>
            </thead>
                <tbody>
                
                <?php
                	//selecionar os dados do editora
					$sql = "SELECT *, date_format(data,'%d/%m/%Y') data from Admin WHERE tipo <> 'master' AND tipo <> 'admin' AND ativo = 1
                    ORDER BY nome";
                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                //laço de repetição para separar as linhas
                while ( $linha = $consulta->fetch(PDO::FETCH_OBJ)) {

                    //separar os dados
                    $codigo_admin 	= $linha->codigo_admin;
                    $nome 	= $linha->nome;
                    $tipo = $linha->tipo;
                    $ativo = $linha->ativo;
                    $data 	= $linha->data;
                    
                    if ($ativo === '1'){
                        $ativo = "<p class='text-success'>Ativo</p>";
                        echo "
                        <tr role='row' class='even'>
                  <td class='sorting_1 text-uppercase'>$nome</td>
                  <td>$ativo</td>
                  <td class='text-uppercase'>$tipo</td>
                  <td>$data</td>
                  <td class='text-center'> <a href='javascript:inativar($codigo_admin)' class='btn btn-outline-danger'>Inativar</a>
                  <a href='cadastros/admin/$codigo_admin' class='btn btn-outline-info'>Alterar</a></td>
                  </td>
                </tr>";
                    } else if ($ativo === '0'){
                        $ativo = "<p class='text-danger'>Inativo</p>";
                        echo "
                        <tr role='row' class='even'>
                  <td class='sorting_1 text-uppercase'>$nome</td>
                  <td>$ativo</td>
                  <td class='text-uppercase'>$tipo</td>
                  <td>$data</td>
                  <td class='text-center'> 
                  <a href='javascript:ativar($codigo_admin)' class='btn btn-outline-success'>Ativar</a></td>
                </tr>";
                    } 

                }


?>
          </tbody>
               
              </table>
            
            </div>

            
    
          </div>

</div>
 

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
  text: "O usuário terá acesso ao sistema!",
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


	$(document).ready( function () {
	    $('.table').DataTable( {
        "language": {
			"lengthMenu": "Exibindo _MENU_ resultados por página",
                "zeroRecords": "Nenhum registro encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro adiciondo!",
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

    } else {
        $titulo = "Erro de Acesso";
        $mensagem = "O Usuário não tem permissão!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }