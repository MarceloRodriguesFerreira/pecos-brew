<?php
include("../../db/conexao.php");
include_once("../../uteis/functions.php");

$ficha_id = isset($_GET['ficha_id']) ? intval($_GET['ficha_id']) : 0;

$nome = '';
$idx_alfa_acido = '';
$quantidade = '';
$tempo_adicao = 0;
$edit_id = 0;
$uso = '';

// Buscar OG e volume final da ficha de brassagem
$og = 1.050;
$volume = 20;
$stmt_ficha = $conn->prepare("SELECT og, volume_final FROM ficha_brassagem WHERE id = ?");
$stmt_ficha->bind_param("s", $ficha_id);
$stmt_ficha->execute();
$res_ficha = $stmt_ficha->get_result();
if ($res_ficha && $res_ficha->num_rows > 0) {
    $dados_ficha = $res_ficha->fetch_assoc();
    if (strpos($dados_ficha['og'], '-') !== false) {
        $faixa = explode('-', $dados_ficha['og']);
        if (count($faixa) === 2) {
            $og = floatval("1." . $faixa[1]);
        }
    } else {
        $og = floatval("1." . $dados_ficha['og']);
    }
    $volume = floatval($dados_ficha['volume_final']);
}

// Buscar lúpulo para edição
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt_edit = $conn->prepare("SELECT * FROM ingredientes_lupulo WHERE id = ?");
    if ($stmt_edit && $stmt_edit->bind_param("i", $edit_id) && $stmt_edit->execute()) {
        $result = $stmt_edit->get_result();
        if ($result && $result->num_rows > 0) {
            $dados = $result->fetch_assoc();
            $nome = $dados['nome'];
            $idx_alfa_acido = $dados['idx_alfa_acido'];
            $quantidade = $dados['quantidade'];
            $tempo_adicao = $dados['tempo_adicao'];
            $uso = $dados['uso'];
        }
    }
}

// Salvar ou Atualizar
if (isset($_POST['salvar'])) {
    $edit_id = intval($_POST['edit_id']);
    $nome = $_POST['nome'];
    $idx_alfa_acido = $_POST['idx_alfa_acido'];
    $quantidade = $_POST['quantidade'];
    $tempo_adicao = $_POST['tempo_adicao'];
    $uso = $_POST['uso'];

    if ($edit_id > 0) {
        $stmt = $conn->prepare("UPDATE ingredientes_lupulo SET nome=?, idx_alfa_acido=?, quantidade=?, tempo_adicao=?, uso=? WHERE id=?");
        $stmt->bind_param("sdddsi", $nome, $idx_alfa_acido, $quantidade, $tempo_adicao, $uso, $edit_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO ingredientes_lupulo (ficha_id, nome, idx_alfa_acido, quantidade, tempo_adicao, uso) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isddis", $ficha_id, $nome, $idx_alfa_acido, $quantidade, $tempo_adicao, $uso);
    }

    if ($stmt->execute()) {
        header("Location: lupulos.php?ficha_id=" . $ficha_id);
        exit;
    } else {
        echo "Erro ao salvar: " . $conn->error;
    }
}

// Excluir
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM ingredientes_lupulo WHERE id = ?");
    if ($stmt && $stmt->bind_param("i", $delete_id) && $stmt->execute()) {
        header("Location: lupulos.php?ficha_id=" . $ficha_id);
        exit;
    } else {
        echo "Erro ao excluir: " . $conn->error;
    }
}

// Buscar todos os lúpulos da ficha para exibir e calcular IBUs
$stmt = $conn->prepare("SELECT * FROM ingredientes_lupulo WHERE ficha_id = ?");
$stmt->bind_param("i", $ficha_id);
$stmt->execute();
$result_lupulos = $stmt->get_result();

$ibu_total = 0;
$lupulos_array = [];
if ($result_lupulos) {
    while ($lup = $result_lupulos->fetch_assoc()) {
        $lupulos_array[] = $lup;
        if (strtolower($lup['uso']) === 'fervura') {
            $ibu_total += calcularIBU($lup['idx_alfa_acido'], $lup['quantidade'], $lup['tempo_adicao'], $volume, $og);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lúpulos utilizados</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("../navbar.php"); ?>

<div class="container py-5">
    <h2>Adicionar Lúpulo</h2>
    <form method="post">
        <input type="hidden" name="edit_id" value="<?= $edit_id ?>">

        <div class="mb-3">
            <label>Nome do Lúpulo</label>
            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($nome) ?>" required>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label>Índice de Alfa Ácido (%)</label>
                <input type="number" step="0.01" name="idx_alfa_acido" class="form-control" value="<?= htmlspecialchars($idx_alfa_acido) ?>" required>
            </div>
            <div class="col-md-3">
                <label>Quantidade (g)</label>
                <input type="number" step="0.01" name="quantidade" class="form-control" value="<?= htmlspecialchars($quantidade) ?>" required>
            </div>
            <div class="col-md-3">
                <label>Tempo de Adição (min)</label>
                <input type="number" name="tempo_adicao" class="form-control" value="<?= htmlspecialchars($tempo_adicao) ?>" required>
            </div>
            <div class="col-md-3">
                <label>Uso</label>
                <select name="uso" class="form-select" required>
                    <option value="Fervura" <?= $uso === 'Fervura' ? 'selected' : '' ?>>Fervura</option>
                    <option value="Dry Hop" <?= $uso === 'Dry Hop' ? 'selected' : '' ?>>Dry Hop</option>
                    <option value="Aroma (Hopstand)" <?= $uso === 'Aroma (Hopstand)' ? 'selected' : '' ?>>Aroma (Hopstand)</option>
                    <option value="Mostura" <?= $uso === 'Mostura' ? 'selected' : '' ?>>Mostura</option>
                    <option value="Primeiro Mosto" <?= $uso === 'Primeiro Mosto' ? 'selected' : '' ?>>Primeiro Mosto</option>
                </select>
            </div>
        </div>

        <button type="submit" name="salvar" class="btn btn-success">Salvar</button>
        <a href="../ingredientes.php?ficha_id=<?= $ficha_id ?>" class="btn btn-secondary">Voltar</a>
    </form>

    <hr>

    <h3>Lúpulos Cadastrados</h3>
    <div class="alert alert-info">
        <strong>IBUs estimados:</strong> <?= $ibu_total ?> <br>
        <small>(OG: <?= $og ?> | Volume: <?= $volume ?> L)</small>
    </div>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Alfa Ácido (%)</th>
                <th>Quantidade (g)</th>
                <th>Tempo de Adição</th>
                <th>Uso</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($lupulos_array as $r): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['nome']) ?></td>
                <td><?= $r['idx_alfa_acido'] ?></td>
                <td><?= $r['quantidade'] ?></td>
                <td><?= htmlspecialchars($r['tempo_adicao']) ?></td>
                <td><?= htmlspecialchars($r['uso']) ?></td>
                <td>
                    <a href="?ficha_id=<?= $ficha_id ?>&edit=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="?ficha_id=<?= $ficha_id ?>&delete=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
