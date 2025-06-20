<?php
include("../db/conexao.php");
include_once("../uteis/functions.php");

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
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <title>Ficha de Brassagem - <?= htmlspecialchars($ficha['nome_receita']) ?></title>
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
                <img src="../img/logob.png" class="logo-img" alt="Pecos Brew">
            </div>
            <div>
                <button class="btn btn-secondary no-print" onclick="window.print()">Imprimir / Salvar PDF</button>
                <a href="index.php" class="btn btn-dark no-print">Voltar</a>
            </div>
        </div>

        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?= $erro ?></div>
        <?php endif; ?>

        <h2>Ficha de Brassagem</h2>
        <h3>
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h3 class="mb-0">
                    <?= htmlspecialchars($ficha['nome_receita']) ?> - Lote <?= htmlspecialchars($ficha['numero_lote']) ?>
                </h3>
                <small class="text-muted text-end">
                    <strong>Estilo:</strong> <?= htmlspecialchars($ficha['estilo']) ?> |
                    <strong>Data:</strong> <?= formatar_data_br($ficha['data_brassagem']) ?>
                </small>
            </div>
        </h3>

        <!--div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h3 class="mb-0">
                    <= htmlspecialchars($ficha['nome_receita']) ?> - Lote <= htmlspecialchars($ficha['numero_lote']) ?>
                </h3>
                <div class="text-end">
                    <span class="badge bg-warning text-dark me-2">
                        🎨 <= htmlspecialchars($ficha['estilo']) ?>
                    </span>
                    <span class="text-muted">
                        📅 <= htmlspecialchars($ficha['data_brassagem']) ?>
                        <= formatar_data_br($ficha['data_brassagem']) ?>
                    </span>
                </div>
            </div-->
        <hr>

        <!-- Dados Técnicos -->
        <div class="section-title">Informações Técnicas</div>
        <table class="table table-bordered">
            <tr><th>OG</th><td><?= $ficha['og'] ?></td>
                <th>FG</th><td><?= $ficha['fg'] ?></td></tr>
            <tr><th>IBU</th><td><?= $ficha['ibu'] ?></td>
                <th>SRM</th><td><?= $ficha['srm'] ?></td></tr>
            <tr><th>Eficiência (%)</th><td><?= $ficha['eficiencia'] ?></td>
                <th>Volume Inicial (L)</th><td><?= $ficha['volume_inicial'] ?></td></tr>
            <tr><th>Volume Final (L)</th><td><?= $ficha['volume_final'] ?></td>
                <th>Tempo de Fervura (min)</th><td><?= $ficha['tempo_fervura'] ?></td></tr>
        </table>

        <!-- Maltes -->
        <h4 class="mt-5">Maltes Utilizados</h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Unidade</th>
                    <th class="no-print">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM ingredientes_malte WHERE ficha_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0):
                    while ($malte = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($malte['nome']) ?></td>
                            <td><?= $malte['quantidade'] ?></td>
                            <td><?= $malte['unidade'] ?></td>
                            <td class="no-print">
                                <a href="maltes/edit.php?id=<?= $malte['id'] ?>&ficha_id=<?= $id ?>" class="btn btn-primary btn-sm">Editar</a>
                                <a href="maltes/delete.php?id=<?= $malte['id'] ?>&ficha_id=<?= $id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir malte?')">Excluir</a>
                            </td>
                        </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="4" class="text-center">Nenhum malte cadastrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="maltes/create.php?ficha_id=<?= $id ?>" class="btn btn-success no-print">+ Adicionar Malte</a>

        <!-- Lupulos -->
        <h4 class="mt-5">Lúpulos Utilizados</h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>Alfa Ácido (%)</th>
                    <th>Quantidade (g)</th>
                    <th>Tempo de Adição</th>
                    <th class="no-print">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM ingredientes_lupulo WHERE ficha_id=?";
                $stmt = $conn->prepare($sql);

                if (!$stmt) {
                    $erro = tratarErro("Erro ao preparar a operação no banco.", $conn, $modo_dev);
                } elseif (!$stmt->bind_param("i", $id)) {
                    $erro = tratarErro("Erro ao vincular os dados.", $stmt, $modo_dev);
                } elseif (!$stmt->execute()) {
                    $erro = tratarErro("Erro ao executar a operação.", $stmt, $modo_dev);
                } /*else {
                    // sucesso
                    header("Location: lupulos.php?ficha_id=" . $ficha_id);
                    exit;
                }*/

                try {
                    $result = $stmt->get_result();
                } catch (mysqli_sql_exception $e) {
                    // Lida com a exceção
                    echo "mrf Erro: " . $e->getMessage() . "<br>";
                    $erro = tratarErro("Erro: " . $e->getMessage(), $stmt, $modo_dev);
                    // Pode registrar o erro em um log, exibir uma mensagem de erro para o usuário, etc.
                } 

                if ($result->num_rows > 0):
                    while ($lupulo = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($lupulo['nome']) ?></td>
                            <td><?= $lupulo['idx_alfa_acido'] ?>%</td>
                            <td><?= $lupulo['quantidade'] ?></td>
                            <td><?= htmlspecialchars($lupulo['tempo_adicao']) ?></td>
                            <td class="no-print">
                                <a href="lupulos/lupulos.php?ficha_id=<?= $id ?>&edit=<?= $lupulo['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="lupulos/lupulos.php?ficha_id=<?= $id ?>&delete=<?= $lupulo['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
                            </td>
                        </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="5" class="text-center">Nenhum lúpulo cadastrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="lupulos/lupulos.php?ficha_id=<?= $id ?>" class="btn btn-success no-print">+ Adicionar Lúpulo</a>

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
