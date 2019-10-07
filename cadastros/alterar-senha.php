<?php
    include "config/funcoes.php";

    $perfil = $_SESSION["admin"]["tipo"];

    $codigoAcesso = $_SESSION["admin"]["codigo_admin"];
      
    $codigo_admin = $nome = $senha = $tipo = $ativo = $data = "";

	//$p[1] -> index.php (id do registro)
	if ( isset ($codigoAcesso) ) {

		//selecionar os dados conforme o id
		$sql = "SELECT codigo_admin
			FROM Admin 
			WHERE codigo_admin = ? LIMIT 1";
		$consulta = $pdo->prepare( $sql );
		$consulta->bindParam(1,$codigoAcesso);
		$consulta->execute();
		//recuperar os dados
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

        $codigo_admin = $dados->codigo_admin;

	} else {
        $mensagem = "Erro na Requisição!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }

?>
<div class="content-wrapper">

    <form class="form-horizontal" name="admin" method="POST" action="salvar/senha" data-parsley-validate>        
        <div class="card-body">
            <div class="row">
                <div class="col">
                <h3 class="card-title">Alterar Senha</h3>
                </div>
            </div>

            <div class="form-group">
                    <input type="text" class="form-control" name="codigo_admin" value="<?=$codigo_admin;?>">

            </div>

            <div class="form-group">
                <label for="modalidade">Senha Atual:</label>
                    <input type="password" class="form-control" name="atual" value="<?=$senha;?>" placeholder="Digite a senha atual" autofocus required data-parsley-required-message="Preencha!">
            </div>

            <div class="form-group">
                <label for="modalidade">Nova Senha:</label>
                    <input type="password" id="senha" class="form-control" name="nova" placeholder="Informe a nova senha" required data-parsley-required-message="Preencha!">
            </div>

            <div class="form-group">
                <label for="modalidade">Confirmar Senha:</label>
                    <input type="password" id="redigite" class="form-control" name="redigite" placeholder="Redigite a nova senha" required data-parsley-required-message="Preencha!">
            </div>

            
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-success float-right" onclick="return validarSenha()"><i class="fas fa-user-plus"></i> Alterar</button>
        </div>

    </form>
</div>

<script type="text/javascript">
    	

    function validarSenha(){
        var senha = admin.senha.value;
        var redigite = admin.redigite.value;
    
        const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                    
        })
    
            if(senha == "" || senha.length <= 7){
                Toast.fire({
                        type: 'warning',
                        title: 'Preencha o campo da senha com no minimo 8 caracteres!'
                        
                    })
                admin.senha.focus();
                return false;
            }

            if(redigite== "" || redigite.length <= 7){
                    Toast.fire({
                        type: 'warning',
                        title: 'Preencha o campo da senha com no minimo 8 caracteres!'
                        
                    })
               // alert ('Preencha o campo da senha com no minimo 4 caracteres');
                admin.redigite.focus();
                return false;
            }
            
            if(senha != redigite){

                Toast.fire({
                        type: 'error',
                        title: 'Senhas digitadas não conferem, são diferentes!'
                        
                    })
               // alert (' Senhas digitadas não conferem, são diferentes!'); 
                admin.redigite.focus();
            
                return false;
            }
    } 

					
</script>