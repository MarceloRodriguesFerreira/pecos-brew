<?php 
include("../../db/conexao.php");
$ficha_id = $_GET['ficha_id'];

if ($_POST) {
    $sql = "INSERT INTO rampas_mostura 
        (ficha_id, temperatura, tempo, descricao, hora_inicial, hora_final, temperatura_min, temperatura_max)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "iidsssdd", 
        $ficha_id, $_POST['temperatura'], $_POST['tempo'], $_POST['descricao'],
        $_POST['hora_inicial'], $_POST['hora_final'], $_POST['temperatura_min'], $_POST['temperatura_max']
    );

    if ($stmt->execute()) {
        header("Location: ../view.php?id=" . $ficha_id);
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
    <title>Adicionar Rampa - Pecos Brew</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("../navbar.php"); ?>

<div class="container py-5">
    <h1>Adicionar Rampa de Mostura</h1>

    <form method="post">
        <div class="row mb-3">
            <div class="col">
                <label>Temperatura (°C)</label>
                <input type="number" step="0.01" name="temperatura" class="form-control" required>
            </div>
            <div class="col">
                <label>Tempo (min)</label>
                <input type="number" name="tempo" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Descrição da Função</label>
            <input type="text" name="descricao" class="form-control">
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Hora Inicial</label>
                <input type="time" name="hora_inicial" class="form-control">
            </div>
            <div class="col">
                <label>Hora Final</label>
                <input type="time" name="hora_final" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Temperatura Mín. (°C)</label>
                <input type="number" step="0.01" name="temperatura_min" class="form-control">
            </div>
            <div class="col">
                <label>Temperatura Máx. (°C)</label>
                <input type="number" step="0.01" name="temperatura_max" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="../view.php?id=<?= $ficha_id ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>
