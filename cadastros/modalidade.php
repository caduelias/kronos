<?php
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";
      
    $codigo_modalidade	= $nome_modalidade = $ativo = $descricao = "";

    if ( isset ($p[2]) ) 
    {
        $codigo_modalidade =  base64_decode($p[2]);

        // SELECT DADOS DO USUARIO TABELA ADMIN
		$sql = "SELECT * FROM Modalidade WHERE codigo_modalidade = ?
            LIMIT 1";
            
		$consulta = $pdo->prepare( $sql );
		$consulta->bindParam(1,$codigo_modalidade);
        $consulta->execute();
        
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

        $codigo_modalidade = $dados->codigo_modalidade;
        $nome_modalidade = $dados->nome_modalidade;
        $descricao = $dados->descricao;
        $ativo = $dados->ativo;

    }   

?>

<div class="content-wrapper">
    <form class="form-horizontal" name="modalidade" method="POST" action="salvar/modalidade" data-parsley-validate>        
        <div class="card-body">

            <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase">Cadastro modalidade</h3>
                </div>
                <div class="col">
                    <a  href="listar/modalidade" class="btn btn-dark float-right">Listar <i class="ml-2 fas fa-table"></i></a>
                </div>
            </div>

            <div class="row">

                <div class="col-8">
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="codigo_modalidade" value="<?=$codigo_modalidade;?>">
                        <label for="nomeModalidade">Nome Modalidade:</label>
                        <input type="text" class="form-control" name="nome_modalidade" placeholder="Nome modalidade" value="<?=$nome_modalidade;?>" maxlength="45" autofocus required data-parsley-required-message="Preencha este campo!">         
                    </div>
                </div>

                 <div class="col-4">
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="ativo" class="form-control" name="ativo" required data-parsley-required-message="Selecione!">
                            <option value="">Selecione...</option>
                            <option value="0">Inativo</option>
                            <option value="1" selected>Ativo</option>    
                        </select>
                    </div>
                    <script type="text/javascript">
						$("#ativo").val('<?=$ativo;?>');
					</script>
                </div>

            </div>

            <div class="form-group">
                <label>Descrição:</label>
                <textarea class="form-control" rows="3" name="descricao" maxlength="75" placeholder="Sobre a modalidade..." required data-parsley-required-message="Preencha este campo!"><?=$descricao;?></textarea>
            </div>  
            
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-success float-right"><i class="fas fa-save mr-2"></i>Salvar</button>
        </div>

    </form>
</div>