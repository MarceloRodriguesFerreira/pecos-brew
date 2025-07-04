<?php
include("../../db/conexao.php");
include_once("../../uteis/functions.php");

$ficha_id = isset($_GET['ficha_id']) ? intval($_GET['ficha_id']) : 0;

$nome = '';
$quantidade = '';
$unidade = '';
$tipo = '';
$edit_id = 0;

// Buscar malte para edição
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM ingredientes_malte WHERE id = ?"); 
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
        $nome = $dados['nome'];
        $quantidade = $dados['quantidade'];
        $unidade = $dados['unidade'];
        $tipo = $dados['tipo'];
    } else {
        echo "Erro ao buscar rampa: " . $conn->error;
    }
}

// Salvar ou Atualizar
/*if (isset($_POST['salvar'])) {
    $edit_id = intval($_POST['edit_id']);
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $unidade = $_POST['unidade'];
    $tipo = $_POST['tipo'];

    if ($edit_id > 0) {
        // Atualizar
        $stmt = $conn->prepare("UPDATE ingredientes_malte SET nome=?, quantidade=?, unidade=?, tipo=? WHERE id=?");

        if (!$stmt) {
            die("Erro na preparação: " . $conn->error);
        }

        //$stmt->bind_param("isds", $nome, $quantidade, $unidade, $edit_id);
        $stmt->bind_param("sdssi", $nome, $quantidade, $unidade, $edit_id);
    } else {
        // Inserir
        $stmt = $conn->prepare("INSERT INTO ingredientes_malte (ficha_id, nome, quantidade, unidade, tipo) VALUES (?, ?, ?, ?, ?)");

        if (!$stmt) {
            die("Erro na preparação: " . $conn->error);
        }

        $stmt->bind_param("isdss", $ficha_id, $nome, $quantidade, $unidade, $tipo);
    }

    if ($stmt->execute()) {
        header("Location: maltes.php?ficha_id=" . $ficha_id);
        exit;
    } else {
        echo "Erro ao salvar: " . $conn->error;
    }
}*/
if (isset($_POST['salvar'])) {
    $edit_id = intval($_POST['edit_id']);
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $unidade = $_POST['unidade'];
    $tipo = $_POST['tipo'];

    if ($edit_id > 0) {
        $stmt = $conn->prepare("UPDATE ingredientes_malte SET nome=?, quantidade=?, unidade=?, tipo=? WHERE id=?");
        if (!$stmt) {
            adicionarErro("Erro ao preparar atualização." . $conn->error);
        } else {
            $stmt->bind_param("sdssi", $nome, $quantidade, $unidade, $tipo, $edit_id);
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO ingredientes_malte (ficha_id, nome, quantidade, unidade, tipo) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            adicionarErro("Erro ao preparar inserção." . $conn->error);
        } else {
            $stmt->bind_param("isdss", $ficha_id, $nome, $quantidade, $unidade, $tipo);
        }
    }

    if (isset($stmt) && !$stmt->execute()) {
        adicionarErro("Erro ao salvar " . $conn->error);
    }

    // Redirecionamento só se tudo estiver certo
    if (empty($erros_amigaveis)) {
        header("Location: maltes.php?ficha_id=" . $ficha_id);
        exit;
    }
}

// Excluir
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM ingredientes_malte WHERE id = ?");

    if (!$stmt) {
        //die("Erro na preparação: " . $conn->error);
        adicionarErro("Erro ao preparar atualização." . $conn->error);
    }

    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        header("Location: maltes.php?ficha_id=" . $ficha_id);
        exit;
    } else {
        //echo "Erro ao excluir: " . $conn->error;
        adicionarErro("Erro ao excluir:" . $conn->error);
    }
}

// Buscar todas os maltes da ficha
$stmt = $conn->prepare("SELECT * FROM ingredientes_malte WHERE ficha_id = ?");

if (!$stmt) {
    die("Erro na preparação: " . $conn->error);
}

$stmt->bind_param("i", $ficha_id);
$stmt->execute();
$maltes = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Maltes utilizados</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("../navbar.php"); ?>

<?php if (!empty($erros_amigaveis)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($erros_amigaveis as $erro): ?>
                <li><?= htmlspecialchars($erro) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="container py-5">
    <h2>Adicionar Malte</h2>
    <form method="post">
            <input type="hidden" name="edit_id" value="<?= $edit_id ?>">
        <div class="mb-3">
            <label>Nome do Malte</label>
            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($nome) ?>" required>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label>Quantidade</label>
                <input type="number" step="0.01" name="quantidade" class="form-control" value="<?= htmlspecialchars($quantidade) ?>" required>
            </div>
            <div class="col">
                <label>Unidade</label>
                <select name="unidade" class="form-select" required>
                    <option value="KG" <?= $unidade === 'KG' ? 'selected' : '' ?>>KG</option>
                    <option value="G" <?= $unidade === 'G' ? 'selected' : '' ?>>G</option>
                    <option value="MG" <?= $unidade === 'MG' ? 'selected' : '' ?>>MG</option>
                </select>
            </div>
            <div class="col">
                <label>Tipo</label>
                <select name="tipo" class="form-select" required>
                    <option value="Grão" <?= $tipo === 'Grão' ? 'selected' : '' ?>>Grão</option>
                    <option value="Açúcar" <?= $tipo === 'Açúcar' ? 'selected' : '' ?>>Açúcar</option>
                    <option value="Extrato Líquido" <?= $tipo === 'Extrato Líquido' ? 'selected' : '' ?>>Extrato Líquido</option>
                    <option value="Extrato Seco" <?= $tipo === 'Extrato Seco' ? 'selected' : '' ?>>Extrato Seco</option>
                    <option value="Adjunto" <?= $tipo === 'Adjunto' ? 'selected' : '' ?>>Adjunto</option>
                    <option value="Outros" <?= $tipo === 'Outros' ? 'selected' : '' ?>>Outros</option>
                </select>
            </div>
        </div>
        <button type="submit" name="salvar" class="btn btn-success">Salvar</button>
        <!--a href="../ingredientes.php" class="btn btn-secondary">Voltar</a-->
        <a href="../ingredientes.php?ficha_id=<?= $ficha_id ?>" class="btn btn-secondary">Voltar</a>

    </form>
<div>

    <hr>

    <h3>Maltes Cadastrados</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Unidade</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($r = $maltes->fetch_assoc()): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['nome']) ?></td>
                <td><?= $r['quantidade'] ?></td>
                <td><?= $r['unidade'] ?></td>
                <td><?= $r['tipo'] ?></td>
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
