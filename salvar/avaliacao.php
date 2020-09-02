<?php

declare(strict_types=1);

include "config/funcoes.php";   
   
    if (file_exists("verificaLogin.php") )
       include "verificaLogin.php";
    else
       include "../verificaLogin.php";

    try {

        if (!$_POST) {
            throw new Exception("Requisição inválida", 400);
        }

        $avaliacao = $_POST;

        if (!($avaliacao['codigo_aluno']) ) {
            throw new Exception("codigo aluno é obrigatório!", 400);
        } else if (!($avaliacao['data_nascimento']) ) {
            throw new Exception("data_nascimento é obrigatório!", 400);
        } else if (!($avaliacao['sexo']) ) {
            throw new Exception("genero é obrigatório!", 400);
        } else if (!($avaliacao['peso']) ) {
            throw new Exception("peso é obrigatório!", 400);
        } else if (!($avaliacao['axilar_media']) ) {
            throw new Exception("dobra axilar_media é obrigatório!", 400);
        } else if (!($avaliacao['abdominal']) ) {
            throw new Exception("dobra abdominal é obrigatório!", 400);
        } else if (!($avaliacao['suprailiaca']) ) {
            throw new Exception("dobra suprailiaca é obrigatório!", 400);
        } else if (!($avaliacao['coxa']) ) {
            throw new Exception("dobra coxa é obrigatório!", 400);
        } else if (!($avaliacao['panturrilha_medial']) ) {
            throw new Exception("dobra panturrilha é obrigatório!", 400);
        } else if (!($avaliacao['altura']) ) {
            throw new Exception("altura é obrigatório!", 400);
        } else if (!($avaliacao['subescapular']) ) {
            throw new Exception("dobra subescapular é obrigatorio!", 400);
        } else if (!($avaliacao['triceps']) ) {
            throw new Exception("dobra triceps é obrigatório!", 400);
        }

        try {
            $sql = "
                SELECT 
                    DATE_FORMAT(data_avaliacao, '%d/%m/%Y') as ultimaavaliacao,
                    DATEDIFF(data_avaliacao, date_add(Now(), interval - 30 day)) as diasrestante
                FROM avaliacao
                WHERE data_avaliacao > DATE_ADD(Now(), INTERVAL - 30 DAY) 
                AND codigo_aluno = :codigo_aluno
                HAVING diasrestante >= 0
                LIMIT 1;
            ";
            $consulta = $pdo->prepare($sql);
            $consulta->bindValue(':codigo_aluno', $avaliacao['codigo_aluno']);
        
            $consulta->execute();
            $data = $consulta->fetch(PDO::FETCH_OBJ);
            
            $data_ultima_avaliacao = $data->ultimaavaliacao ?? null;
            $dias_restante = $data->diasrestante ?? null;
            
            if ($data_ultima_avaliacao) {
                throw new Exception(
                    "Ultima avaliação do aluno foi cadastrado em ".$data_ultima_avaliacao. 
                    ", próxima avaliação ficará disponível em ".$dias_restante." dias!", 
                    403
                );
            }
        } catch (PDOException $erro) {
            throw new Exception("Erro ao consultar avaliações do aluno!", 500);
        }

        try { 
            $date = new DateTime($avaliacao['data_nascimento']);
            $intervalo = $date->diff(new DateTime( date('Y-m-d')));
            $idade = intval($intervalo->format('%Y'));
        } catch (Exception $e) {
            throw new Exception("Erro ao calcular a idade do aluno!", 500);
        }

        try { 
            $peso = floatval($avaliacao['peso']);
            $altura = floatval($avaliacao['altura']);
            $imc = $peso / ($altura * $altura);
            $imc = number_format($imc, 2, '.', ',');

            if ($idade > 65 && $idade < 100) {
                #Idosos
                if ($imc <= 22.00) {
                    $classificacao = "Abaixo do peso";
                } else if ($imc > 22.00 && $imc < 27.00) {
                    $classificacao = "Peso Ideal";
                } else if ($imc >= 27.00) {
                    $classificacao = "Sobrepeso";
                } else {
                    $classificacao = "Indefinida";
                }
            } else if ($idade > 0 && $idade <= 65) {
                #Adultos
                if ($imc < 18.50) {
                    $classificacao = "Abaixo do peso";
                } else if ($imc >= 18.50 && $imc <= 24.99) {
                    $classificacao = "Peso Ideal";
                } else if ($imc >= 25.00 && $imc <= 29.99) {
                    $classificacao = "Sobrepeso";
                } else if ($imc >= 30.00 && $imc <= 34.99) {
                    $classificacao = "Obesidade I";
                } else if ($imc >= 35.00 && $imc <= 39.99) {
                    $classificacao = "Obesidade II";
                } else if ($imc >= 40.00) {
                    $classificacao = "Obesidade III";
                } else {
                    $classificacao = "Indefinida";
                }
            } else {
                throw new Exception("Idade Inválida!", 500);
            }
        } catch (Exception $e) {
            throw new Exception("Erro ao calcular imc do aluno!", 500);
        }
        
        try {
            // Petroski (1995)
            if ($avaliacao['sexo'] == 'F') {
                // D = 1,19547130 – 0,07513507 * Log10 (axilar média + suprailíaca + coxa +
                // panturrilha medial) – 0,00041072 (idade em anos)
                $densidade_corporal = (1.19547130) - (0.07513507*log10(
                    floatval($avaliacao['axilar_media']) + 
                    floatval($avaliacao['suprailiaca']) + 
                    floatval($avaliacao['coxa']) + 
                    floatval($avaliacao['panturrilha_medial'])
                )) - (0.00041072*($idade));
            } 
            
            if ($avaliacao['sexo'] == 'M') {
                // D = 1,10726863 – 0,00081201 (subescapular + tríceps + suprailíaca + panturrilha
                // medial) + 0,00000212 (subescapular + tríceps + suprailíaca + panturrilha medial) – 0,00041761
                // (idade em anos)
                $densidade_corporal = (1.10726863) - (0.00081201*(
                    floatval($avaliacao['subescapular']) + 
                    floatval($avaliacao['triceps']) + 
                    floatval($avaliacao['suprailiaca']) + 
                    floatval($avaliacao['panturrilha_medial'])
                )) + (0.00000212*(
                    floatval($avaliacao['subescapular']) + 
                    floatval($avaliacao['triceps']) + 
                    floatval($avaliacao['suprailiaca']) + 
                    floatval($avaliacao['panturrilha_medial'])
                )) - (0.00041761*($idade));
            }

            // Siri (1961)
            // %G = [(4,95 / DENS) – 4,50] x 100 
            $gordura = ((4.95 / $densidade_corporal) - 4.50) * 100;
            $gordura_absoluta = ($peso * $gordura) / 100; 
            $massa_magra = $peso - $gordura_absoluta;

            $densidade_corporal = number_format($densidade_corporal, 2, '.', ',');
            $gordura = number_format($gordura, 2, '.', ',');
            $gordura_absoluta = number_format($gordura_absoluta, 2, '.', ',');
            $massa_magra = number_format($massa_magra, 2, '.', ',');

        } catch (Exception $e) {
            throw new Exception("Erro ao calcular densidade corporal do aluno!", 500);
        }

        try {
            $pdo->beginTransaction();

            // AVALIACAO / ANTROPOMETRIA
            try {
                $sql = "
                    INSERT INTO antropometria
                    (   
                        codigo_antropometria, 
                        axilar_media, 
                        suprailiaca, 
                        coxa, 
                        panturrilha_medial, 
                        subescapular,
                        triceps,
                        abdominal,
                        densidade_corporal
                    )
                    VALUES 
                    (
                        NULL, 
                        :axilar_media, 
                        :suprailiaca, 
                        :coxa, 
                        :panturrilha_medial, 
                        :subescapular,
                        :triceps,
                        :abdominal,
                        :densidade_corporal
                    );
                ";

                $consulta = $pdo->prepare($sql);
                $consulta->bindValue(":axilar_media", $avaliacao['axilar_media']);
                $consulta->bindValue(":suprailiaca", $avaliacao['suprailiaca']);
                $consulta->bindValue(":coxa", $avaliacao['coxa']);
                $consulta->bindValue(":panturrilha_medial", $avaliacao['panturrilha_medial']);
                $consulta->bindValue(":subescapular", $avaliacao['subescapular']);
                $consulta->bindValue(":triceps", $avaliacao['triceps']);
                $consulta->bindValue(":abdominal", $avaliacao['abdominal']);
                $consulta->bindValue(":densidade_corporal", $densidade_corporal);
                $consulta->execute();

                $sql = "select LAST_INSERT_ID() as id";
                $consulta = $pdo->prepare($sql);
                $consulta->execute();
                $data = $consulta->fetch(PDO::FETCH_OBJ);
                $codigo_antropometria = intval($data->id);
              
                $sql = "
                    INSERT INTO avaliacao 
                    (
                        codigo_avaliacao,
                        codigo_aluno,
                        codigo_antropometria, 
                        data_avaliacao, 
                        idade, 
                        peso, 
                        altura, 
                        imc,
                        classificacao_imc,
                        gordura,
                        massa_magra
                    )
                    VALUES 
                    (
                        NULL, 
                        :codigo_aluno,
                        :codigo_antropometria,
                        :data_avaliacao, 
                        :idade, 
                        :peso, 
                        :altura, 
                        :imc,
                        :classificacao_imc,
                        :gordura,
                        :massa_magra
                    );
                ";
                $consulta = $pdo->prepare($sql);
                $consulta->bindValue(":codigo_aluno", $avaliacao['codigo_aluno']);
                $consulta->bindValue(":codigo_antropometria", $codigo_antropometria);
                $consulta->bindValue(":data_avaliacao", date("Y-m-d"));
                $consulta->bindValue(":idade", $idade);
                $consulta->bindValue(":peso", $peso);
                $consulta->bindValue(":altura", $altura);
                $consulta->bindValue(":imc", $imc);
                $consulta->bindValue(":classificacao_imc", $classificacao);
                $consulta->bindValue(":gordura", $gordura);
                $consulta->bindValue(":massa_magra", $massa_magra);
                $consulta->execute();
            } catch (PDOException $erro) {
                throw new Exception("Erro ao registrar avaliação do aluno!", 500);
            }   
    
            $pdo->commit();
            $codigo_aluno = base64_encode($avaliacao['codigo_aluno']);
            sucessLink(null, "Registro salvo!", "cadastros/avaliacao/".$codigo_aluno);
        } catch (PDOException $erro) {
            $pdo->rollBack();
            // echo $consulta->errorInfo()[2];
            // exit;
            throw new Exception("Erro ao salvar avaliação do aluno!", 500);
        }
 
    } catch (Exception $e) {
        $mensagem = $e->getMessage() . " - " . strval($e->getCode());
        errorBack(null, $mensagem);
    }