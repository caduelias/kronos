<?php

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";

    $perfil = $_SESSION["admin"]["tipo"];

    $codigoUsuario = $_SESSION["admin"]["codigo_admin"];

    $senha = $codigo_admin = "";

    if ( isset ($codigoUsuario) ) 
    {
		$sql = "SELECT codigo_admin
			FROM Admin 
            WHERE codigo_admin = ? LIMIT 1";
            
		$consulta = $pdo->prepare( $sql );
		$consulta->bindParam(1,$codigoUsuario);
		$consulta->execute();
	
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

        $codigo_admin = $dados->codigo_admin;

        $codigo_admin = base64_encode($codigo_admin);

    } 
    else 
    {
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
                <h3 class="card-title text-uppercase">Alterar Senha</h3>
                </div>
            </div>

            <div class="form-group">
                <input type="hidden" class="form-control" name="codigo_admin" value="<?=$codigo_admin;?>">
            </div>

            <div class="form-group">
                <label for="senha">Senha Atual:</label>
                <input type="password" class="form-control" name="atual" value="<?=$senha;?>" placeholder="Digite a senha atual" autofocus required data-parsley-required-message="Preencha este Campo!">
            </div>

            <div class="form-group">
                <label for="nova">Nova Senha:</label>
                <input type="password" id="senha" class="form-control" name="nova" placeholder="Informe a nova senha" required data-parsley-required-message="Preencha!">
            </div>

            <div class="form-group">
                <label for="redigite">Confirmar Senha:</label>
                <input type="password" id="redigite" class="form-control" name="redigite" placeholder="Redigite a nova senha" required data-parsley-required-message="Preencha!">
            </div>
     
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-dark float-right" onclick="return validarSenha()"><i class="fas fa-user-lock mr-2"></i>Alterar</button>
        </div>
    </form>
</div>

<!-- FUNÇÃO PARA VERIFICAR VALIDAR E COMPARAR SENHAS  -->
<script type="text/javascript">
    	
    function validarSenha(){
        var senha = admin.senha.value;
        var redigite = admin.redigite.value;
    
        const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                    
        })
    
            if(senha == "" || senha.length <= 7){
                Toast.fire({
                        type: 'warning',
                        title: 'Preencha o campo da senha com no mínimo 8 caracteres!'
                        
                    })
                admin.senha.focus();
                return false;
            }

            if(redigite== "" || redigite.length <= 7){
                    Toast.fire({
                        type: 'warning',
                        title: 'Preencha o campo da senha com no mínimo 8 caracteres!'
                        
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
