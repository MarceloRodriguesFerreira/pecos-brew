<?php

    // função para tratar erros
    function tratarErro($mensagem, $stmtOuConn, $modo_dev = false) {
        if ($modo_dev && $stmtOuConn) {
            $erroTecnico = method_exists($stmtOuConn, 'error') ? $stmtOuConn->error : 'Erro desconhecido';
            return $mensagem . " Erro técnico: " . $erroTecnico;
        }
        return $mensagem;
    }

?>