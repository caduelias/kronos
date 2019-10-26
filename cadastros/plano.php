<?php

  if ( file_exists ( "permissaoAdmin.php" ) )
    include "permissaoAdmin.php";
  else
    include "../permissaoAdmin.php";

  include "config/funcoes.php";

  $tipo = $_SESSION["admin"]["tipo"];

?>
<div class="content-wrapper">
    <form class="form-horizontal" name="plano" method="POST" action="salvar/plano" data-parsley-validate>
                
                <div class="card-body">

                <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="ativo" class="form-control" name="ativo" required data-parsley-required-message="Selecione!">
                            <option value="">Selecione... </option>
                            <option value="1" selected>Ativo</option>
                            <option value="0">Inativo</option>  
                        </select>

                        <script type="text/javascript">
                            $("#ativo").val('<?=$ativo;?>');
                        </script>
                    </div>


                  <div class="form-group">
                  <input type="text" class="form-control" name="codigo_plano">
                    <label for="plano">Nome do Plano:</label>
                    <input type="text" class="form-control" name="nome_plano" placeholder="Digite um nome" required>

                </div>

              <div class="row">
                <div class="col-6">
                <div class="form-group">

                    <label for="taxa">Taxa de adesão:</label>
                    <input type="text" class="form-control" name="taxa_adesao" id="taxa" placeholder="Taxa" required>
                
                </div>
                </div>
                <div class="col-6">
                <div class="form-group">
                    <label for="valor">Valor da mensalidade:</label>
                    <input type="text" class="form-control" name="modalidade" id="valor" placeholder="Valor" required>
                    
                </div>
                </div>

                </div>

                  <div class="form-group">
                        <label>Descrição:</label>
                        <textarea class="form-control" rows="3" name="descricao" maxlength="240" placeholder="Sobre a plano..." ></textarea>
                        
                    </div>    
      
                
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> Salvar</button>
                </div>



    </form>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		//aplica a mascara de valor no campo
		$("#valor").maskMoney({
			thousands: ".",
			decimal: ","
		});

    $("#taxa").maskMoney({
			thousands: ".",
			decimal: ","
		});

	})
</script>