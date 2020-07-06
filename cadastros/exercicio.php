<?php

    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
        include "verificaLogin.php";
    else
        include "../verificaLogin.php";

    include "config/funcoes.php";
      
    $codigo_exercicio	= $codigo_treino = $nome_treino = $duracao = $descricao = $tipo_exercicio = $peso_inicial = $nome_exercicio = "";

    if ( isset ($p[2]) ) 
    {
      $codigo_exercicio =  base64_decode($p[2]);

    // SELECT DADOS TABELA TREINO
		$sql = "SELECT * FROM Exercicio WHERE codigo_exercicio = :codigo_exercicio 
    LIMIT 1";
            
		$consulta = $pdo->prepare( $sql );
		$consulta->bindValue(":codigo_exercicio",$codigo_exercicio);
    $consulta->execute();
        
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

        $codigo_exercicio = $dados->codigo_exercicio;
        $codigo_treino = $dados->Treino_codigo_treino;
        $nome_exercicio = $dados->nome_exercicio;
        $descricao = $dados->descricao;
        $tipo_exercicio = $dados->tipo_exercicio;
        $arquivo = $dados->arquivo;
        $duracao = $dados->duracao;
        $serie_repeticao = $dados->serie_repeticao; 
        $peso_inicial = $dados->peso_inicial; 
        
    }   

?>
<div class="content-wrapper">
  
    <form class="form-horizontal" name="exercicio" method="POST" action="salvar/exercicio" enctype="multipart/form-data" data-parsley-validate>           
    <div class="card">
        <div class="card-header">
         
        <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase">Cadastro Exercício</h3>
                </div>
                <div class="col">
                    <a  href="cadastros/exercicio" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-table"></i></a>
                    <a  href="listar/exercicio" class="btn btn-dark float-right m-1">Listar <i class="ml-2 fas fa-list"></i></a>
                </div>
            </div>
        </div>  
            
    <div class="card-body">
       
      <div class="row">

      <?php

      $required = "";
        if ( empty ( $codigo_exercicio ) ) {
          $required = "required data-parsley-required-message=\"<i class='fas fa-times'></i> Selecione uma modalidade\" ";
        }

      ?>

        <div class="col-4">
          <div class="form-group">
              <label>Treino:</label>
              <select list="treinos" id="treino" name="codigo_treino" placeholder="Selecione..." <?=$required;?> class="form-control" onblur="selecionaTreino(this.value)">
                <option value="">Selecione...</option>
                <datalist id="treinos">
                  <?php

                    $sql = "
                    
                      SELECT t.codigo_treino, t.nome_treino, m.nome_modalidade FROM Treino t, Modalidade m, Treino_Modalidade tm
                      WHERE t.codigo_treino = tm.Treino_codigo_treino AND tm.Modalidade_codigo_modalidade = m.codigo_modalidade and t.status = 1
                      ORDER BY t.codigo_treino, m.nome_modalidade
                      
                      ";
                      $consulta = $pdo->prepare( $sql );
                      $consulta->execute();
                  
                      while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) 
                      {

                      echo "<option value='$dados->codigo_treino'>$dados->nome_treino - $dados->nome_modalidade </option>";

                      }
                    
                  ?>
                </datalist> 

              </select>
              <script type="text/javascript">
                $("#treino").val('<?=$codigo_treino;?>');
              </script>
          </div>
        </div>

       
        
      

        <div class="col-4">
          <div class="form-group">
            <label>Peso Inicial:</label>
            <input type="text" id="peso" class="form-control" name="peso_inicial" value="<?=$peso_inicial;?>" placeholder="Peso">
          </div>
        </div>

        <div class="col-4">
          <div class="form-group">
            <label>Duração:</label>  
              <input type="text" id="time" class="form-control" name="duracao" value="<?=$duracao;?>" placeholder="Horas:Minutos" maxlength="5" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha!" />
          </div>
        </div>

      </div>

      <div class="row">

        <div class="col-6">
                <div class="form-group">
                        <label>Tipo:</label>
                        <select list="tipo" id="tipo" name="tipo_exercicio" placeholder="Selecione..." <?=$required;?> class="form-control">
                        <option value="">Selecione...</option>
                        <datalist id="tipo">
                        <?php
                            $sql = "
                            
                            SELECT codigo_tipo_exercicio, descricao FROM Tipo_Exercicio
                            ORDER BY codigo_tipo_exercicio
                            
                            ";
                            $consulta = $pdo->prepare( $sql );
                            $consulta->execute();
                        
                            while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) 
                            {

                            echo "<option value='$dados->codigo_tipo_exercicio'>$dados->descricao</option>";

                            }   
                        ?>
                        </datalist> 
                    </select>
                        <script type="text/javascript">
                          $("#tipo").val('<?=$tipo_exercicio;?>');
                        </script>
                      </div>

                    </div>

                  <div class="col-6">

                    <div class="form-group">
                        <label>Serie/Repetições:</label>
                        <input type="text" id="serie" class="form-control" name="serie_repeticao" value="<?=$serie_repeticao;?>" placeholder="Serie/Repetições">
                      </div>

                  </div>

              </div>         

                  <div class="form-group">
                  <input type="hidden" class="form-control" name="codigo_exercicio"  value="<?=$codigo_exercicio;?>">
                    <label for="nome">Nome do Exercício:</label>
                    <input type="text" class="form-control" name="nome_exercicio" value="<?=$nome_exercicio;?>" onkeypress="return ApenasLetras(event,this);" placeholder="Digite um nome" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">
               
                </div>

                  <div class="form-group">
                    <label for="exampleInputFile">Imagem do Exercício</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="arquivo" class="custom-file-input" accept=".jpg" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Selecionar arquivo</label>
                      </div>
                    </div>
                  </div>
                   
                  <?php
                    //mostrar a foto se estiver editando
                    if ( !empty ( $codigo_exercicio ) ) {
                      // 12345 -> ../fotos/12345p.jpg
                      //muda o nome do arquivo
                      $imagem = "./imagens-exercicio/".$arquivo."p.jpg";
                      //mostra o arquivo dentro do img
                      echo "<div class='img-thumbnail text-center'>
                      <img src='$imagem'>
                      </div>";
                    }
                  ?>
                
                  <div class="form-group">
                        <label>Descrição:</label>
                        <textarea class="form-control" rows="3" name="descricao" maxlength="250" placeholder="Sobre o exercício..."><?=$descricao;?></textarea>
                    </div>    


                    <!-- time Picker -->
        
                  <!-- /.form group -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success float-right"><i class="fas fa-save mr-1"></i>Salvar</button>
                </div>


                    </div>
    </form>

    
                    </div>


<script type="text/javascript">

  function selecionaTreino(treino) {
    treino = treino.split(" - ");
    $("#codigo_treino").val(treino[0])
  }
  
  $(document).ready(function(){
    $('#time').mask('00:00');
  });

  $(document).ready(function(){
    $('#serie').mask('00/00');
  });

  $(document).ready(function(){
    $('#peso').mask('00(kg)');
  });

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
