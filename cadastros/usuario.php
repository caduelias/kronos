<?php

    if ( file_exists ( "permissaoAdmin.php" ) )
        include "permissaoAdmin.php";
    else
        include "../permissaoAdmin.php";

    include "config/funcoes.php";

    $logado = $_SESSION["user"]["perfil"];

    $usuario = $_SESSION["user"]["codigo_usuario"];

    $propio =  base64_encode($usuario);
    
    $codigo_usuario = $nome = $email = $senha = $login = $status = $data = $estado = $cidade = $bairro = $rua = $numero = "";

    if ( isset ($p[2]) && ($p[2]) != $propio ) 
    {
        $codigo_usuario =  base64_decode($p[2]);

		$sql = "SELECT u.*, e.* 
			FROM Usuario as u, Endereco as e 
            WHERE u.codigo_usuario = ? AND 
            u.Endereco_codigo_endereco = e.codigo_endereco 
            LIMIT 1";
            
		$consulta = $pdo->prepare( $sql );
		$consulta->bindParam(1,$codigo_usuario);
        $consulta->execute();
        
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

        // Tabela Admin
        $codigo_usuario = $dados->codigo_usuario;
        $nome = $dados->nome;
        $login = $dados->login;
        $email = $dados->email;
        $senha = $dados->senha;
        $perfil = $dados->Perfil_codigo_perfil;
        $status = $dados->status;

        // Tabela Endereco
        $estado = $dados->estado;
        $cidade = $dados->cidade;
        $bairro = $dados->bairro;
        $rua = $dados->rua;
        $numero = $dados->numero;

        var_dump($logado, $perfil);

        if ($logado !== 1) {

            if ($perfil == 1) {
                $titulo = "Usuário não encontrado!";
                $mensagem = "Parâmetros inválidos!";
                $link = "listar/usuario";
                errorLink($titulo, $mensagem, $link);
                exit;
            }
        }
	}

?>
<div class="content-wrapper">
    <form class="form-horizontal" name="usuario" method="POST" action="salvar/usuario" data-parsley-validate>        
    <div class="card">
      <div class="card-header">
       
          <div class="row">
              <div class="col">
                  <h3 class="card-title text-uppercase">Cadastro Usuário</h3>
              </div>
              <div class="col">
                  <a  href="cadastros/usuario" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-table"></i></a>
                  <a  href="listar/usuario" class="btn btn-dark float-right m-1">Listar <i class="ml-2 fas fa-list"></i></a>
              </div>
          </div>
      </div>  
      <div class="card-body">
            <div class="row">

                <div class="col-6">
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" class="form-control" name="status" required data-parsley-required-message="Selecione!">
                            <option value="">Selecione... </option>
                            <option value="0">Inativo</option>
                            <option value="1" selected>Ativo</option>  
                        </select>

                        <script type="text/javascript">
                            $("#status").val('<?=$status;?>');
                        </script>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="perfil">Perfil:</label>
                        <select class="form-control" id="perfil" name="perfil" required data-parsley-required-message="Selecione!">
                                 
                        <?php 

                            if ($logado == "1") {
                      
                            echo "<option value=''>Selecione... </option>
                                <option value='2'>Administrador</option>
                                <option value='3'>Instrutor</option>";
                            }

                            if ($logado == "2") {
                                echo "<option value=''>Selecione... </option>
                                <option value='3'>Instrutor</option>";
                            }
                        ?>

                        </select>

                        <script type="text/javascript">
                            $("#perfil").val('<?=$perfil;?>');
                        </script>
                    </div>
                </div>

            </div>
        
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
              <input type="email" id="redigiteemail" class="form-control" name="redigite_email" value="<?=$email;?>" placeholder="Redigite o e-mail informado" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">  
            </div>

            <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" class="form-control" name="login" placeholder="Login" value="<?=$login;?>" maxlength="15" onkeypress="return ApenasLetras(event,this);" required data-parsley-required-message="Preencha o Login!">      
            </div>

                <?php

                    if ( empty ($codigo_usuario) )
                    {

                ?>

                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" class="form-control" name="senha" value="<?=$senha;?>" placeholder="Digite a senha" required data-parsley-required-message="Preencha!">
                    </div>

                    <div class="form-group">
                        <label for="redigite">Confirmar Senha:</label>
                        <input type="password" id="redigite" class="form-control" value="<?=$senha;?>" name="redigite" placeholder="Redigite a senha" required data-parsley-required-message="Preencha!">
                    </div>

                <?php 

                    } 

                ?>
                
                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="estado">Estado:</label>           
                                <select id="estados" class="form-control" name="estado" required data-parsley-required-message="Selecione!">
                                
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="cidade">Cidade:</label>
                                <select id="cidades" class="form-control" name="cidade" required data-parsley-required-message="Selecione!">
                            
                                </select>
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

            <div class="text-right">
                <button type="submit" class="btn btn-success" onclick="return validarSenha(), verificaEmail()"><i class="fas fa-save"></i> Salvar</button>
            </div>
        </div>
    </div>
</form>
</div>

<!-- FUNÇÃO PARA VERIFICAR E COMPARAR SENHAS E VALIDAR  -->
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

    function verificaEmail(){
        var email = usuario.email.value;
        var redigiteemail = usuario.redigiteemail.value;
    
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
                usuario.email.focus();
                return false;
            }

            if(redigiteemail == ""){
                    Toast.fire({
                        type: 'error',
                        title: 'Confirme o e-mail!'
                        
                    })
              
                usuario.redigiteemail.focus();

                return false;
            }
            
            if(email != redigiteemail){

                Toast.fire({
                        type: 'error',
                        title: 'E-mails informados são diferentes!'
                        
                    })

                usuario.redigiteemail.focus();
            
                return false;
            }
    } 			
</script>

<!-- FUNÇÃO PARA SELECIONAR ESTADOS E CIDADES NO SELECT ATRAVÉS DO ARQUIVO JSON -->
<script type="text/javascript">	
		
    $(document).ready(function () {
    
        $.getJSON('estados_cidades.json', function (data) {
            var items = [];
            var options = '<option value="">Selecione...</option>';	
            $.each(data, function (key, val) {
                options += '<option value="' + val.sigla + '">' + val.nome + '</option>';
            });					
            $("#estados").html(options);				
            
            $("#estados").change(function () {				
            
                var options_cidades = '<option value="">Selecione...</option>';
                var str = "";					
                
                $("#estados option:selected").each(function () {
                    str += $(this).text();
                });
                
                $.each(data, function (key, val) {
                    if(val.nome == str) {							
                        $.each(val.cidades, function (key_city, val_city) {
                            
                            options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                        });							
                    }
                });
                $("#cidades").html(options_cidades);
                
            }).change();		
        
        });
    
    });
		
</script>
