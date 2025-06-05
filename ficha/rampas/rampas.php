<?php
include("../../db/conexao.php");

$ficha_id = isset($_GET['ficha_id']) ? intval($_GET['ficha_id']) : 0;

$temperatura = '';
$tempo = '';
$descricao = '';
$edit_id = 0;

// Buscar rampa para edição
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM rampas_mostura WHERE id = ?"); 

    if (!$stmt) {
        //die("Erro na preparação: " . $conn->error);
        $erro = "Não foi possível salvar. Verifique os campos. ";
        $erro .= $modo_dev ? "Erro técnico: " . $stmt->error : "";        
    }

    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $dados = $result->fetch_assoc();
        $temperatura = $dados['temperatura'];
        $tempo = $dados['tempo'];
        $descricao = $dados['descricao'];
    } else {
        echo "Erro ao buscar rampa: " . $conn->error;
    }
}

// Salvar ou Atualizar
if (isset($_POST['salvar'])) {
    $edit_id = intval($_POST['edit_id']);
    $temperatura = $_POST['temperatura'];
    $tempo = $_POST['tempo'];
    $descricao = $_POST['descricao'];

    if ($edit_id > 0) {
        // Atualizar
        $stmt = $conn->prepare("UPDATE rampas_mostura SET temperatura=?, tempo=?, descricao=? WHERE id=?");

        if (!$stmt) {
            die("Erro na preparação: " . $conn->error);
        }

        $stmt->bind_param("disi", $temperatura, $tempo, $descricao, $edit_id);
    } else {
        // Inserir
        $stmt = $conn->prepare("INSERT INTO rampas_mostura (ficha_id, temperatura, tempo, descricao) VALUES (?, ?, ?, ?)");

        if (!$stmt) {
            die("Erro na preparação: " . $conn->error);
        }

        $stmt->bind_param("idis", $ficha_id, $temperatura, $tempo, $descricao);
    }

    if ($stmt->execute()) {
        header("Location: rampas.php?ficha_id=" . $ficha_id);
        exit;
    } else {
        echo "Erro ao salvar: " . $conn->error;
    }
}

// Excluir
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM rampas_mostura WHERE id = ?");

    if (!$stmt) {
        die("Erro na preparação: " . $conn->error);
    }

    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        header("Location: rampas.php?ficha_id=" . $ficha_id);
        exit;
    } else {
        echo "Erro ao excluir: " . $conn->error;
    }
}

// Buscar todas as rampas da ficha
$stmt = $conn->prepare("SELECT * FROM rampas_mostura WHERE ficha_id = ?");

if (!$stmt) {
    die("Erro na preparação: " . $conn->error);
}

$stmt->bind_param("i", $ficha_id);
$stmt->execute();
$rampas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Rampas de Temperatura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("../navbar.php"); ?>

<?php if (isset($erro)): ?>
    <div class="alert alert-danger">
        <?= $erro ?>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <h2>Adicionar Rampa</h2>
    <form method="POST">
        <input type="hidden" name="edit_id" value="<?= $edit_id ?>">
        <div class="row mb-3">
            <div class="col">
                <label>Temperatura (°C)</label>
                <input type="number" step="0.01" name="temperatura" class="form-control" required value="<?= htmlspecialchars($temperatura) ?>">
            </div>
            <div class="col">
                <label>Tempo (min)</label>
                <input type="number" name="tempo" class="form-control" required value="<?= htmlspecialchars($tempo) ?>">
            </div>
        </div>
        <div class="mb-3">
            <label>Descrição da Função</label>
            <input type="text" name="descricao" class="form-control" value="<?= htmlspecialchars($descricao) ?>">
        </div>
        <button type="submit" name="salvar" class="btn btn-success">Salvar</button>
        <a href="../index.php" class="btn btn-secondary">Voltar</a>
    </form>

    <hr>

    <h3>Rampas Cadastradas</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Temperatura (°C)</th>
                <th>Tempo (min)</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($r = $rampas->fetch_assoc()): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= $r['temperatura'] ?></td>
                <td><?= $r['tempo'] ?></td>
                <td><?= htmlspecialchars($r['descricao']) ?></td>
                <td>
                    <a href="?ficha_id=<?= $ficha_id ?>&edit=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="?ficha_id=<?= $ficha_id ?>&delete=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
