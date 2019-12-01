<?php
    // INCLUINDO FUNÇÕES, VERIFICAÇÃO DE LOGIN E NÍVEL DE PERMISSÃO
    include "config/conexao.php";
    include "config/funcoes.php";

    if ( $_POST ) 
    {   
        foreach ($_POST as $key => $value) 
        {
            //echo "<p>$key $value</p>";
            //$key - nome do campo
            //$value - valor do campo (digitado)
            if ( isset ( $_POST[$key] ) )
            {
                $$key = trim ( $value );
            } 
        }
        
        $sql = "SELECT nome, email from Admin WHERE email = ? AND ativo = 1 LIMIT 1";
        
        $consulta = $pdo->prepare($sql);
        
        $consulta->bindParam(1, $email);
        
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ); 

        $nome = $dados->nome;
        $emailVerificado = $dados->email;

        var_dump($emailVerificado, $nome);

        if ($emailVerificado) {
          $hash = md5(time().$emailVerificado);
          echo $hash;
        }
        
        $destinatario = $emailVerificado;
        $nomeEmail = $nome;
        $mensagem = "teste";
        $data_envio = date('d/m/Y');
        $hora_envio = date('H:i:s');

        var_dump($destinatario, $nomeEmail, $mensagem, $data_envio, $hora_envio);
$arquivo = "
  <style type='text/css'>
  body {
  margin:0px;
  font-family:Verdane;
  font-size:12px;
  color: #666666;
  }
  a{
  color: #666666;
  text-decoration: none;
  }
  a:hover {
  color: #FF0000;
  text-decoration: none;
  }
  </style>
    <html>
        <table width='510' border='1' cellpadding='1' cellspacing='1' bgcolor='#CCCCCC'>
            <tr>
              <td>
  <tr>
                 <td width='500'>Nome:$nomeEmail</td>
                </tr>
                <tr>
                  <td width='320'>E-mail:<b>$destinatario</b></td>
     </tr>
 
                <tr>
                  <td width='320'>Mensagem:$mensagem</td>
                </tr>
            </td>
          </tr>  
          <tr>
            <td>Este e-mail foi enviado em <b>$data_envio</b> às <b>$hora_envio</b></td>
          </tr>
        </table>
    </html>
  ";

  $destino = $destinatario;
  $assunto = "Recuperação de Senha!";
 
  var_dump($destino, $assunto);

  // É necessário indicar que o formato do e-mail é html
  $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
      $headers .= 'From: $nomeEmail <$destino>';
  //$headers .= "Bcc: $EmailPadrao\r\n";
   
  $enviaremail = mail($destino, $assunto, $arquivo, $headers);

  if($enviaremail){
  $mgm = "E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário";
  echo " $msg<meta http-equiv='refresh' content='10;URL=contato.php'>";
  } else {
  $mgm = "ERRO AO ENVIAR E-MAIL!";
  echo $msg;
  }
            // Enviar Email                <p class="text-center">Será enviado um e-mail para recuperação de senha no email digitado no campo acima!</p>
                
                //<p class="text-center">Recupere sua senha seguindo as orientações contidas no email!</p>
        }
        else
        {   
            $titulo = "erro";
            $mensagem = "Este e-mail não está associado a nenhuma conta ou a conta está inativa!";
            errorBack($titulo, $mensagem);
            exit;
        }

    } 
    else 
    {
        $mensagem = "Requisição Inválida!";
        $link = "index.php";
        errorLink($titulo, $mensagem, $link);
    }
