<!--?php
$basePath = str_contains($_SERVER['PHP_SELF'], '/ficha/rampas/') ? '../../' : '../';
?-->

<?php
$depth = substr_count($_SERVER['PHP_SELF'], '/');
$basePath = str_repeat('../', $depth - 2); // considerando raiz em public/
?>

<!--nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="../index.html">
            <img src="../img/logo.png" alt="Pecos Brew" style="height:50px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" aria-controls="navbarNav" 
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../index.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php">Fichas de Brassagem</a></li>
            </ul>
        </div>
    </div>
</nav-->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= $basePath ?>index.html">
            <img src="<?= $basePath ?>img/logo.png" alt="Pecos Brew" style="height:50px;">
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $basePath ?>index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $basePath ?>ficha/index.php">Fichas de Brassagem</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="../index.html">
            <img src="../img/logo.png" alt="Pecos Brew" style="height:50px;">
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../index.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php">Fichas de Brassagem</a></li>
            </ul>
        </div>
    </div>
</nav-->
