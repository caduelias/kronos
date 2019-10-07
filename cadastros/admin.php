<?php
    include "config/funcoes.php";

    $perfil = $_SESSION["admin"]["tipo"];
      
    if ($perfil == "admin" || $perfil == "master"){
    
    $codigo_admin = $nome = $email = $senha = $tipo = $ativo = $data = "";

	//$p[1] -> index.php (id do registro)
	if ( isset ( $p[2] ) ) {

		//selecionar os dados conforme o id
		$sql = "SELECT * 
			FROM Admin 
			WHERE codigo_admin = ? LIMIT 1";
		$consulta = $pdo->prepare( $sql );
		$consulta->bindParam(1,$p[2]);
		$consulta->execute();
		//recuperar os dados
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

        $codigo_admin = $dados->codigo_admin;
        $nome = $dados->nome;
        $email = $dados->email;
        $senha = $dados->senha;
        $tipo = $dados->tipo;
        $ativo = $dados->ativo;

	}

?>
<div class="content-wrapper">

    <form class="form-horizontal" name="admin" method="POST" action="salvar/admin" data-parsley-validate>        
        <div class="card-body">
            <div class="row">
                <div class="col">
                <h3 class="card-title">Cadastro de Usuário</h3>
    </div>
    <div class="col">
        <div class="text-right">
                <a href="listar/admin" class="btn btn-info">Listar Usuários</a>
            </div>
    </div>
        </div>
        <div class="row">
            <div class="col-4">
                  <div class="form-group">
                <label for="status">Status:</label>
                    <select id="ativo" class="form-control" name="ativo" required data-parsley-required-message="Selecione!">
                        <option value="">Selecione... </option>
                        <option value="0">Inativo</option>
                        <option value="1" selected>Ativo</option>  
                    </select>

					<script type="text/javascript">
						$("#ativo").val('<?=$ativo;?>');
					</script>
                </div>
            </div>

    <div class="col-5">

        <div class="form-group">
                <label for="tipo">Tipo:</label>
                    <select class="form-control" id="tipo" name="tipo" required data-parsley-required-message="Selecione!">
                        <option value="">Selecione...  </option>
                        <?php 

                            if ($perfil == "master") 

    {
        ?>

                        <option value="admin">Administrador</option>

                        <?php 
    }
    ?>
                    <option value="instrutor" selected>Instrutor</option>  
                    </select>

					<script type="text/javascript">
						$("#tipo").val('<?=$tipo;?>');
					</script>
            </div>
            
    </div>

    </div>
        
            <div class="form-group">
                    <input type="hidden" class="form-control" name="codigo_admin" value="<?=$codigo_admin;?>">
                <label for="modalidade">Nome:</label>
                    <input type="text" class="form-control" name="nome" placeholder="Digite um nome" value="<?=$nome;?>" maxlength="15" autofocus required data-parsley-required-message="Preencha este campo!">
                   
            </div>

            <div class="form-group">
                <label for="modalidade">Email:</label>
                    <input type="email" class="form-control" name="email" placeholder="email@exemplo.com" value="<?=$email;?>" required data-parsley-required-message="Preencha o email!">
                   
            </div>

            <?php

                if (empty ($codigo_admin))
                {

                ?>
            <div class="form-group">
                <label for="modalidade">Senha:</label>
                    <input type="password" id="senha" class="form-control" name="senha" value="<?=$senha;?>" placeholder="Digite a senha" required>
            </div>

            <div class="form-group">
                <label for="modalidade">Confirmar Senha:</label>
                    <input type="password" id="redigite" class="form-control" value="<?=$senha;?>" name="redigite" placeholder="Redigite a senha anterior" required>
            </div>
            <?php 

                } else {

                    ?>
    <div class="form-group">
                <label for="modalidade">Nova Senha:</label>
                    <input type="password" id="senha" class="form-control" name="senha" placeholder="Digite a senha" required>
            </div>

            <div class="form-group">
                <label for="modalidade">Confirmar Senha:</label>
                    <input type="password" id="redigite" class="form-control" name="redigite" placeholder="Redigite a senha anterior" required>
            </div>
                    <?php

                }
                
                ?>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-success float-right" onclick="return validarSenha()"><i class="fas fa-user-plus"></i> Salvar</button>
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

<?php

  } else {
        $titulo = "Erro de Acesso";
        $mensagem = "O Usuário não tem permissão!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
  }