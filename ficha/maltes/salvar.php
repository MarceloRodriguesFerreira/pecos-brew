<?php
include('../../db/conexao.php');

echo "Marcelo";

$id = $_POST['id'];
$ficha_id = $_POST['ficha_id'];
$quantidade = str_replace(',', '.', $_POST['quantidade']);
$nome = $_POST['nome'];
$unidade = $_POST['unidade'];

if ($id) {
    // Atualiza
    $sql = "UPDATE ingredientes_malte SET nome=?, quantidade=?, unidade=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('disi', $temperatura, $tempo, $descricao, $id);
} else {
    // Insere
    $sql = "INSERT INTO ingredientes_malte (ficha_id, nome, quantidade, unidade) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('idis', $ficha_id, $temperatura, $tempo, $descricao);
}

if ($stmt->execute()) {
    header("Location: maltes.php?ficha_id=$ficha_id");
    exit;
} else {
    echo "Erro: " . $stmt->error;
}
?>
