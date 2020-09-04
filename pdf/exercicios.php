<?php

  // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN
    if ( file_exists ( "verificaLogin.php" ) )
      include "verificaLogin.php";
    else
      include "../verificaLogin.php";

    include "config/funcoes.php";

    $codigo_aluno = $nome_exercicio = $codigo_usuario = $codigo_endereco = $nome_aluno = $data_nasc = $sexo = $rg = $cpf = $objetivo = $email = $status = $dependente = $codigo_dependente = $data_cadastro = $rua = $bairro = $numero = "";

    if ( isset ($p[2]) ) {
    $codigo_aluno =  base64_decode($p[2]);

    $sql = " 
      select 
        e.nome_exercicio,
          te.descricao,
          e.serie_repeticao,
          e.arquivo,
          e.duracao,
          e.peso_inicial,
          t.nome_treino,
          tt.descricao
      from exercicio e 
      INNER join tipo_exercicio te on te.codigo_tipo_exercicio = e.tipo_exercicio
      INNER JOIN aluno_exercicio ae on ae.codigo_exercicio = e.codigo_exercicio
      inner JOIN treino t on t.codigo_treino = e.Treino_codigo_treino
      inner JOIN tipo_treino tt on tt.codigo_tipo_treino = t.tipo_treino
      WHERE ae.codigo_aluno = :codigo_aluno
      order by t.nome_treino
    ";
    $consulta = $pdo->prepare( $sql );
    $consulta->bindValue(":codigo_aluno",$codigo_aluno);
    $consulta->execute();
      
    $exercicios = $consulta->fetchAll(PDO::FETCH_OBJ) ?? null;

    $sql = " 
      select 
          a.nome_aluno,
          date_format(a.data_cadastro,'%d/%m/%Y') as data_cadastro,
          e.estado,
          e.cidade,
          t.num_celular,
          t.num_telefone
      from aluno a 
        inner join endereco e on e.codigo_endereco = a.Endereco_codigo_endereco
        inner join telefone t on t.Aluno_codigo_aluno = a.codigo_aluno
      WHERE a.codigo_aluno = :codigo_aluno
      LIMIT 1
    ";
    $consulta = $pdo->prepare( $sql );
    $consulta->bindValue(":codigo_aluno",$codigo_aluno);
    $consulta->execute();
      
    $aluno = $consulta->fetch(PDO::FETCH_OBJ) ?? null;

    $sql = " 
      select 
        m.nome_modalidade,
        h.periodo,
        h.horario_treino
      from modalidade m 
        inner join horario h on h.codigo_horario = m.Horario_codigo_horario
        inner join aluno_modalidade am on am.codigo_modalidade = m.codigo_modalidade
      WHERE am.codigo_aluno = :codigo_aluno;
    ";
    $consulta = $pdo->prepare( $sql );
    $consulta->bindValue(":codigo_aluno",$codigo_aluno);
    $consulta->execute();
      
    $modalidades = $consulta->fetchAll(PDO::FETCH_OBJ) ?? null;

    $sql = "
      select 
        p.nome_plano,
        p.mensalidade
      from plano p
        inner join aluno_plano ap on ap.codigo_plano = p.codigo_plano
      WHERE ap.codigo_aluno = :codigo_aluno;
    ";
    $consulta = $pdo->prepare( $sql );
    $consulta->bindValue(":codigo_aluno",$codigo_aluno);
    $consulta->execute();
      
    $planos = $consulta->fetchAll(PDO::FETCH_OBJ) ?? null;

  } else {
    $titulo = "";
    $mensagem = "Parâmetro aluno obrigátorio!";
    $link = "pages/home";
    errorLink( $titulo, $mensagem, $link );
  } 

?>

