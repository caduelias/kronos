<?php
    include "config/funcoes.php";

    $perfil = $_SESSION["admin"]["tipo"];

    $codigoAcesso = $_SESSION["admin"]["codigo_admin"];
      
    $codigo_admin = $nome = $senha = $tipo = $ativo = $data = "";

	//$p[1] -> index.php (id do registro)
	if ( isset ( $codigoAcesso) ) {

		//selecionar os dados conforme o id
		$sql = "SELECT *, date_format(data,'%d/%m/%Y') data 
			FROM Admin 
			WHERE codigo_admin = ? LIMIT 1";
		$consulta = $pdo->prepare( $sql );
		$consulta->bindParam(1,$codigoAcesso);
		$consulta->execute();
		//recuperar os dados
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

        $codigo_admin = $dados->codigo_admin;
        $nome = $dados->nome;
        $email = $dados->email;
        $data = $dados->data;
        $tipo = $dados->tipo;
        $ativo = $dados->ativo;

	} else {
        $mensagem = "Erro na Requisição!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }

?>
<div class="content-wrapper">

    <form class="form-horizontal" name="admin" method="POST" action="salvar/perfil" data-parsley-validate>        
        <div class="card-body">
            <div class="row">
                <div class="col">
                <h3 class="card-title">Minha Conta</h3>
    </div>
    <div class="col">

    </div>
        </div>
        <div class="row">
            <div class="col-4">
                  <div class="form-group">
                <label for="status">Status:</label>
                    <select id="ativo" class="form-control" name="ativo" required data-parsley-required-message="Selecione!" readonly>
                        <option value="">Selecione... </option>
                        <option value="1" selected>Ativo</option>  
                    </select>

					<script type="text/javascript">
						$("#ativo").val('<?=$ativo;?>');
					</script>
                </div>
            </div>

    <div class="col-5">

        <div class="form-group">
                <label for="tipo">Perfil:</label>
                    <select class="form-control" id="tipo" name="tipo" required data-parsley-required-message="Selecione!" readonly>
                        <option value="">Selecione...  </option>
                        <?php 

                            if ($perfil == "master") 

    {
        ?>

                        <option value="master">Master</option>

                        <?php 
    }
    ?>

<?php 

if ($perfil == "admin") 

{
?>

<option value="admin">Administrador</option>

<?php 
}
?>

<?php 

if ($perfil == "instrutor") 

{
?>
 <option value="instrutor" selected>Instrutor</option> 

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

            <div class="form-group">
                    <input type="hidden" class="form-control" name="codigo_admin" value="<?=$codigo_admin;?>">
                <label for="modalidade">Nome:</label>
                    <input type="text" class="form-control" name="nome" placeholder="Digite um nome" value="<?=$nome;?>" maxlength="15" autofocus required data-parsley-required-message="Preencha este campo!">
                   
            </div>


            <div class="form-group">
                <label for="modalidade">Email:</label>
                    <input type="email" class="form-control" name="email" placeholder="email@exemplo.com" value="<?=$email;?>" required data-parsley-required-message="Preencha o email!">
                   
            </div>
            

            <div class="form-group">
                <label for="data">Ultima Atualização:</label>
                    <input type="text" class="form-control" value="<?=$data;?>" readonly>
                   
            </div>
            
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-success float-right"><i class="fas fa-user-plus"></i> Atualizar</button>
        </div>

    </form>
</div>