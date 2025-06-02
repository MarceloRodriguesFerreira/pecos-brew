<!--?php include("../db/conexao.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Fichas de Brassagem - Pecos Brew</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        .logo-img {
            height: 50px;
        }
    </style>
</head>
<body>

<-- Navbar ->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="../index.html">
            <img src="../img/logo.png" alt="Pecos Brew" class="logo-img">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" aria-controls="navbarNav" 
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Fichas de Brassagem</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<-- Conteúdo ->
<div class="container py-5">
    <h1 class="mb-4">Fichas de Brassagem</h1>
    <a href="create.php" class="btn btn-success mb-3">+ Nova Ficha</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome Receita</th>
                <th>Número do Lote</th>
                <th>Data</th>
                <th>Cervejeiro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <php
            $sql = "SELECT * FROM ficha_brassagem";
            $result = $conn->query($sql);

            if ($result->num_rows > 0):
                while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><= $row["id"] ?></td>
                        <td><= htmlspecialchars($row["nome_receita"]) ?></td>
                        <td><= htmlspecialchars($row["numero_lote"]) ?></td>
                        <td><= htmlspecialchars($row["data_brassagem"]) ?></td>
                        <td><= htmlspecialchars($row["cervejeiro_responsavel"]) ?></td>
                        <td>
                            <a href="edit.php?id=<= $row['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="delete.php?id=<= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir?')">Excluir</a>
                            <a href="view.php?id=<= $row['id'] ?>" class="btn btn-info btn-sm">Visualizar</a>
                        </td>
                    </tr>
            <php endwhile; else: ?>
                <tr><td colspan="6" class="text-center">Nenhuma ficha encontrada.</td></tr>
            <php endif; ?>
        </tbody>
    </table>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html -->

<?php include("../db/conexao.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Fichas de Brassagem - Pecos Brew</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        .logo-img { height: 50px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="../index.html">
            <img src="../img/logo.png" class="logo-img" alt="Pecos Brew">
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../index.html">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Fichas</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <h1 class="mb-4">Fichas de Brassagem</h1>
    <a href="create.php" class="btn btn-success mb-3">+ Nova Ficha</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Receita</th>
                <th>Lote</th>
                <th>Data</th>
                <th>Estilo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM ficha_brassagem";
        $result = $conn->query($sql);

        if ($result->num_rows > 0):
            while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><?= htmlspecialchars($row["nome_receita"]) ?></td>
                    <td><?= htmlspecialchars($row["numero_lote"]) ?></td>
                    <td><?= htmlspecialchars($row["data_brassagem"]) ?></td>
                    <td><?= htmlspecialchars($row["estilo"]) ?></td>
                    <td>
                        <a href="view.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">Ver</a>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir?')">Excluir</a>
                    </td>
                </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="6" class="text-center">Nenhuma ficha cadastrada.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>

