<?php
// ================= CONFIGURAÇÃO =================
$arquivo = 'registros_chamadas.json';

// ================= BATALHÕES =================
$batalhoes = [
"193 Bombeiros","197 Policia Civil","33º BPM /66º BPM","25º BPM 11° CIA ind",
"35º BPM/61º BPM","36º BPM/1ªCIA/8ª CIA","ATENDIMENTO REMOTO REDS",
"1º BPM - A","40º BPM/6ªCIA IND","5º BPM","49º BPM - A",
"1ª RPM - CPE","7 RPM B","PMMG/BPMRV/BPGD","52º BPM  1° CIA Ind",
"SUP DESP - 2ª/3ª RPM","22º BPM - A","22º BPM - B","BTL METROPOLE",
"41º BPM","CPE  / BPTRAN","34º BPM - A","16º BPM - A","16º BPM - B",
"34º BPM - B","13º BPM","49º BPM - B","48º BPM/7 Cia",
"39º BPM - A","18º BPM - A","7 RPM A"
];

// ================= LÊ JSON =================
if (!file_exists($arquivo)) {
    die("Arquivo de dados não encontrado.");
}

$json = file_get_contents($arquivo);
$registros = json_decode($json, true);

if (!is_array($registros)) {
    die("Erro ao ler os dados.");
}

// ================= FILTRO POR BATALHÃO =================
$batalhaoSelecionado = filter_input(INPUT_GET, 'batalhao');

$filtrados = array_filter($registros, function ($c) use ($batalhaoSelecionado) {

    $batalhaoAtual = trim($c['batalhao'] ?? '');

    if ($batalhaoSelecionado) {
        return $batalhaoAtual === $batalhaoSelecionado;
    }

    // Caixa de entrada (sem batalhão)
    return $batalhaoAtual === '';
});

// ================= ORDENA POR DATA =================
usort($filtrados, function ($a, $b) {
    return strtotime($b['data_atendimento'] ?? '') <=> strtotime($a['data_atendimento'] ?? '');
});
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Painel de Chamadas</title>

<style>
body{font-family:Arial;background:#f3f4f6;margin:0;padding:20px}

.pastas{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
    gap:15px;
    margin-bottom:25px;
}

.pasta{
    background:#fff;
    border:2px solid #ccc;
    border-radius:12px;
    padding:12px;
    text-align:center;
    font-weight:bold;
    cursor:pointer;
}

.pasta:hover{background:#eef3ff;border-color:#3b82f6}

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
    gap:20px;
}

.card{
    background:white;
    border:2px solid #ccc;
    border-radius:12px;
    padding:15px;
    min-height:150px;
    cursor:grab;
    box-shadow:0 2px 6px rgba(0,0,0,0.05);
}

.card:hover{
    border-color:#3b82f6;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
}

.status-dot{
    width:14px;
    height:14px;
    border-radius:50%;
    display:inline-block;
    margin-right:8px;
}
.status-aberto{background:#dc2626}
.status-encaminhada{background:#16a34a}
.status-encerrada{background:#000}

.btn-voltar{
    display:inline-block;
    margin-bottom:15px;
    padding:10px 16px;
    background:#1d4ed8;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
}

.btn-voltar:hover{
    background:#2563eb;
}
</style>
</head>
<body>

<h2>
<?= $batalhaoSelecionado
    ? "Batalhão: ".htmlspecialchars($batalhaoSelecionado)
    : "📥 Caixa de Entrada (Sem Batalhão)" ?>
</h2>

<a href="relatorio.php" class="btn-voltar">
    📥 Chamadas não encaminhadas
</a>

<div class="pastas">
<?php foreach($batalhoes as $b): ?>
    <div class="pasta" data-batalhao="<?= htmlspecialchars($b) ?>">
        📁 <?= htmlspecialchars($b) ?>
    </div>
<?php endforeach; ?>
</div>

<div class="grid">
<?php foreach ($filtrados as $c): ?>
<div class="card"
     draggable="true"
     data-id="<?= (int)$c['id_chamada'] ?>"
     onclick="abrirChamado(<?= (int)$c['id_chamada'] ?>, '<?= addslashes($c['batalhao'] ?? '') ?>')">

    <div style="display:flex;align-items:center;margin-bottom:8px;">
        <span class="status-dot status-<?= htmlspecialchars($c['status'] ?? 'aberto') ?>"></span>
        <strong><?= htmlspecialchars($c['codigo_natureza'] ?? '') ?></strong>
    </div>

    <?= htmlspecialchars($c['destino_servico'] ?? '') ?><br>
    ID: <?= (int)$c['id_chamada'] ?><br>
    <small><?= htmlspecialchars($c['data_atendimento'] ?? '') ?></small><br>
    <small>Batalhão: <?= !empty($c['batalhao']) ? htmlspecialchars($c['batalhao']) : "Não atribuído" ?></small>
</div>
<?php endforeach; ?>
</div>

<script>
document.querySelectorAll('.card').forEach(card=>{
    card.addEventListener('dragstart',e=>{
        e.stopPropagation();
        e.dataTransfer.setData('id',card.dataset.id);
    });
});

document.querySelectorAll('.pasta').forEach(pasta=>{
    pasta.addEventListener('dragover',e=>e.preventDefault());

    pasta.addEventListener('drop',e=>{
        fetch('mover_chamada.php',{
            method:'POST',
            headers:{'Content-Type':'application/json'},
            body:JSON.stringify({
                id:e.dataTransfer.getData('id'),
                batalhao:pasta.dataset.batalhao
            })
        }).then(()=>location.reload());
    });

    pasta.addEventListener('click',()=>{
        location='relatorio.php?batalhao='+encodeURIComponent(pasta.dataset.batalhao);
    });
});

function abrirChamado(id, batalhao){
    if(!batalhao || batalhao.trim() === ""){
        alert("⚠️ Atribua esta chamada a um batalhão antes de abrir.");
        return;
    }
    window.location = "relatorio_detalhe.php?id=" + id;
}
</script>

</body>
</html>
