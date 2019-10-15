<?php
    // ARQUIVO DE FUNÇÕES PHP
    // FUNÇÃO ALERTA DE MENSAGEM
    function error($titulo, $mensagem) {
        
        ?>

            <script>
                Swal.fire({
                type: 'error',  
                title: '<?= $titulo;?>',
                text: '<?= $mensagem;?>',
                })
            </script> 
        <?php
        
    }



    function errorBack($titulo, $mensagem) {
        
        ?>

            <script>
                Swal.fire({
                type: 'error',  
                title: '<?= $titulo;?>',
                text: '<?= $mensagem;?>',
                confirmButtonText: 'Ok',
                showLoaderOnConfirm: true,
                    preConfirm: () => {
                            history.back();
                        }
                })
            </script> 
        <?php
        
    }

    function sucessBack($titulo, $mensagem) {
        
        ?>

            <script>
                Swal.fire({
                type: 'success',  
                title: '<?= $titulo;?>',
                text: '<?= $mensagem;?>',
                confirmButtonText: 'Ok',
                showLoaderOnConfirm: true,
                    preConfirm: () => {
                            history.back();
                        }
                })
            </script> 
        <?php
        
    }

    function warning($titulo, $mensagem) {
        
        ?>

            <script>
                Swal.fire({
                type: 'warning',  
                title: '<?= $titulo;?>',
                text: '<?= $mensagem;?>',
                confirmButtonText: 'Ok',
                showLoaderOnConfirm: true,
                    preConfirm: () => {
                            history.back();
                        }
                })
            </script> 
        <?php
        
    }
    // FUNÇÃO MENSAGEM DE CADASTRO
    function sucessLink($titulo, $mensagem, $link) {
        
        ?> 
        <!-- Modal -->
                <script>
                 Swal.fire({
                type: 'success',  
                title: '<?= $titulo;?>',
                text: '<?= $mensagem;?>',
                confirmButtonText: 'Ok',
                showLoaderOnConfirm: true,
                     
                    preConfirm: ()  => {
                        window.location='<?=$link;?>';
                        }
 
                    
                })
                </script>
    <?php
    }
    

    function errorLink($titulo, $mensagem, $link) {
        
        ?> 
        <!-- Modal -->
                <script>
                 Swal.fire({
                type: 'error',  
                title: '<?= $titulo;?>',
                text: '<?= $mensagem;?>',
                confirmButtonText: 'Ok',
                showLoaderOnConfirm: true,
                    preConfirm: () => {
                        location.href='<?=$link;?>';
                        }
                })
                </script>
    <?php
    }


    function toast($titulo) {
        
        ?> 
        <!-- Modal -->
                <script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        onClose: () => {
                            history.back();
                        }
                    })

                    Toast.fire({
                        type: 'error',
                        title: '<?=$titulo;?>'
                    })

                </script>
    
    <?php
    }


    function confirm($param, $tipo, $button, $titulo, $link,  $mensagem) {
        
        ?>

            <script>
                      Swal.fire({
             
             title: '<?=$titulo;?>',
             text: "<?=$mensagem;?>",
             type: '<?=$tipo;?>',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: '<?=$button;?>',
             cancelButtonText: 'Cancelar',
             showLoaderOnConfirm: true,
                   preConfirm: () => {
                       location.href='<?=$link;?>'+<?=$param;?>;
                       }
           })
            </script> 
        <?php
        
    } 

    function toastLogin($titulo) {
        
        ?> 
        <!-- Modal -->
                <script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    })

                    Toast.fire({
                        type: 'error',
                        title: '<?=$titulo;?>'
                    })

                </script>
    
    <?php

    }

    function updateSenha($titulo, $mensagem, $link) {
        
    ?>
     
    <script>
    let timerInterval
    Swal.fire({
    title: '<?=$titulo;?>',
    type: 'success',  
    html: 'A sessão será encerrada em <strong></strong> segundos!<br /> <?=$mensagem;?>',
    timer: 10000,
    onBeforeOpen: () => {
        Swal.showLoading()
        timerInterval = setInterval(() => {
        Swal.getContent().querySelector('strong')
            .textContent = (Swal.getTimerLeft() / 1000)
            .toFixed(0)
        }, 100)
    },
    onClose: () => {
        clearInterval(timerInterval)
        location.href='<?=$link;?>'
    }
    }).then((result) => {
    if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.timer
        
    ) {
        location.href='<?=$link;?>'
    }
    })
    </script>

    <?php

    }

	// FUNÇÃO FORMATA VALOR
	function formataValor ($valor){
		$valor = str_replace(".", "", $valor);
		$valor = str_replace(",", ".", $valor);
		return $valor;
    }
    
	/*
    $data = '25/11/1999';
   
    // Separa em dia, mês e ano
    list($dia, $mes, $ano) = explode('/', $data);
   
    // Descobre que dia é hoje e retorna a unix timestamp
    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    // Descobre a unix timestamp da data de nascimento do fulano
    $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
   
    // Depois apenas fazemos o cálculo já citado :)
    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
    */
    
	// FUNÇÃO FORMATA E VALIDA DATA
	function formataData( $data){
		//12/04/2019 -> 2019-02-10
		$data = explode("/",$data);
		//0 - dia/ 1 - mes/ 2 - ano
		if ( !checkdate($data[1], $data[0], $data[2])){
            $mensagem = "Data Inválida!";
            $titulo = "Data";
			error($titulo, $mensagem);
		}
		$data = $data[2]."-".$data[1]."-".$data[0];
		return $data;
	}