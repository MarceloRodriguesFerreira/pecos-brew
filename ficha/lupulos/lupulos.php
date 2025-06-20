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

// Buscar lúpulo para edição
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM ingredientes_lupulo WHERE id = ?");

    if (!$stmt) {
        die("Erro ao preparar statement: " . $conn->error);
    } elseif (!$stmt->bind_param("i", $edit_id)) {
        $erro = tratarErro("Erro ao vincular os dados.", $stmt, $modo_dev);
    } elseif (!$stmt->execute()) {
        $erro = tratarErro("Erro ao executar a operação.", $stmt, $modo_dev);
    } /*else {*/


    //$stmt->bind_param("i", $edit_id);
    //$stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $dados = $result->fetch_assoc();
        $nome = $dados['nome'];
        $idx_alfa_acido = $dados['idx_alfa_acido'];
        $quantidade = $dados['quantidade'];
        $tempo_adicao = $dados['tempo_adicao'];
        $uso = $dados['uso'];
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

        if (!$stmt) {
            die("Erro ao preparar statement: " . $conn->error);
            $erro = tratarErro("Erro ao preparar statement:", $conn, $modo_dev);
        }

        $stmt->bind_param("sdddsi", $nome, $idx_alfa_acido, $quantidade, $tempo_adicao, $uso, $edit_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO ingredientes_lupulo (ficha_id, nome, idx_alfa_acido, quantidade, tempo_adicao, uso) VALUES (?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            die("Erro ao preparar statement: " . $conn->error);
            $erro = tratarErro("Erro ao preparar statement:", $conn, $modo_dev);
        }        
        //$stmt->bind_param("isdss", $ficha_id, $nome, $idx_alfa_acido, $quantidade, $tempo_adicao);
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

    if (!$stmt) {
        die("Erro ao preparar statement: " . $conn->error);
    }
  
    if (!$stmt->bind_param("i", $delete_id)) {
        $erro = tratarErro("Erro ao vincular os dados.", $stmt, $modo_dev);
    } 

    if ($stmt->execute()) {
        header("Location: lupulos.php?ficha_id=" . $ficha_id);
        exit;
    } else {
        echo "Erro ao excluir: " . $conn->error;
        $erro = tratarErro("Erro ao preparar a operação no banco.", $conn, $modo_dev);
    }


}

// Buscar todos os lúpulos da ficha
$stmt = $conn->prepare("SELECT * FROM ingredientes_lupulo WHERE ficha_id = ?");

if (!$stmt) {
    die("Erro ao preparar statement: " . $conn->error);
    $erro = tratarErro("Erro ao preparar statement:", $conn, $modo_dev);
}

$stmt->bind_param("i", $ficha_id);
$stmt->execute();
$lupulos = $stmt->get_result();
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

<?php if (isset($erro)): ?>
    <div class="alert alert-danger"><?= $erro ?></div>
<?php endif; ?>

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
        <?php while ($r = $lupulos->fetch_assoc()): ?>
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
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
