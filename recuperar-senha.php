<?php

    if ( ( session_status() != PHP_SESSION_ACTIVE ) or ( !isset ( $_SESSION["admin"]["codigo_admin"] ) ) ) 
    
    {

    }
      if ( isset ( $_POST["email"] ) )
      $email = trim ( $_POST["email"]);
    
    
        // ================================================================

        $sql = "SELECT email from Admin WHERE email = ? LIMIT 1";
        
        $consulta = $pdo->prepare($sql);
        
        $consulta->bindParam(1, $email);
        
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ); 

        $email = $dados->email;


    ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <base href="http://<?=$_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Recuperar Senha</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  
  <!-- Font -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  
  <!-- Estilos -->
  <link rel="stylesheet" type="text/css" href="style/customer.css">

<!-- DataTables -->

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"/>
 


  <!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>

<script type="text/javascript" src="build/js/parsley.min.js"></script>

<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript" src="build/js/lightbox-plus-jquery.js"></script>

<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>


<!-- DataTables -->
<script type="text/javascript" src="plugins/datatables/jquery.dataTables.js"></script>


<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>


<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>


<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>


<!-- InputMask -->
<script src="plugins/inputmask/jquery.inputmask.bundle.js"></script>
<script type="text/javascript" src="build/js/jquery.maskMoney.min.js"></script>

<script src="plugins/moment/moment.min.js"></script>

<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>


<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

</head>
<body>

<div class="content-wrapper card m-5">
    <form class="form-horizontal" name="recupera" method="POST" action="" data-parsley-validate>        
        <div class="card-body">
           
            <div class="row">
                <div class="col">
                <h3 class="text-center text-uppercase">Recuperar Senha</h3>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Informe o email:</label>
                <input type="email" class="form-control" name="email" placeholder="Informe o email cadastrado" autofocus required data-parsley-required-message="Preencha o email!">
            </div>

            <div class="form-group">
                <p class="text-center">Será enviado um e-mail para recuperação de senha no email digitado no campo acima!</p>
                
                <p class="text-center">Recupere sua senha seguindo as orientações contidas no email!</p>

                <p class="text-center"> Lembrando que o email informado deve estar associado a uma conta ativa no sistema!</p>
            </div>  
     
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info float-right"><i class="fas fa-envelope mr-2"></i>Enviar</button>
            <a href="index.php" class="btn btn-dark float-left"><i class="fas fa-reply mr-2"></i>Voltar</a>
        </div>
    </form>
</div>
</body>
</html>
