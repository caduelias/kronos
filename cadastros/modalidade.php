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
        $codigo_horario = $dados->Horario_codigo_horario;
        $nome_modalidade = $dados->nome_modalidade;
        $descricao = $dados->descricao;
        $status = $dados->status;

    }   

?>

<div class="content-wrapper">
    <form class="form-horizontal" name="modalidade" method="POST" action="salvar/modalidade" data-parsley-validate>        
    <div class="card">
        <div class="card-header">

            <div class="row">

                <div class="col-6">
                    <h3 class="card-title text-uppercase">Cadastro Modalidade</h3>
                </div>
                
                <div class="col-6">
                    <a  href="cadastros/modalidade" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-table"></i></a>
                    <a  href="listar/modalidade" class="btn btn-dark float-right m-1">Listar<i class="ml-2 fas fa-list"></i></a>
                </div>

            </div>

        </div>    
    
    <div class="card-body">

            <div class="row">

                <?php

                $required = "";
                if ( empty ($codigo_horario) ) {
                    $required = "required data-parsley-required-message=\"<i class='fas fa-times'></i> Selecione!\" ";
                }

                ?>

                <div class="col-4">
                <div class="form-group">
                    <label>Horário:</label>
                    <select list="horarios" name="codigo_horario" id="codigo_horario" placeholder="Selecione..." <?=$required;?> class="form-control">
                        <option value="">Selecione...</option>
                        <datalist id="horarios">
                        <?php
                            $sql = "
                            
                            SELECT codigo_horario, periodo, horario_treino FROM Horario 
                            ORDER BY horario_treino
                            
                            ";
                            $consulta = $pdo->prepare( $sql );
                            $consulta->execute();
                        
                            while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) 
                            {

                            echo "<option value='$dados->codigo_horario'>$dados->horario_treino</option>";

                            }   
                        ?>
                        </datalist> 
                    </select>
                    <script type="text/javascript">
                        $("#codigo_horario").val('<?=$codigo_horario;?>');
                    </script>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="codigo_modalidade" value="<?=$codigo_modalidade;?>">
                        <label for="nomeModalidade">Nome:</label>
                        <input type="text" class="form-control" name="nome_modalidade" onkeypress="return ApenasLetras(event,this);" placeholder="Nome modalidade" value="<?=$nome_modalidade;?>" maxlength="45" autofocus required data-parsley-required-message="Preencha este campo!">         
                    </div>
                </div>

                 <div class="col-4">
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" class="form-control" name="status" required data-parsley-required-message="Selecione!">
                            <option value="">Selecione...</option>
                            <option value="2">Inativo</option>
                            <option value="1" selected>Ativo</option>    
                        </select>
                    </div>
                    <script type="text/javascript">
						$("#status").val('<?=$status;?>');
					</script>
                </div>

            </div>

            <div class="form-group">
                <label>Descrição:</label>
                <textarea class="form-control" rows="3" name="descricao" maxlength="250" placeholder="Sobre a modalidade..." required data-parsley-required-message="Preencha este campo!"><?=$descricao;?></textarea>
            </div>  
            
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-success float-right"><i class="fas fa-save mr-2"></i>Salvar</button>
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

</script>