<?php include("../db/conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM ficha_brassagem WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$ficha = $result->fetch_assoc();

if ($_POST) {
    $stmt = $conn->prepare(
        "UPDATE ficha_brassagem SET nome_receita=?, estilo=?, numero_lote=?, data_brassagem=?, cervejeiro_responsavel=?, og=?, fg=?, ibu=?, ebc=?, eficiencia=?, volume_inicial=?, volume_final=?, tempo_fervura=?, temperatura_fermentacao=?, tempo_fermentacao=?, temperatura_maturacao=?, tempo_maturacao=?, tipo_envase=?, volume_envase=?, carbonatacao=?, observacoes=? WHERE id=?"
    );
    $stmt->bind_param(
        "ssssssssdddddddiddssi",
        $_POST['nome_receita'], $_POST['estilo'], $_POST['numero_lote'], $_POST['data_brassagem'], $_POST['cervejeiro_responsavel'],
        $_POST['og'], $_POST['fg'], $_POST['ibu'], $_POST['ebc'], $_POST['eficiencia'], $_POST['volume_inicial'], $_POST['volume_final'],
        $_POST['tempo_fervura'], $_POST['temperatura_fermentacao'], $_POST['tempo_fermentacao'], $_POST['temperatura_maturacao'],
        $_POST['tempo_maturacao'], $_POST['tipo_envase'], $_POST['volume_envase'], $_POST['carbonatacao'], $_POST['observacoes'], $id
    );

    if ($stmt->execute()) {
        header("Location: index.php");
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
    <title>Editar Ficha - Pecos Brew</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>.logo-img { height: 50px; }</style>
</head>
<body>

<?php include("navbar.php"); ?>

<div class="container py-5">
    <h1>Editar Ficha</h1>

    <form method="post">
        <?php include("form_fields.php"); ?>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
