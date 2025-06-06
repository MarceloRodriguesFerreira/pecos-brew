<?php
include("../../db/conexao.php");

$id = $_GET['id'];
$ficha_id = $_GET['ficha_id'];

$sql = "SELECT * FROM ingredientes_malte WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$malte = $stmt->get_result()->fetch_assoc();

if ($_POST) {
    $sql = "UPDATE ingredientes_malte SET nome=?, quantidade=?, unidade=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsi", $_POST['nome'], $_POST['quantidade'], $_POST['unidade'], $id);

    if ($stmt->execute()) {
        header("Location: ../view.php?id=$ficha_id");
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
    <title>Editar Malte</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("../navbar.php"); ?>

<div class="container py-5">
    <h2>Editar Malte</h2>
    <form method="post">
        <div class="mb-3">
            <label>Nome do Malte</label>
            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($malte['nome']) ?>" required>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label>Quantidade</label>
                <input type="number" step="0.01" name="quantidade" class="form-control" value="<?= $malte['quantidade'] ?>" required>
            </div>
            <div class="col">
                <label>Unidade</label>
                <select name="unidade" class="form-select" required>
                    <option value="KG" <?= $malte['unidade'] === 'KG' ? 'selected' : '' ?>>KG</option>
                    <option value="G" <?= $malte['unidade'] === 'G' ? 'selected' : '' ?>>G</option>
                    <option value="MG" <?= $malte['unidade'] === 'MG' ? 'selected' : '' ?>>MG</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="../view.php?id=<?= $ficha_id ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>
