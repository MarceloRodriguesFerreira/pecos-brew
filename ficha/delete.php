<?php
include("../db/conexao.php");

$id = $_GET['id'];

$sql = "DELETE FROM ficha_brassagem WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php");
} else {
    echo "Erro ao deletar: " . $conn->error;
}
?>
