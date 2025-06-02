<h4 class="mt-4">Rampas de Mostura</h4>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Temperatura (°C)</th>
            <th>Tempo (min)</th>
            <th>Descrição</th>
            <th>Hora Inicial</th>
            <th>Hora Final</th>
            <th>Temp. Mín. (°C)</th>
            <th>Temp. Máx. (°C)</th>
            <th class="no-print">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM rampas_mostura WHERE ficha_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0):
            while ($rampa = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $rampa['temperatura'] ?></td>
                    <td><?= $rampa['tempo'] ?></td>
                    <td><?= htmlspecialchars($rampa['descricao']) ?></td>
                    <td><?= $rampa['hora_inicial'] ?></td>
                    <td><?= $rampa['hora_final'] ?></td>
                    <td><?= $rampa['temperatura_min'] ?></td>
                    <td><?= $rampa['temperatura_max'] ?></td>
                    <td class="no-print">
                        <a href="rampas/edit.php?id=<?= $rampa['id'] ?>&ficha_id=<?= $id ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="rampas/delete.php?id=<?= $rampa['id'] ?>&ficha_id=<?= $id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir?')">Excluir</a>
                    </td>
                </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="8" class="text-center">Nenhuma rampa cadastrada.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<a href="rampas/create.php?ficha_id=<?= $id ?>" class="btn btn-success no-print">+ Adicionar Rampa</a>
