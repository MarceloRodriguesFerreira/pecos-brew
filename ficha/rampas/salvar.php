<?php
include('conexao.php');

$id = $_POST['id'];
$ficha_id = $_POST['ficha_id'];
$temperatura = str_replace(',', '.', $_POST['temperatura']);
$tempo = $_POST['tempo'];
$descricao = $_POST['descricao'];

if ($id) {
    // Atualiza
    $sql = "UPDATE rampas SET temperatura=?, tempo=?, descricao=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('disi', $temperatura, $tempo, $descricao, $id);
} else {
    // Insere
    $sql = "INSERT INTO rampas (ficha_id, temperatura, tempo, descricao) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('idis', $ficha_id, $temperatura, $tempo, $descricao);
}

if ($stmt->execute()) {
    header("Location: rampas.php?ficha_id=$ficha_id");
    exit;
} else {
    echo "Erro: " . $stmt->error;
}
?>
