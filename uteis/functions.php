<?php
    /**
     * Retorna uma mensagem de erro amigável com detalhes técnicos se o modo desenvolvedor estiver ativado.
     *
     * @param string $mensagem Mensagem padrão amigável para o usuário.
     * @param object $stmtOuConn Objeto mysqli ou mysqli_stmt.
     * @param bool $modo_dev Define se os detalhes técnicos devem ser exibidos.
     * @return string Mensagem final de erro.
     */
    function tratarErro($mensagem, $stmtOuConn, $modo_dev = false) {
        if ($modo_dev && $stmtOuConn) {
            $erroTecnico = method_exists($stmtOuConn, 'error') ? $stmtOuConn->error : 'Erro desconhecido';
            return $mensagem . " Erro técnico: " . $erroTecnico;
        }
        return $mensagem;
    }

    function formatar_data_br($data_iso) {
        if (!$data_iso || $data_iso === '0000-00-00') {
            return '';
        }

        $dt = DateTime::createFromFormat('Y-m-d', $data_iso);
        return $dt ? $dt->format('d/m/Y') : '';
    }

    function adicionarErro($mensagem) {
        global $erros_amigaveis;
        $erros_amigaveis[] = $mensagem;
    }    


    //função para calcular IBU com Tinseth
    function calcularIBU($alfa_acido, $quantidade_g, $tempo_min, $volume_litros, $og) {
        // Converte percentual para decimal
        $aa_decimal = $alfa_acido / 100;

        // Cálculo do fator de utilização (Tinseth)
        $utilizacao = 1.65 * pow(0.000125, ($og - 1)) * (1 - exp(-0.04 * $tempo_min)) / 4.15;

        // Cálculo do IBU
        $ibu = ($aa_decimal * $quantidade_g * 1000 * $utilizacao) / $volume_litros;

        return round($ibu, 1);
    }   


    function calcularIBUReceita($ficha) {
        // Buscar lúpulos da ficha
        $stmt = $conn->prepare("SELECT * FROM ingredientes_lupulo WHERE ficha_id = " . $ficha);
        $stmt->bind_param("i", $ficha_id);
        $stmt->execute();
        $lupulos = $stmt->get_result();   

        // Somar IBUs de lúpulos de fervura
        $ibu_total = 0;
        while ($lup = $lupulos->fetch_assoc()) {
            if (strtolower($lup['uso']) === 'fervura') {
                $ibu = calcularIBU($lup['idx_alfa_acido'], $lup['quantidade'], $lup['tempo_adicao'], $volume, $og);
                $ibu_total += $ibu;
            }
        } 

        return($ibu_total);
    }   
?>

