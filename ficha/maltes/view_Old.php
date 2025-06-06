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
        include_once("../../db/conexao.php");
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
