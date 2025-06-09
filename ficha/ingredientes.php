<?php
include("../db/conexao.php");

// Pega o ID da ficha via GET
$ficha_id = isset($_GET['ficha_id']) ? intval($_GET['ficha_id']) : 0;

// Consulta os dados da ficha
$sql = "SELECT nome_receita FROM ficha_brassagem WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ficha_id);
$stmt->execute();
$result = $stmt->get_result();
$nome_receita = '';
if ($result && $result->num_rows > 0) {
    $nome_receita = $result->fetch_assoc()['nome_receita'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ingredientes da Ficha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--link href="../../css/bootstrap.min.css" rel="stylesheet"-->

    <style>
        .icon-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
            padding: 20px;
            transition: 0.2s;
            height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #333;
            text-decoration: none;
        }

        .icon-card:hover {
            background: #f5f5f5;
            border-color: #999;
            text-decoration: none;
        }

        .icon-card i {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
    </style>

    <!-- Ícones do Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<?php include("navbar.php"); ?>

<div class="container py-5">
    <h2>Ficha #<?= $ficha_id ?> – <?= htmlspecialchars($nome_receita) ?></h2>
    <p class="text-muted">Selecione o tipo de ingrediente para gerenciar:</p>

    <div class="row text-center g-4 mt-4">
        <div class="col-md-4">
            <a href="maltes/maltes.php?ficha_id=<?= $ficha_id ?>" class="icon-card">
                <i class="bi bi-cup-straw"></i>
                <div>Maltes</div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="rampas/rampas.php?ficha_id=<?= $ficha_id ?>" class="icon-card">
                <i class="bi bi-thermometer-half"></i>
                <div>Rampas de Mostura</div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="lupulos/lupulos.php?ficha_id=<?= $ficha_id ?>" class="icon-card">
                <i class="bi bi-flower2"></i>
                <div>Lúpulos</div>
            </a>
        </div>
    </div>

    <div class="mt-5">
        <a href="index.php" class="btn btn-secondary">← Voltar para Fichas</a>
    </div>
</div>

</body>
</html>
