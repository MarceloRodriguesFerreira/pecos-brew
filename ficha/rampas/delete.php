<?php
    include("../../db/conexao.php");
    $id = $_GET['id'];
    $ficha_id = $_GET['ficha_id'];

    $sql = "DELETE FROM rampas_mostura WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../view.php?id=" . $ficha_id);
    } else {
        echo "Erro ao deletar: " . $conn->error;
    }
?>