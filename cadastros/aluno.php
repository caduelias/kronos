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

    // SELECT DADOS TABELA ALUNO, ENDERECO, TELEFONE
    // $sql = "select * from aluno";
    $sql = "  SELECT a.*,
                    e.*, 
                    t.*, 
                    m.*,
                    date_format(a.data_nasc,'%d/%m/%Y') as nascimento, 
                    date_format(a.data_cadastro,'%d/%m/%Y') as data 
                FROM aluno a
                INNER JOIN endereco e ON e.codigo_endereco = a.Endereco_codigo_endereco
                INNER JOIN telefone t ON t.Aluno_codigo_aluno = a.codigo_aluno
                LEFT JOIN mensalidade m ON m.Aluno_codigo_aluno = a.codigo_aluno
                WHERE a.codigo_aluno = :codigo_aluno 
                LIMIT 1; 
    ";

    $consulta = $pdo->prepare( $sql );
    $consulta->bindValue(":codigo_aluno",$codigo_aluno);
    $consulta->execute();
      
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    // Tabela Aluno
    $codigo_aluno = $dados->codigo_aluno;
    $codigo_usuario = $dados->Usuario_codigo_usuario;
    $codigo_endereco = $dados->Endereco_codigo_endereco;
    $nome_aluno = $dados->nome_aluno;
    $data_nasc 	= $dados->data_nasc;
    $sexo = $dados->sexo;
    $rg = $dados->rg;
    $cpf = $dados->cpf;
    $objetivo = $dados->objetivo;
    $email = $dados->email;
    $status = $dados->status;

    $data_cadastro = $dados->data_cadastro;

    // Tabela Endereco
    $estado = $dados->estado;
    $cidade = $dados->cidade;
    $bairro = $dados->bairro;
    $rua = $dados->rua;
    $numero = $dados->numero;

    // Tabela Telefone
    $num_telefone = $dados->num_telefone;
    $num_celular = $dados->num_celular;

    // Tabela Mensalidade
    $codigo_plano= $dados->Plano_codigo_plano;
    }   

