<?php
include("../db/conexao.php");
$id = $_GET['id'];

$sql = "SELECT * FROM ficha_brassagem WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$ficha = $result->fetch_assoc();

if (!$ficha) {
    echo "Ficha não encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Brassagem - <?= htmlspecialchars($ficha['nome_receita']) ?></title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 40px; }
        .section-title { background-color: #eee; padding: 10px; margin-top: 30px; }
        .logo-img { height: 50px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <img src="../img/logo.png" class="logo-img" alt="Pecos Brew">
    </div>
    <div>
        <button class="btn btn-secondary no-print" onclick="window.print()">Imprimir / Salvar PDF</button>
        <a href="index.php" class="btn btn-dark no-print">Voltar</a>
    </div>
</div>

<h1>Ficha de Brassagem</h1>
<h3><?= htmlspecialchars($ficha['nome_receita']) ?> - Lote <?= htmlspecialchars($ficha['numero_lote']) ?></h3>
<p><strong>Estilo:</strong> <?= htmlspecialchars($ficha['estilo']) ?> | <strong>Data:</strong> <?= htmlspecialchars($ficha['data_brassagem']) ?></p>
<hr>

<!-- Dados Técnicos -->
<div class="section-title">Informações Técnicas</div>
<table class="table table-bordered">
    <tr><th>OG</th><td><?= $ficha['og'] ?></td>
        <th>FG</th><td><?= $ficha['fg'] ?></td></tr>
    <tr><th>IBU</th><td><?= $ficha['ibu'] ?></td>
        <th>EBC</th><td><?= $ficha['ebc'] ?></td></tr>
    <tr><th>Eficiência (%)</th><td><?= $ficha['eficiencia'] ?></td>
        <th>Volume Inicial (L)</th><td><?= $ficha['volume_inicial'] ?></td></tr>
    <tr><th>Volume Final (L)</th><td><?= $ficha['volume_final'] ?></td>
        <th>Tempo de Fervura (min)</th><td><?= $ficha['tempo_fervura'] ?></td></tr>
</table>

<!-- Fermentação -->
<div class="section-title">Fermentação & Maturação</div>
<table class="table table-bordered">
    <tr><th>Temperatura Fermentação (°C)</th><td><?= $ficha['temperatura_fermentacao'] ?></td>
        <th>Tempo Fermentação (dias)</th><td><?= $ficha['tempo_fermentacao'] ?></td></tr>
    <tr><th>Temperatura Maturação (°C)</th><td><?= $ficha['temperatura_maturacao'] ?></td>
        <th>Tempo Maturação (dias)</th><td><?= $ficha['tempo_maturacao'] ?></td></tr>
</table>

<!-- Envase -->
<div class="section-title">Envase</div>
<table class="table table-bordered">
    <tr>
        <th>Tipo</th><td><?= $ficha['tipo_envase'] ?></td>
        <th>Volume (L)</th><td><?= $ficha['volume_envase'] ?></td>
        <th>Carbonatação</th><td><?= $ficha['carbonatacao'] ?></td>
    </tr>
</table>

<!-- Observações -->
<div class="section-title">Observações</div>
<p><?= nl2br(htmlspecialchars($ficha['observacoes'])) ?></p>

</body>
</html>
