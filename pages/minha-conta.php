<?php
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";

    $perfil = $_SESSION["admin"]["tipo"];

    $codigoUsuario = $_SESSION["admin"]["codigo_admin"];
      
    $codigo_admin = $nome = $senha = $tipo = $ativo = $data = "";

    if ( isset ( $codigoUsuario) ) 
    {
        // SELECT DADOS DO USUARIO TABELA ADMIN
		$sql = "SELECT a.*, date_format(data,'%d/%m/%Y') data, e.* 
            FROM Admin a, Endereco e 
            WHERE a.codigo_admin = ? AND 
            a.Endereco_codigo_endereco = e.codigo_endereco 
            LIMIT 1";
            
		$consulta = $pdo->prepare( $sql );
		$consulta->bindParam(1,$codigoUsuario);
        $consulta->execute();
        
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

        $codigo_admin = $dados->codigo_admin;
        $nome = $dados->nome;
        $login = $dados->login;
        $email = $dados->email;
        $senha = $dados->senha;
        $tipo = $dados->tipo;
        $ativo = $dados->ativo;
        $data = $dados->data;

        // Tabela Endereco
        $estado = $dados->estado;
        $cidade = $dados->cidade;
        $bairro = $dados->bairro;
        $rua = $dados->rua;
        $numero = $dados->numero;

    } 
    else 
    {
        $mensagem = "Erro!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }

?>

<div class="content-wrapper">
    <form class="form-horizontal" name="conta" method="POST" action="salvar/perfil" data-parsley-validate>        
        <div class="card-body">

            <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase">Minha Conta</h3>
                </div>
                <div class="col">
                    <a  href="pages/alterar-senha" class="btn btn-dark float-right">Alterar Senha <i class="ml-2 fas fa-lock"></i></a>
                </div>
            </div>

            <div class="row">

                <div class="col-4">
                    <div class="form-group">
                        <label for="data">Ult. Atua.</label>
                        <input type="text" class="form-control" value="<?=$data;?>" readonly>      
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="ativo" class="form-control" name="ativo" required data-parsley-required-message="Selecione!" readonly>
                            <option value="1" selected>Ativo</option>  
                        </select>
                    </div>
                    <script type="text/javascript">
						$("#ativo").val('<?=$ativo;?>');
					</script>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="tipo">Perfil:</label>
                            <select class="form-control" id="tipo" name="tipo" required data-parsley-required-message="Selecione!" readonly>
                                
                                <?php 

                                if ($perfil == "master") 
                                {

                                ?>

                                <option value="master">Master</option>

                                <?php 

                                }

                                else if ($perfil == "admin") 
                                {

                                ?>

                                <option value="admin">Administrador</option>

                                <?php 

                                }

                                else if ($perfil == "instrutor") 

                                {

                                ?>

                                <option value="instrutor" selected>Instrutor</option> 

                                <?php 
                                
                                }

                                else {
                                
                                ?>

                                <option value="" selected>Perfil ()</option>

                                <?php

                                }
                                
                                ?>
                    
                            </select>

					        <script type="text/javascript">
                            $("#tipo").val('<?=$tipo;?>');
					        </script>
                    </div>    
                </div>

            </div>

            <h6 class=" text-uppercase">Meus Dados</h6>
            <hr>

            <div class="form-group">
                <input type="hidden" class="form-control" name="codigo_admin" value="<?=$codigo_admin;?>">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" placeholder="Digite um nome" value="<?=$nome;?>" maxlength="45" autofocus required data-parsley-required-message="Preencha este campo!">         
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" placeholder="email@exemplo.com" value="<?=$email;?>" required data-parsley-required-message="Preencha o email!">     
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
                        <input class="form-control" name="cidade" value="<?=$estado;?>" readonly>
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
            <button type="submit" class="btn btn-success float-right"><i class="fas fa-redo-alt mr-2"></i>Atualizar</button>
        </div>

    </form>
</div>