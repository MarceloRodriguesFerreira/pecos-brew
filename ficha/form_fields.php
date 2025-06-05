<div class="mb-3">
    <label class="form-label">Nome da Receita</label>
    <input type="text" name="nome_receita" class="form-control" 
           value="<?= isset($ficha['nome_receita']) ? $ficha['nome_receita'] : '' ?>" required>
</div>

<div class="mb-3">
    <label class="form-label">Estilo</label>
    <input type="text" name="estilo" class="form-control" 
           value="<?= isset($ficha['estilo']) ? $ficha['estilo'] : '' ?>">
</div>

<!--div class="mb-3">
    <label class="form-label">Número do Lote</label>
    <input type="text" name="numero_lote" class="form-control" 
           value="<?= isset($ficha['numero_lote']) ? $ficha['numero_lote'] : '' ?>" required>
</div>

<div class="mb-3">
    <label class="form-label">Data da Brassagem</label>
    <input type="date" name="data_brassagem" class="form-control" 
           value="<?= isset($ficha['data_brassagem']) ? $ficha['data_brassagem'] : '' ?>" required>
</div>

<div class="mb-3">
    <label class="form-label">Cervejeiro Responsável</label>
    <input type="text" name="cervejeiro_responsavel" class="form-control" 
           value="<?= isset($ficha['cervejeiro_responsavel']) ? $ficha['cervejeiro_responsavel'] : '' ?>">
</div-->

<!--Linha com 3 campos lado a lado -->
<div class="row mb-3">
    <div class="col">
        <label class="form-label">Número do Lote</label>
        <input type="text" name="numero_lote" class="form-control" 
               value="<?= isset($ficha['numero_lote']) ? $ficha['numero_lote'] : '' ?>" required>
    </div>
    <div class="col">
        <label class="form-label">Data da Brassagem</label>
        <input type="date" name="data_brassagem" class="form-control"
               value="<?= isset($ficha['data_brassagem']) ? $ficha['data_brassagem'] : '' ?>" required>
    </div>
    <div class="col">
        <label class="form-label">Cervejeiro Responsável</label>
        <input type="text" name="cervejeiro_responsavel" class="form-control"
               value="<?= isset($ficha['cervejeiro_responsavel']) ? $ficha['cervejeiro_responsavel'] : '' ?>">
    </div>
    <div class="col">
        <label class="form-label">Tempo de Fervura (min)</label>
        <input type="text" name="tempo_fervura" class="form-control"
               value="<?= isset($ficha['tempo_fervura']) ? $ficha['tempo_fervura'] : '' ?>">
    </div>
</div>


<h4 class="mt-4">Parâmetros Técnicos</h4>
<div class="row">
    <div class="col">
        <label>OG</label>
        <input type="text" name="og" class="form-control" value="<?= isset($ficha['og']) ? $ficha['og'] : '' ?>">
    </div>
    <div class="col">
        <label>FG</label>
        <input type="text" name="fg" class="form-control" value="<?= isset($ficha['fg']) ? $ficha['fg'] : '' ?>">
    </div>
    <div class="col">
        <label>IBU</label>
        <input type="text" name="ibu" class="form-control" value="<?= isset($ficha['ibu']) ? $ficha['ibu'] : '' ?>">
    </div>
    <div class="col">
        <label>SRM</label>
        <input type="text" name="srm" class="form-control" value="<?= isset($ficha['srm']) ? $ficha['srm'] : '' ?>">
    </div>
</div>

<div class="row mt-2">
    <div class="col">
        <label>Eficiência (%)</label>
        <input type="text" name="eficiencia" class="form-control" value="<?= isset($ficha['eficiencia']) ? $ficha['eficiencia'] : '' ?>">
    </div>
    <div class="col">
        <label>Volume Inicial (L)</label>
        <input type="text" name="volume_inicial" class="form-control" value="<?= isset($ficha['volume_inicial']) ? $ficha['volume_inicial'] : '' ?>">
    </div>
    <div class="col">
        <label>Volume Final (L)</label>
        <input type="text" name="volume_final" class="form-control" value="<?= isset($ficha['volume_final']) ? $ficha['volume_final'] : '' ?>">
    </div>
</div>

<h4 class="mt-4">Fermentação e Maturação</h4>
<div class="row">
    <div class="col">
        <label>Temp. Fermentação (°C)</label>
        <input type="text" name="temperatura_fermentacao" class="form-control" value="<?= isset($ficha['temperatura_fermentacao']) ? $ficha['temperatura_fermentacao'] : '' ?>">
    </div>
    <div class="col">
        <label>Tempo Fermentação (dias)</label>
        <input type="text" name="tempo_fermentacao" class="form-control" value="<?= isset($ficha['tempo_fermentacao']) ? $ficha['tempo_fermentacao'] : '' ?>">
    </div>
    <div class="col">
        <label>Temp. Maturação (°C)</label>
        <input type="text" name="temperatura_maturacao" class="form-control" value="<?= isset($ficha['temperatura_maturacao']) ? $ficha['temperatura_maturacao'] : '' ?>">
    </div>
    <div class="col">
        <label>Tempo Maturação (dias)</label>
        <input type="text" name="tempo_maturacao" class="form-control" value="<?= isset($ficha['tempo_maturacao']) ? $ficha['tempo_maturacao'] : '' ?>">
    </div>
</div>

<h4 class="mt-4">Envase</h4>
<div class="row">
    <div class="col">
        <label>Tipo de Envase</label>
        <input type="text" name="tipo_envase" class="form-control" value="<?= isset($ficha['tipo_envase']) ? $ficha['tipo_envase'] : '' ?>">
    </div>
    <div class="col">
        <label>Volume de Envase (L)</label>
        <input type="text" name="volume_envase" class="form-control" value="<?= isset($ficha['volume_envase']) ? $ficha['volume_envase'] : '' ?>">
    </div>
    <div class="col">
        <label>Carbonatação</label>
        <input type="text" name="carbonatacao" class="form-control" value="<?= isset($ficha['carbonatacao']) ? $ficha['carbonatacao'] : '' ?>">
    </div>
</div>

<div class="mb-3 mt-4">
    <label>Observações</label>
    <textarea name="observacoes" rows="4" class="form-control"><?= isset($ficha['observacoes']) ? $ficha['observacoes'] : '' ?></textarea>
</div>
