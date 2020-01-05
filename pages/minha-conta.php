<?php
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";

    $perfil = $_SESSION["user"]["perfil"];

    $codigoUsuario = $_SESSION["user"]["codigo_usuario"];
      
    $codigo_usuario = $nome = $senha = $tipo = $ativo = $data = "";

    if ( isset ( $codigoUsuario) ) {
        // SELECT DADOS DO USUARIO TABELA usuario
		$sql = "SELECT u.*, date_format(data,'%d/%m/%Y') data, e.* 
            FROM Usuario u, Endereco e 
            WHERE u.codigo_usuario = ? 
            AND u.Endereco_codigo_endereco = e.codigo_endereco 
            LIMIT 1";
            
		$consulta = $pdo->prepare( $sql );
		$consulta->bindParam(1,$codigoUsuario);
        $consulta->execute();
        
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

        $codigo_usuario = $dados->codigo_usuario;
        $nome = $dados->nome;
        $login = $dados->login;
        $email = $dados->email;
        $senha = $dados->senha;
        $perfil = $dados->Perfil_codigo_perfil;
        $status = $dados->status;
        $data = $dados->data;

        // Tabela Endereco
        $estado = $dados->estado;
        $cidade = $dados->cidade;
        $bairro = $dados->bairro;
        $rua = $dados->rua;
        $numero = $dados->numero;

    } else {
        $mensagem = "Usuário não encontrado!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }

?>

<div class="content-wrapper">
    <form class="form-horizontal" name="conta" method="POST" action="salvar/usuario" data-parsley-validate>        
    <div class="card">    
        <div class="card-header">

            <div class="row">
                    <div class="col">
                        <h3 class="text-uppercase">Minha Conta</h3>
                    </div>
                    <div class="col">
                        <a  href="pages/alterar-senha" class="btn btn-dark float-right">Alterar Senha <i class="ml-2 fas fa-lock"></i></a>
                    </div>
                </div>
            </div>
        <div class="card-body">

            <div class="row">

                <div class="col-4">
                    <div class="form-group">
                        <label for="data">Data:</label>
                        <input type="text" class="form-control" value="<?=$data;?>" readonly>      
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" class="form-control" name="status" value="<?=$status;?>" required data-parsley-required-message="Selecione!" readonly>
                            <option value="1" selected>Ativo</option>  
                        </select>
                    </div>
                    <script type="text/javascript">
						$("#status").val('<?=$status;?>');
					</script>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="tipo">Perfil:</label>
                            <select class="form-control" id="perfil" name="perfil" value="<?=$perfil;?>" required data-parsley-required-message="Selecione!" readonly>
                                
                                <?php 

                                if ($perfil == "1") 
                                {
                                    echo "<option value='1'>Master</option>";
                                }

                                if ($perfil == "2") 
                                {
                                    echo "<option value='2'>Admin</option>";
                                }

                                if ($perfil == "3") 
                                {
                                    echo "<option value='3'>Instrutor</option>";
                                }

                                if ($perfil == "4") 
                                {
                                    echo "<option value='4'>Aluno</option>";
                                }
                                
                                ?>
                    
                            </select>

					        <script type="text/javascript">
                            $("#perfil").val('<?=$perfil;?>');
					        </script>
                    </div>    
                </div>

            </div>

            <h6 class=" text-uppercase">Meus Dados</h6>
            <hr>

            <div class="form-group">
                <input type="hidden" class="form-control" name="codigo_usuario" value="<?=$codigo_usuario;?>">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" placeholder="Digite um nome" value="<?=$nome;?>" maxlength="45" onkeypress="return ApenasLetras(event,this);" autofocus required data-parsley-required-message="Preencha este campo!">         
            </div>

            <div class="form-group">
              <label for="email">E-mail:</label>
              <input type="email" class="form-control" id="email" name="email" value="<?=$email;?>" placeholder="Informe um e-mail" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">  
            </div>

            <div class="form-group">
              <label for="confirma">Confirmar E-mail:</label>
              <input type="email" id="redigite" class="form-control" name="redigite_email" value="<?=$email;?>" placeholder="Redigite o e-mail informado" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">  
            </div>

            <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" class="form-control" name="login" placeholder="Login" value="<?=$login;?>" maxlength="15" readonly>      
            </div>

            <hr>
            <h6 class=" text-uppercase">Localização</h6>
            <hr>

            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="estado">Estado:</label>           
                        <input class="form-control" name="estado" value="<?=$estado;?>" readonly>
                    </div>
                </div>

                <div class="col-10">
                    <div class="form-group">
                        <label for="cidade">Cidade:</label>
                        <input class="form-control" name="cidade" value="<?=$cidade;?>" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    <div class="form-group">
                        <label for="rua">Rua:</label>
                        <input type="text" class="form-control" name="rua" value="<?=$rua;?>" placeholder="Rua" maxlength="45" required data-parsley-required-message="Preencha este campo!">   
                    </div>
                </div>
           
                <div class="col-4"> 
                    <div class="form-group">
                        <label for="numero">Número:</label>
                        <input type="text" class="form-control" name="numero" value="<?=$numero;?>" placeholder="Número" maxlength="8"required data-parsley-required-message="Preencha este campo!">   
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="bairro">Bairro:</label>
                <input type="text" class="form-control" name="bairro" value="<?=$bairro;?>" placeholder="Bairro" maxlength="45" required data-parsley-required-message="Preencha este campo!">     
            </div>
            
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-success float-right" onclick="return verificaEmail()"><i class="fas fa-redo-alt mr-2"></i>Atualizar</button>
        </div>
        </div>
    </form>
</div>

<script type="text/javascript">

    function ApenasLetras(e, t) {
        try {
            if (window.event) {
                var charCode = window.event.keyCode;
            } else if (e) {
                var charCode = e.which;
            } else {
                return true;
            }
            if (
                (charCode > 8 && charCode < 46) ||
                (charCode > 64 && charCode < 91) || 
                (charCode > 96 && charCode < 123) ||
                (charCode > 191 && charCode <= 255) // letras com acentos
            ){
                return true;
            } else {
                return false;
            }
        } catch (err) {
            alert(err.Description);
        }
    }

    function verificaEmail(){
        var email = conta.email.value;
        var redigite = conta.redigite.value;
    
        const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                    
        })
    
            if(email == ""){
                Toast.fire({
                        type: 'error',
                        title: 'Preencha o e-mail!'
                        
                    })
                conta.email.focus();
                return false;
            }

            if(redigite == ""){
                    Toast.fire({
                        type: 'error',
                        title: 'Confirme o e-mail!'
                        
                    })
              
                conta.redigite.focus();

                return false;
            }
            
            if(email != redigite){

                Toast.fire({
                        type: 'error',
                        title: 'E-mails informados são diferentes!'
                        
                    })

                conta.redigite.focus();
            
                return false;
            }
    } 
</script>