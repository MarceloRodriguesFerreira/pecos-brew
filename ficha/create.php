<?php include("../db/conexao.php");

if ($_POST) {
    $stmt = $conn->prepare(
        "INSERT INTO ficha_brassagem (nome_receita, estilo, numero_lote, data_brassagem, cervejeiro_responsavel, og, fg, ibu, srm, eficiencia, 
                                      volume_inicial, volume_final, tempo_fervura, temperatura_fermentacao, tempo_fermentacao, 
                                      temperatura_maturacao, tempo_maturacao, tipo_envase, volume_envase, carbonatacao, observacoes) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "sssssssssdddididisdss",
        $_POST['nome_receita'], $_POST['estilo'], $_POST['numero_lote'], $_POST['data_brassagem'], $_POST['cervejeiro_responsavel'],
        $_POST['og'], $_POST['fg'], $_POST['ibu'], $_POST['srm'], $_POST['eficiencia'], $_POST['volume_inicial'], $_POST['volume_final'],
        $_POST['tempo_fervura'], $_POST['temperatura_fermentacao'], $_POST['tempo_fermentacao'], $_POST['temperatura_maturacao'],
        $_POST['tempo_maturacao'], $_POST['tipo_envase'], $_POST['volume_envase'], $_POST['carbonatacao'], $_POST['observacoes']
    );

/*nome_receita → s
estilo → s
numero_lote → s
data_brassagem → s (formato 'YYYY-MM-DD', ainda é string)
cervejeiro_responsavel → s
og → s
fg → s
ibu → s
srm → s
eficiencia → d
volume_inicial → d
volume_final → d
tempo_fervura → i
temperatura_fermentacao → d
tempo_fermentacao → i
temperatura_maturacao → d
tempo_maturacao → i
tipo_envase → s
volume_envase → d
carbonatacao → s
observacoes → s (campo TEXT é tratado como string) */

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
    <title>Nova Ficha - Pecos Brew</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>.logo-img { height: 50px; }</style>
</head>
<body>

<?php include("navbar.php"); ?>

<div class="container py-5">
    <h1>Nova Ficha de Brassagem</h1>

    <form method="post">
        <?php include("form_fields.php"); ?>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
