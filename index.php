<?php 
  // INICIANDO SESSÃO
  session_start();
  // CONFIG PARA EXIBIÇÃO DE ERROS
  ini_set("display_error",1);
  ini_set("display_startup_errors",1);
  error_reporting(E_ALL);
  // INCLUINDO ARQUIVO DE CONEXÃO
  include "config/conexao.php";
  // DEFININDO PORTA
  //$porta = $_SERVER["SERVER_PORT"];


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <base href="http://<?=$_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Kronos - Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" href="dist/img/kronos.png">
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

<script src="style/jquery.mask.js"></script>

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

<?php
        // VERIFICAR LOGIN
        if (!isset ($_SESSION["admin"]["codigo_admin"] ) ) {
            // NÃO ESTÁ LOGADO
            include "pages/login.php";
        } else { 
            // LOGIN 
            $pagina = "pages/home";
            // PASSANDO PARAMETRO À PÁGINA POR GET
            if (isset ($_GET["parametro"] ) ) {
                $pagina = trim ($_GET["parametro"] );
            }
            // CONFIG URL AMIGÁVEL
            $p = explode("/", $pagina);
            $pasta = $p[0];
            $arquivo = $p[1];
            // CONCACTENANDO
            $pagina = "$pasta/$arquivo.php";
            // INCLUIR LAYOUT
            include "layout.php";
        }
    ?>

</body>
</html>




<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });
  })
</script>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
