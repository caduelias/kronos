<?php

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

    // FUNÇÃO ALERTA DE MENSAGEM COM IMAGEM
    function messageImage(string $titulo = null, string $mensagem = null, string $urlImage) {
        ?>
        <script>
            titulo = '<?=$titulo;?>';
            mensagem = '<?=$mensagem;?>';
            imagem = '<?=$urlImage;?>';
            Swal.fire({
                title: titulo,
                text: mensagem,
                imageUrl: imagem,
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'Custom image',
            })
        </script>
        <?php
    }
    
    // FUNÇÃO ALERTA ERROR DE MENSAGEM RETORNANDO PÁGINA ANTERIOR
    function errorBack(string $titulo = null, string $mensagem) {
        ?>
        <script>
            titulo = '<?=$titulo;?>';
            mensagem = '<?=$mensagem;?>';
            Swal.fire({
                type: 'error',  
                title: titulo,
                text: mensagem,
                confirmButtonText: 'Ok',
                showLoaderOnConfirm: true,
                closeOnConfirm: true,
                onClose: () => {
                    window.history.back();
                }
            })
        </script> 
        <?php 
    }

    // FUNÇÃO ALERTA SUCESSO DE MENSAGEM RETORNANDO PÁGINA ANTERIOR
    function sucessBack($titulo, $mensagem) {
        ?>
        <script>
            Swal.fire({
                type: 'success',  
                title: '<?= $titulo;?>',
                text: '<?= $mensagem;?>',
                confirmButtonText: 'Ok',
                showLoaderOnConfirm: true,
                closeOnConfirm: true,
                onClose: () => {
                    window.history.back();
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
    function sucessLink(string $titulo = null, string $mensagem, string $link) 
    {
        ?> 
        <script>
            titulo = '<?=$titulo;?>';
            mensagem = '<?=$mensagem;?>';
            link = '<?=$link;?>';
            Swal.fire({
                type: 'success',  
                title: titulo,
                text: mensagem,
                confirmButtonText: 'Ok',
                showLoaderOnConfirm: true,    
                preConfirm: () => {
                    window.location= link;
                },
                onClose: () => {
                    window.location= link;
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
	function formataFloat ($valor){
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
    
 
function caracter($str) {
    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
    $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
    return $str;
}



function redimensionarImagem($pastaFotos,$imagem,$nome)	{

    $imagem = $pastaFotos.$imagem;
    
    list($largura1, $altura1) = getimagesize($imagem);

    $largura = 800;
    $percent = ($largura/$largura1);
    $altura = $altura1 * $percent;

    $imagem_gerada = $pastaFotos.$nome."g.jpg";
    $path = $imagem;
    $imagem_orig = ImageCreateFromJPEG($path);
    $pontoX = ImagesX($imagem_orig);
    $pontoY = ImagesY($imagem_orig);
    $imagem_fin = ImageCreateTrueColor($largura, $altura);
    ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largura+1, $altura+1, $pontoX, $pontoY);
    ImageJPEG($imagem_fin, $imagem_gerada,100);
    ImageDestroy($imagem_orig);
    ImageDestroy($imagem_fin); 

    $largura = 640;
    $percent = ($largura/$largura1);
    $altura = $altura1 * $percent;
    
    $imagem_gerada = $pastaFotos.$nome."m.jpg";
    $path = $imagem;
    $imagem_orig = ImageCreateFromJPEG($path);
    $pontoX = ImagesX($imagem_orig);
    $pontoY = ImagesY($imagem_orig);
    $imagem_fin = ImageCreateTrueColor($largura, $altura);
    ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largura+1, $altura+1, $pontoX, $pontoY);
    ImageJPEG($imagem_fin, $imagem_gerada,80);
    ImageDestroy($imagem_orig);
    ImageDestroy($imagem_fin);
    
    $largura = 250;
    $percent = ($largura/$largura1);
    $altura = $altura1 * $percent;

    $imagem_gerada = $pastaFotos.$nome."p.jpg";
    $path = $imagem;
    $imagem_orig = ImageCreateFromJPEG($path);
    $pontoX = ImagesX($imagem_orig);
    $pontoY = ImagesY($imagem_orig);
    $imagem_fin = ImageCreateTrueColor($largura, $altura);
    ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largura+1, $altura+1, $pontoX, $pontoY);
    ImageJPEG($imagem_fin, $imagem_gerada,80);
    ImageDestroy($imagem_orig);
    ImageDestroy($imagem_fin);

    //apagar a imagem antiga
    unlink ($imagem);
}

    //FUNCÃO PARA VALIDAR CPF
    function validaCPF(string $cpf): bool 
    {
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    function validaData(string $data): bool
    {
        // data é menor que 8
        if ( strlen($data) < 8){
            return false;
        } else {
            // verifica se a data possui
            // a barra (/) de separação
            if(strpos($data, "/") !== FALSE){
                //
                $partes = explode("/", $data);
                // pega o dia da data
                $dia = $partes[0];
                // pega o mês da data
                $mes = $partes[1];
                // prevenindo Notice: Undefined offset: 2
                // caso informe data com uma única barra (/)
                $ano = isset($partes[2]) ? $partes[2] : 0;
    
                if (strlen($ano) < 4) {
                    return false;
                } else {
                    // verifica se a data é válida
                    if (checkdate($mes, $dia, $ano)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }else{
                return false;
            }
        }
    }

    function validaIdade(string $dataNascimento): bool
    {
        $data = $dataNascimento;
        
        // Separa em dia, mês e ano
        list($dia, $mes, $ano) = explode('/', $data);
    
        // Descobre que dia é hoje e retorna a unix timestamp
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        // Descobre a unix timestamp da data de nascimento do fulano
        $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
    
        // Depois apenas fazemos o cálculo já citado :)
        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

        if ($idade > 100 || $idade < 8){
            return false;
        }
        return true;
    }

    // FUNÇÃO FORMATA DATA 12/04/2019 -> 2019-02-10
    function formataData(string $data): string
    {
        $data = explode("/",$data);
        //0 - dia/ 1 - mes/ 2 - ano
        if ( !checkdate($data[1], $data[0], $data[2])){
            $mensagem = "Data Inválida!";
            $titulo = "Informe uma data válida!";
            errorBack($titulo, $mensagem);
        }
        $data = $data[2]."-".$data[1]."-".$data[0];
        return $data;
    }
