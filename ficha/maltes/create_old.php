<?php
include("../../db/conexao.php");
$ficha_id = $_GET['ficha_id'];

if ($_POST) {
    $sql = "INSERT INTO ingredientes_malte (ficha_id, nome, quantidade, unidade) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isds", $ficha_id, $_POST['nome'], $_POST['quantidade'], $_POST['unidade']);

    if ($stmt->execute()) {
        header("Location: ../maltes/view.php?id=$ficha_id");
        exit;
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Malte</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("../navbar.php"); ?>

<div class="container py-5">
    <h2>Adicionar Malte</h2>
    <form method="post">
        <div class="mb-3">
            <label>Nome do Malte</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label>Quantidade</label>
                <input type="number" step="0.01" name="quantidade" class="form-control" required>
            </div>
            <div class="col">
                <label>Unidade</label>
                <select name="unidade" class="form-select" required>
                    <option value="KG">KG</option>
                    <option value="G">G</option>
                    <option value="MG">MG</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Salvarrrr</button>
        <a href="../maltes/view.php?id=<?= $ficha_id ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>
