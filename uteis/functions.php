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
?>