<?php

    if ($codigo_aluno) {

?>

<div class="content-wrapper">      
    <div class="card">
      <div class="card-header">
         <!-- Main content -->
         <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-user"></i> Aluno(a): <?=$aluno->nome_aluno;?>
                    <small class="float-right">Data cadastro: <?=$aluno->data_cadastro;?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                  <b>Invoice #007612</b><br>
                  <br>
                  <b>Endereço: </b> <?=$aluno->cidade;?>-<?=$aluno->estado;?><br>
                  <b>Telefone:</b> <?=$aluno->num_telefone;?><br>
                  <b>Celular:</b> <?=$aluno->num_celular;?>
                </div>

                <div class="col-sm-4 invoice-col">
                 Planos
                 <address>
                  <?php

                    if ($planos) {
                      foreach($planos as $plano) {

                        $valor_plano = number_format($plano->mensalidade, 2, ',', '.');

                        $info_plano = "<p class='text-success'>$plano->nome_plano - R$ $valor_plano</p>";
                        echo $info_plano;
                      }
                    } else {
                      $info_plano = "<p>Sem planos</p>";
                      echo $info_plano;
                    }
                  ?>
                 </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  Modalidades
                  <address>
                  <?php

                    if ($modalidades) {
                      foreach($modalidades as $modalidade) {

                        $info_modalidade = "
                            <b>$modalidade->nome_modalidade - $modalidade->horario_treino</b></br>
                        ";
                        echo $info_modalidade;
                      }
                    } else {
                      $info_modalidade = "<b>Sem modalidades</b></br>";
                      echo $info_modalidade;
                    }
                  ?>
                 </address>
                </div>
              </div>
      </div>  
          
      <div class="card-body">
        <h4 class="text-center">Exercícios</h4>
        <div class="row d-flex align-items-stretch">
          <?php 

            if ($exercicios) {

              foreach($exercicios as $exercicio) {

                if (isset($exercicio->arquivo)) {
                  $imagem = $exercicio->arquivo.'p.jpg';
                  $imagem_check = './imagens-exercicio/'.$imagem;
                  if (!file_exists($imagem_check)) {
                    $imagem = 'imagem_default.png';
                  }
                } else {
                  $imagem = 'imagem_default.png';
                }
               
                $cards = " 
                <div class='col-12 col-sm-6 col-md-4 d-flex align-items-stretch'>
                  <div class='card bg-light'>
                      <div class='card-header text-muted border-bottom-0'>
                        Treino: $exercicio->nome_treino
                      </div>
                      <div class='card-body pt-0'>
                        <div class='row'>
                          <div class='col-7'>
                            <h2 class='lead'><b>$exercicio->nome_exercicio</b></h2>
                            <p class='text-muted text-sm'><b>Tipo: </b> $exercicio->descricao </p>
                            <ul class='ml-4 mb-0 fa-ul text-muted'>
                              <li class='small'><span class='fa-li'>
                              <i class='fas fa-lg fa-undo-alt'></i></span> 
                              Series: $exercicio->serie_repeticao</li>
                              <li class='small'><span class='fa-li'>
                              <i class='fas fa-lg fa-clock'></i></span> 
                              Tempo: $exercicio->duracao</li>
                              <li class='small'><span class='fa-li'>
                              <i class='fas fa-lg fa-dumbbell'></i></span> 
                              Peso: $exercicio->peso_inicial</li>
                            </ul>
                          </div>
                         
                          <div class='col-5 text-center'>
                            <img src='./imagens-exercicio/$imagem' alt='' class='rounded img-fluid'>
                          </div>
                        </div>
                      </div>
                      <div class='card-footer'>
                        <div class=''>
                          <label>Anotações:</label>
                          <input type='text' class='form-control' readonly></input>
                        </div>
                      </div>
                    </div>
                  
                </div>
              ";
                
              echo $cards;
              }

            } else {
              $cards = "<p>Sem exercícios</p>";
              echo $cards;
            }

          ?>

        </div>
      </div>
      <!-- /.card-body -->
  </div>
</div>

  <script type="text/javascript"> 
    window.addEventListener("load", window.print());
  </script>


<?php

          }

?>
