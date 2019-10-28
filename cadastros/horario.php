<?php
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";
      
    $codigo_horario	= $periodo = $limite = $horario_treino = "";

    if ( isset ($p[2]) ) 
    {
      $codigo_horario =  base64_decode($p[2]);

    // SELECT DADOS TABELA HORARIO
		$sql = "SELECT * FROM Horario WHERE codigo_horario = :codigo_horario 
    LIMIT 1";
            
		$consulta = $pdo->prepare( $sql );
		$consulta->bindValue(":codigo_horario",$codigo_horario);
    $consulta->execute();
        
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

      $codigo_horario = $dados->codigo_horario;
      $periodo = $dados->periodo;
      $limite = $dados->limite;
      $horario_treino = $dados->horario_treino;
          
    }   

?>
<div class="content-wrapper">
  <form class="form-horizontal" name="horario" method="POST" action="salvar/horario" data-parsley-validate>
    <div class="card">
        <div class="card-header">
         
            <div class="row">

              <div class="col">
                  <h3 class="card-title text-uppercase">Cadastro Horário</h3>
              </div>

              <div class="col">
                 <a  href="listar/horario" class="btn btn-dark float-right m-1">Listar<i class="ml-2 fas fa-list"></i></a>
              </div>

            </div>
        </div>  
          <div class="card-body">

            <div class="row">

              <div class="form-group">
                <input type="hidden" class="form-control" name="codigo_horario" value="<?=$codigo_horario;?>">
              </div>
                
              <div class="col-4">

                <div class="form-group">
                  <label>Período:</label>
                  <select class="form-control" name="periodo" id="periodo" required required data-parsley-required-message="<i class='fas fa-times'></i> Selecione!">
                    <option value="">Selecione...</option>
                    <option value="1">Matutino</option>
                    <option value="2">Diurno</option>
                    <option value="3">Vespertino</option>
                    <option value="4">Noturno</option>
                  </select>   
                </div>

                <script type="text/javascript">
                  $("#periodo").val('<?=$periodo;?>');
                </script>

              </div>

              <div class="col-4">
                <div class="form-group">
                    <label>Horário Início:</label>
                      <input type="text" class="form-control" id="time" name="horario_treino" value="<?=$horario_treino;?>" placeholder="Horas:Minutos" required required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">
                </div>
              </div>

              <div class="col-4">
                <div class="form-group">
                  <label>Limite por Horário:</label>
                    <input type="number" class="form-control" name="limite" value="<?=$limite;?>" maxlength="3" placeholder="00" required required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">
                </div>
              </div>

            </div>

          </div>
            
          <div class="card-footer">
            <button type="submit" class="btn btn-success float-right"><i class="fas fa-save mr-1"></i>Salvar</button>
          </div>
    </div>
  </form>
</div>

<script type="text/javascript">
  
  $(document).ready(function(){
  $('#time').mask('00:00');

});

</script>