?>
<div class="content-wrapper">
  <form class="form-horizontal" name="aluno" method="POST" action="salvar/aluno" data-parsley-validate>           
    <div class="card">
      <div class="card-header">
       
          <div class="row">
              <div class="col">
                  <h3 class="card-title text-uppercase">Cadastro Aluno</h3>
              </div>
              <div class="col">
                  <a  href="cadastros/aluno" class="btn btn-success float-right m-1">Novo<i class="ml-2 fas fa-table"></i></a>
                  <a  href="listar/aluno" class="btn btn-dark float-right m-1">Listar <i class="ml-2 fas fa-list"></i></a>
              </div>
          </div>
      </div>  
          
      <div class="card-body">
     
        <div class="row">

          <div class="col-4">
            <div class="form-group">
              <label for="status">Status:</label>
                <select id="status" class="form-control" name="status" required data-parsley-required-message="Selecione!">
                    <option value="">Selecione...</option>
                    <option value="0">Inativo</option>
                    <option value="1">Ativo</option>    
                </select>
                <script type="text/javascript">
                $("#status").val('<?=$status;?>');
            </script>
            </div> 
          </div>

          <div class="col-4">
            <div class="form-group">
              <label for="data">Data de Nascimento:</label>
              <input type="text" class="form-control date" name="data_nascimento" value="<?=$data_nasc;?>" placeholder="00/00/0000" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">
            </div>
          </div>
            
          <div class="col-4">
            <div class="form-group">
              <label for="sexo">Gênero:</label>
              <select class="form-control" name="sexo" id="sexo" required data-parsley-required-message="Selecione!">
                  <option value="">Selecione...</option>
                  <option value="M">Masculino</option>
                  <option value="F">Feminino</option>    
              </select>
              <script type="text/javascript">
                $("#sexo").val('<?=$sexo;?>');
            </script>
            </div>
          </div>

        </div>
                      
        <div class="form-group">

          <input type="hidden" class="form-control" name="codigo_aluno" value="<?=$codigo_aluno;?>">
    
          <label for="nome">Nome do Aluno:</label>
            <input type="text" class="form-control" name="nome_aluno" value="<?=$nome_aluno;?>" autofocus maxlength="80" onkeypress="return ApenasLetras(event,this);" placeholder="Digite um nome" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">        
        </div>

        <div class="row">

          <div class="col-6">
            <div class="form-group">
              <label for="rg">RG:</label>
              <input type="text" class="form-control" name="rg" value="<?=$rg;?>" placeholder="Informe um RG"  required data-parsley-required-message="<i class='fas fa-times'></i> Campo RG é obrigatório!!">
            </div>
                      
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control cpf" name="cpf" value="<?=$cpf;?>" placeholder="Informe um CPF" required data-parsley-required-message="<i class='fas fa-times'></i> Campo CPF é obrigatório!">
            </div>
          </div> 

          <div class="col-6">
            
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" name="email" value="<?=$email;?>" placeholder="Informe um e-mail" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">  
            </div>

            <div class="form-group">
              <label for="confirma">Confirmar Email:</label>
              <input type="email" id="redigite" class="form-control" value="<?=$email;?>" placeholder="Redigite o e-mail informado" required data-parsley-required-message="<i class='fas fa-times'></i> Preencha este campo!">  
            </div>

          </div>

        </div>
        
        <div class="row">

          <div class="col-6">
            <div class="form-group">
              <label for="telefone">Telefone:</label>
              <input type="text" class="form-control telefone" name="num_telefone" value="<?=$num_telefone;?>" placeholder="(00)00000-0000">
            </div>

            <div class="form-group">
              <label for="celular">Celular:</label>
              <input type="text" class="form-control telefone" name="num_celular" value="<?=$num_celular;?>" placeholder="(00)00000-0000">
            </div>
          </div>
          
          <div class="col-6">
              <div class="form-group">
                <label>Objetivo:</label>
                <textarea class="form-control" rows="3" name="objetivo" maxlength="70" placeholder="Objetivo do aluno..."><?=$objetivo;?></textarea>
              </div> 
          </div>   

        </div>
                    
        <div class="row">

          <div class="col-6">
              <div class="form-group">
                  <label for="estado">Estado:</label>           
                  <select id="estados" class="form-control" name="estado" required data-parsley-required-message="Selecione!">
                  
                  </select>
              </div>
              
              <div class="form-group">
              <label for="rua">Rua:</label>
              <input type="text" class="form-control" name="rua" value="<?=$rua;?>" placeholder="Rua" maxlength="45" required data-parsley-required-message="Preencha este campo!">   
            </div>

          </div>

          <div class="col-6">
              <div class="form-group">
                  <label for="cidade">Cidade:</label>
                  <select id="cidades" class="form-control" name="cidade" required data-parsley-required-message="Selecione!">
                  </select>
              </div>

            <div class="form-group">
              <label for="numero">Número:</label>
              <input type="text" class="form-control" name="numero" value="<?=$numero;?>" placeholder="Número" maxlength="8"required data-parsley-required-message="Preencha este campo!">   
            </div>

            <div class="form-group">
              <label for="bairro">Bairro:</label>
              <input type="text" class="form-control" name="bairro" value="<?=$bairro;?>" placeholder="Bairro" maxlength="45" required data-parsley-required-message="Preencha este campo!">     
            </div>

          </div>

        </div>

      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button type="submit" class="btn btn-success float-right" onclick="return verificaEmail()"><i class="fas fa-save mr-1"></i>Salvar</button>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">

$(document).ready(function(){
  $('.date').mask('00/00/0000');

  $('.cpf').mask('000.000.000-00', {reverse: true});

  $('.rg').mask('00.000.000-0'); 

  $('.telefone').mask('(00) 00000-0000');

  $("#redigite").bind('paste', function(e) {
        e.preventDefault();
    });

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

function verificaEmail(){
        var email = aluno.email.value;
        var redigite = aluno.redigite.value;
    
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
                aluno.email.focus();
                return false;
            }

            if(redigite == ""){
                    Toast.fire({
                        type: 'error',
                        title: 'Confirme o e-mail!'
                        
                    })
              
                aluno.redigite.focus();

                return false;
            }
            
            if(email != redigite){

                Toast.fire({
                        type: 'error',
                        title: 'E-mails informados são diferentes!'
                        
                    })

                aluno.redigite.focus();
            
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


