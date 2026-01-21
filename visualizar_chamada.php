<?php
// ================== CONFIGURAÇÃO ==================
$arquivo = 'registros_chamadas.json';
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Chamada não encontrada.");
}

// ================== LEITURA DO JSON ==================
if (!file_exists($arquivo)) {
    die("Arquivo de dados não encontrado.");
}

$json = file_get_contents($arquivo);
$registros = json_decode($json, true);

if (!is_array($registros)) {
    die("Erro ao ler os dados.");
}

// ================== LOCALIZA REGISTRO ==================
$registro = null;

foreach ($registros as $r) {
    if ((int)$r['id_chamada'] === (int)$id) {
        $registro = $r;
        break;
    }
}

if (!$registro) {
    die("Registro não localizado.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Visualizar Chamada</title>

<style>
body{font-family:Arial;background:#f4f4f4;padding:20px}
.container{
    background:white;
    padding:20px;
    border-radius:10px;
    max-width:950px;
    margin:auto;
}
h2{margin-bottom:10px}
.section{
    margin-top:18px;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
}
.section h3{
    margin:0 0 8px 0;
    font-size:17px;
}
.row{margin-bottom:6px}
.label{font-weight:bold}
pre{
    background:#f7f7f7;
    padding:10px;
    border-radius:6px;
    white-space:pre-wrap;
}
a{display:inline-block;margin-top:12px}
</style>
</head>

<body>

<div class="container">

<h2>Chamada #<?= htmlspecialchars($registro['id_chamada']) ?></h2>

<!-- TELEATENDENTE -->
<div class="section">
<h3>Teleatendente</h3>

<div class="row"><span class="label">Matrícula:</span> <?= htmlspecialchars($registro['matricula']) ?></div>
<div class="row"><span class="label">Nome:</span> <?= htmlspecialchars($registro['nome_teleatendente']) ?></div>
<div class="row">
    <span class="label">Data / Hora:</span>
    <?= htmlspecialchars($registro['data_atendimento']) ?>
    <?= htmlspecialchars($registro['hora_atendimento']) ?>
</div>
</div>

<!-- DESTINO / LOCAL -->
<div class="section">
<h3>Destino e Local da Chamada</h3>

<div class="row"><span class="label">Destino do Serviço:</span> <?= htmlspecialchars($registro['destino_servico']) ?></div>

<div class="row">
    <span class="label">Endereço:</span><br>
    <?= htmlspecialchars($registro['logradouro_chamada']) ?>
    <?= !empty($registro['numero_chamada']) ? ', '.htmlspecialchars($registro['numero_chamada']) : '' ?>
    <?= !empty($registro['complemento_chamada']) ? ' - '.htmlspecialchars($registro['complemento_chamada']) : '' ?><br>
    <?= htmlspecialchars($registro['bairro_chamada']) ?> -
    <?= htmlspecialchars($registro['municipio_chamada']) ?>
</div>

<div class="row"><span class="label">Telefone da ocorrência:</span> <?= htmlspecialchars($registro['telefone_chamada']) ?></div>
</div>

<!-- SOLICITANTE -->
<div class="section">
<h3>Solicitante</h3>

<div class="row"><span class="label">Nome:</span> <?= htmlspecialchars($registro['nome_solicitante']) ?></div>

<div class="row">
    <span class="label">Endereço:</span><br>
    <?= htmlspecialchars($registro['endereco_solicitante']) ?>
    <?= !empty($registro['numero_solicitante']) ? ', '.htmlspecialchars($registro['numero_solicitante']) : '' ?>
    <?= !empty($registro['complemento_solicitante']) ? ' - '.htmlspecialchars($registro['complemento_solicitante']) : '' ?><br>
    <?= htmlspecialchars($registro['bairro_solicitante']) ?> -
    <?= htmlspecialchars($registro['municipio_solicitante']) ?>
</div>

<div class="row"><span class="label">Telefone:</span> <?= htmlspecialchars($registro['telefone_solicitante']) ?></div>
</div>

<!-- HISTÓRICO -->
<div class="section">
<h3>Histórico / Natureza</h3>

<div class="row"><span class="label">Código natureza:</span> <?= htmlspecialchars($registro['codigo_natureza']) ?></div>

<pre><?= htmlspecialchars($registro['historico']) ?></pre>
</div>

<a href="lista_chamadas.php">⬅ Voltar</a>

</div>

</body>
</html>
