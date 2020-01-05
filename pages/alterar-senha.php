<?php

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";

    $perfil = $_SESSION["user"]["perfil"];

    $codigoUsuario = $_SESSION["user"]["codigo_usuario"];

    $senha = $codigo_usuario = "";

    if ( isset($codigoUsuario) ) 
    {
		$sql = "SELECT codigo_usuario
                FROM Usuario 
                WHERE codigo_usuario = ? 
                LIMIT 1
                ";
            
		$consulta = $pdo->prepare( $sql );
		$consulta->bindParam(1,$codigoUsuario);
		$consulta->execute();
	
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

        $codigo_usuario = $dados->codigo_usuario;

        $codigo_usuario = base64_encode($codigo_usuario);

    } else {
        $mensagem = "Requisição inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }

?>

<div class="content-wrapper">
    <form class="form-horizontal" name="usuario" method="POST" action="salvar/senha" data-parsley-validate>        
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h3 class="text-uppercase">Alterar Senha</h3>
                </div>
                <div class="col">
                    <a  href="pages/minha-conta" class="btn btn-dark float-right">Minha Conta<i class="ml-2 fas fa-id-card-alt"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body">
           
            <div class="form-group">
                <input type="hidden" class="form-control" name="codigo_usuario" value="<?=$codigo_usuario;?>">
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
    </div>
    </form>
</div>

<!-- FUNÇÃO PARA VERIFICAR VALIDAR E COMPARAR SENHAS  -->
<script type="text/javascript">
    	
    function validarSenha(){
        var senha = usuario.senha.value;
        var redigite = usuario.redigite.value;
    
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
                usuario.senha.focus();
                return false;
            }

            if(redigite== "" || redigite.length <= 7){
                    Toast.fire({
                        type: 'warning',
                        title: 'Reedigite a senha com no mínimo 8 caracteres!'
                        
                    })
               // alert ('Preencha o campo da senha com no minimo 4 caracteres');
                usuario.redigite.focus();
                return false;
            }
            
            if(senha != redigite){

                Toast.fire({
                        type: 'error',
                        title: 'Senhas informadas são diferentes!'
                        
                    })
               // alert (' Senhas digitadas não conferem, são diferentes!'); 
                usuario.redigite.focus();
            
                return false;
            }
    } 
					
</script>
